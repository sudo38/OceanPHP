<?php

   if (!auth(ADMIN)) {
      return redirect(aurl('dashboard'));
   }

   function index() {
      $profile = get_items('users', 'id', auth(ADMIN)->id);

      return view('admin.profile.index', [
         'profile' => $profile
      ]);
   }


   function update() {
      $data = validator(array(
         'name'     => 'required',
         'email'    => 'required|email|unique:users,'.auth(ADMIN)->id,
         ), array(
         'name'     => trans('profile.name'),
         'email'    => trans('profile.email'),
      ));

      $profile = update_item('users', $data, 'id='.auth(ADMIN)->id);
   
      if ($profile) {
         session('message', trans('alert.updated_successfully'));
         return redirect(aurl('profile'));
      }
   }