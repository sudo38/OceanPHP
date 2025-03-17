<?php

   if (!function_exists('controller')) {
   /**
    * Dynamically loads a controller file and calls the specified method, or executes a given callable.
    *
    * @param string|callable $handle A string in the format 'controller@method' or a callable.
    * @param array $vars             Additional variables to pass to the callable (if applicable).
    * @return mixed                  The result of the callable function or nothing if using a controller string.
    */
      function controller(string|callable $handle, array $vars=[]) {
         if (is_string($handle) && !empty($handle)) {
            $handle = explode('@', $handle);
            $function_name = end($handle);

            $file = config('controller.path').'/'.str_replace('.', '/', $handle[0]).'.php';

            if (file_exists($file)) {
               include $file;
               if ($vars) {
                  call_user_func($function_name, $vars[0]);
               } else {
                  call_user_func($function_name);
               }
            } else {
               echo '<h1
                     style="
                        margin-top:50px;
                        text-align:center;
                        font-family: sans-serif;
                     ">Controller Not Found
                     </h1>';
            }
         } elseif (is_callable($handle)) {
            return call_user_func($handle);
         }
      }
   }