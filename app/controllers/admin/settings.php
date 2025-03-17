<?php

   if (!auth(ADMIN)) {
      return redirect(aurl('dashboard'));
   }


   function index() {

      return view('admin.profile.settings');
   }


   function update() {
      $data = validator(array(
         'old_password'      => 'required',
         'new_password'      => 'required|min:4|max:10',
         'conf_new_password' => 'required|equal:new_password',
         ), array(
         'old_password'      => trans('settings.old_password'),
         'new_password'      => trans('settings.new_password'),
         'conf_new_password' => trans('settings.conf_new_password'),
      ));
      
      $user = get_items('users', 'email', auth(ADMIN)->email);
      
      if (hash_check($data['old_password'], $user['password'])) {
         $password = bcrypt($data['new_password']);
         $profile = update_item('users', ['password' => $password], 'id='.auth(ADMIN)->id);

         if ($profile) {
            session('message', trans('alert.updated_successfully'));
            return redirect(aurl('settings'));
         }
      } else {
         error_msg('old_password', str_replace(':attr:', trans('settings.old_password'), trans('validation.equal')));

         return back();
      }
   }