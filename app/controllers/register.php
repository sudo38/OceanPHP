<?php

   function index() {
      if (auth(ADMIN)) {
         return redirect(ADMIN.'/dashboard');
      }
   
      return view('register');
   }

   function do_register() {
      $data = validator(array(
         'name'          => 'required|string',
         'email'         => 'required|email|unique:users',
         'password'      => 'required|min:4|max:10',
         'conf_password' => 'required|equal:password',
         ), array(
         'name'          => trans('register.name'),
         'email'         => trans('register.email'),
         'password'      => trans('register.password'),
         'conf_password' => trans('register.conf_password'),
      ));
   
      unset($data['conf_password']);
   
      $data['password'] = bcrypt($data['password']);
      $user = create_item('users', $data);
   
      if ($user) {
         return redirect(url('login'));
      }
   }