<?php

   function index() {
      $paginate = pagination('categories', 8);
      $categories = $paginate['records'];
      $links = $paginate['render'];
      
      return view('admin.categories.index', [
         'links'      => $links,
         'categories' => $categories,
      ]);
   }


   function detail() {
      $category = get_items('categories', 'id', request('id'));

      if (!$category) {
         return redirect(aurl('categories'));
      }

      return view('admin.categories.detail', [
         'category' => $category,
      ]);
   }

   function add() {
      return view('admin.categories.add');
   }


   function store() {
      $data = validator(array(
         'name'     => 'required',
         'desc'     => 'required',
         ), array(
         'name'     => trans('categories.name'),
         'desc'     => trans('categories.desc'),
      ));
   
      $data['slug'] = slug($data['name']);
      $category = create_item('categories', $data);
   
      if ($category) {
         session('message', trans('alert.added_successfully'));
         return redirect(aurl('categories'));
      }
   }


   function edit() {
      $category = get_items('categories', 'id', request('id'));

      if (!$category) {
         return redirect(aurl('categories'));
      }

      return view('admin.categories.edit', [
         'category' => $category,
      ]);
   }


   function update() {
      $category = get_items('categories', 'id', request('id'));

      if (!$category) {
         return redirect(aurl('categories'));
      }

      $data = validator(array(
         'name'     => 'required',
         'desc'     => 'required',
         ), array(
         'name'     => trans('categories.name'),
         'desc'     => trans('categories.desc'),
      ));
   
      $data['slug'] = slug($data['name']);
      $category = update_item('categories', $data, 'id='.request('id'));
   
      if ($category) {
         session('message', trans('alert.updated_successfully'));
         return redirect(aurl('categories'));
      }
   }


   function delete() {
      $category = get_items('categories', 'id', request('id'));

      if (!$category) {
         return redirect(aurl('categories'));
      }

      $is_deleted = delete_item('categories', 'id', request('id'));
      
      if ($is_deleted) {
         session('message', trans('alert.deleted_successfully'));
         return redirect(aurl('categories'));
      }
   }