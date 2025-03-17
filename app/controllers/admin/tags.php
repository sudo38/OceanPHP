<?php

   function index() {
      $paginate = pagination('tags', 8);
      $tags = $paginate['records'];
      $links = $paginate['render'];

      return view('admin.tags.index', [
         'tags'  => $tags,
         'links' => $links,
      ]);
   }


   function detail($id) {
      $tag = get_items('tags', 'id', $id);

      if (!$tag) {
         return redirect(aurl('tags'));
      }

      return view('admin.tags.detail', [
         'tag' => $tag
      ]);
   }


   function add() {

      return view('admin.tags.add');
   }


   function store() {
      $data = validator(array(
         'name'     => 'required',
         'desc'     => 'required'
         ), array(
         'name'     => trans('tags.name'),
         'desc'     => trans('tags.desc'),
      ));
   
      $data['slug'] = slug($data['name']);
   
      $tag = create_item('tags', $data);
   
      if ($tag) {
         session('message', trans('alert.added_successfully'));
         return redirect(aurl('tags'));
      }
   }


   function edit($id) {      
      $tag = get_items('tags', 'id', $id);

      if (!$tag) {
         return redirect(aurl('tags'));
      }

      return view('admin.tags.edit', [
         'tag' => $tag,
      ]);
   }


   function update($id) {
      $tag = get_items('tags', 'id', $id);

      if (!$tag) {
         return redirect(aurl('tags'));
      }

      $data = validator(array(
         'name'     => 'required',
         'desc'     => 'required'
         ), array(
         'name'     => trans('tags.name'),
         'desc'     => trans('tags.desc'),
      ));

      $data['slug'] = slug($data['name']);
      $tag = update_item('tags', $data, 'id='.$id);

      if ($tag) {
         session('message', trans('alert.updated_successfully'));
         return redirect(aurl('tags'));
      }
   }


   function delete($id) {
      $tag = get_items('tags', 'id', $id);

      if (!$tag) {
         return redirect(aurl('tags'));
      }
   
      $is_deleted = delete_item('tags', 'id', $id);
      
      if ($is_deleted) {
         session('message', trans('alert.deleted_successfully'));
         return redirect(aurl('tags'));
      }
   }