<?php

   ob_start();

   $helpers_dir = __DIR__.'/helpers';
   $helpers = scandir($helpers_dir);

   foreach ($helpers as $helper) {
      if (!in_array($helper, ['.', '..'])) {
         include $helpers_dir."/$helper";
      }
   }

   ini_set('log_errors', 1);
   ini_set('error_log', 'ocean.log');
   ini_set('display_errors', 1);
   ini_set('error_reporting', E_ALL);

   ini_set('session.save_path', config('session.session_save_path'));
   ini_set('session.cookie_lifetime', config('session.delay_timeout'));

   session_start();

   $database = config('connect.database');
   require_once base_path('routes/web.php');