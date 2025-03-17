<?php

   function index() {
      if (request('user_id')) {
         $key = 'user_id';
         $value = request($key);
         $posts_id = [];
         $subtitle = subtitle('users', 'id', $value, 'users/view?id=', aurl('posts'));
   
      }  elseif (request('category_id')) {
         $key = 'category_id';
         $value = request($key);
         $posts_id = [];
         $subtitle = subtitle('categories', 'id', $value, 'categories/view?id=', aurl('posts'));
   
      } elseif (request('tag_id')) {
         $key = '';
         $value = '';
         $posts_id = posts_related_tag('tags', 'tag_id');
         $subtitle = subtitle('tags', 'id', request('tag_id'), 'tags/', aurl('posts'));
   
      } else {
         $key = '';
         $value = '';
         $subtitle = '';
         $posts_id = [];
      }
   
      $posts = fetch_items('posts',
         '
            posts.*,
            users.id as user_id,
            users.name as author,
            categories.id as category_id,
            categories.name as category
         ','
            JOIN users ON posts.user_id = users.id
            JOIN categories ON posts.category_id = categories.id
         ',
         $posts_id,
         $key,
         $value
      );
      
      $comma = setup()->dir == 'rtl' ? '، ' : ', ';
   
      $paginate = pagination($posts, 8);
      $posts = $paginate['records'];
      $links = $paginate['render'];
   
      return view('admin.posts.index', [
         'posts'    => $posts,
         'links'    => $links,
         'comma'    => $comma,
         'subtitle' => $subtitle
      ]);
   }


   function detail() {
      $post = get_items('posts', 'id', request('id'));

      if (!$post) {
         return redirect(aurl('posts'));
      }
   
      $user = get_items('users', 'id', $post['user_id']);
      $image = storage_url($post['image']);
      $tags = tags_related_post('posts', $post['id']);
      $created_at = format_date($post['created_at']);
   
      return view('admin.posts.detail', [
         'post'       => $post,
         'user'       => $user,
         'tags'       => $tags,
         'image'      => $image,
         'created_at' => $created_at,
      ]);
   }


   function add() {
      $tags = get_data('tags');
      $categories = get_data('categories');

      return view('admin.posts.add', [
         'tags'       => $tags,
         'categories' => $categories,
      ]);
   }


   function store() {
      $data = validator(array(
         'title'       => 'required',
         'image'       => 'required|image',
         'intro'       => 'required',
         'content'     => 'required',
         'tags'        => 'required',
         'category_id' => 'required',
         ), array(
         'title'       => trans('posts.title'),
         'image'       => trans('posts.image'),
         'intro'       => trans('posts.intro'),
         'content'     => trans('posts.content'),
         'tags'        => trans('posts.tags'),
         'category_id' => trans('posts.category'),
         )
      );
   
      $data['slug']       = slug($data['title']);
      $data['user_id']    = auth(ADMIN)->id;
      $data['created_at'] = now(); 
      $data['updated_at'] = now();

      $data['image'] = store_file($data['image'], 'posts/'.file_name($data['image'], $data['slug']));
   
      unset($data['tags']);
      $post = create_item('posts', $data);
   
      if ($post['success']) {
         $tags = $_POST['tags'];
         $post_id = $post['row_id'];
   
         foreach($tags as $tag_id) {
            $post_tag = create_item('post_tag', [
               'post_id' => $post_id,
               'tag_id' => $tag_id
            ]);
         }
   
         if ($post_tag['success']) {
            session('message', trans('alert.added_successfully'));
            return redirect(aurl('posts'));
         }
      }
   }


   function edit() {
      $post = get_items('posts', 'id', request('id'));

      if (!$post) {
         return redirect(aurl('posts'));
      }
   
      $tags = get_data('tags');
      $categories = get_data('categories');
      $selected_tags = get_items('post_tag', 'post_id', $post['id']);

      if (is_multidimensional_array($selected_tags)) {
         $selected_tags = array_column($selected_tags, 'tag_id');
      } else {
         $selected_tags = [$selected_tags['tag_id']];
      }
   
      return view('admin.posts.edit', [
         'post'          => $post,
         'tags'          => $tags,
         'categories'    => $categories,
         'selected_tags' => $selected_tags,
      ]);
   }


   function update() {
      $post = get_items('posts', 'id', request('id'));

      if (!$post) {
         return redirect(aurl('posts'));
      }
      
      $data = validator(array(
         'title'       => 'required',
         'image'       => 'image',
         'intro'       => 'required',
         'content'     => 'required',
         'tags'        => 'required',
         'category_id' => 'required',
         ), array(
         'title'       => trans('posts.title'),
         'image'       => trans('posts.image'),
         'intro'       => trans('posts.intro'),
         'content'     => trans('posts.content'),
         'tags'        => trans('posts.tags'),
         'category_id' => trans('posts.category'),
         )
      );
   
      $data['slug']       = slug($data['title']);
      $data['user_id']    = auth(ADMIN)->id;
      $data['updated_at'] = now();

      if (is_array($data['image']) && isset($data['image']['name']) && !empty($data['image']['name'])) {
         if (delete_file($post['image'])) {
            $data['image'] = store_file($data['image'], 'posts/'.file_name($data['image'], $data['slug']));
         }
      } else {
         $from = public_path('storage/'.$post['image']);
         $to = public_path('storage/posts/'.file_name($post['image'], $data['slug']));
         
         if (rename($from, $to)) {
            $data['image'] = 'posts/'.file_name($post['image'], $data['slug']);
         }
      }
   
      unset($data['tags']);
   
      $is_updated = update_item('posts', $data, 'id='.request('id'));
   
      if ($is_updated) {
         $is_deleted = delete_item('post_tag', 'post_id', $post['id']);
   
         if ($is_deleted) {
            $tags = $_POST['tags'];
            $post_id = $post['id'];
   
            foreach($tags as $tag_id) {
               $post_tag = create_item('post_tag', [
                  'post_id' => $post_id,
                  'tag_id' => $tag_id
               ]);
            }
   
            if ($post_tag['success']) {
               session('message', trans('alert.updated_successfully'));
               return redirect(aurl('posts'));
            }
         }
      }
   }


   function delete() {
      $post = get_items('posts', 'id', request('id'));

      if (!$post) {
         return redirect(aurl('posts'));
      }
   
      delete_file($post['image']);
   
      $is_deleted = delete_item('posts', 'id', request('id'));
      
      if ($is_deleted) {
         session('message', trans('alert.deleted_successfully'));
         return redirect(aurl('posts'));
      }
   }

   function is_multidimensional_array(array $array) {
      return isset($array[0]) && is_array($array[0]);
   }