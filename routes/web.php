<?php

   # Login
   route_get('login',         'login@index');
   route_post('do/login',     'login@do_login');

   # Register
   route_get('register',      'register@index');
   route_post('do/register',  'register@do_register');

   # Set Language
   route_get('lang',           function() {
      if (in_array(request('lang'), ['ar', 'en'])) {
         set_locale(request('lang'));
      }
   
      return back();
   });

   # Admin
   include 'admin.php';

   # Front
   include 'front.php';