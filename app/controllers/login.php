<?php

   function index() {
      if (auth(ADMIN)) {
         return redirect(ADMIN.'/dashboard');
      }
   
      return view('login');
   }

   function do_login() {
      $data = validator(array(
         'email'      => 'required|email',
         'password'   => 'required',
      ), array(
         'email'      => trans('login.email'),
         'password'   => trans('login.password'),
      ));
   
      $user = get_items('users', 'email', $data['email']);
   
      if (!$user || !hash_check($data['password'], $user['password'])) {
         session('login_failed', trans('login.login_failed'));
         return redirect('login');
      } else {
         session(ADMIN, json_encode($user));
         return redirect(ADMIN.'/dashboard');
      }
   }
