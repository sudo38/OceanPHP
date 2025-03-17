<?php

   if (!function_exists('view')) {
    /**
     * Display a view with the specified data.
     *
     * This function loads a view file from the specified path and renders it by passing the provided variables.
     * If the view file does not exist, a "View Not Found" message is displayed.
     *
     * @param string $path The path to the view file (dot notation).
     * @param array $vars  An associative array of variables to pass to the view.
     * @return void
     */
      function view(string $path, array $vars=[]) {
         $file = config('view.path').'/'.str_replace('.', '/', $path).'.php';

         if (file_exists($file)) {
            view_engine($file, $vars);
         } else {
            echo '<h1
                  style="
                     margin-top:50px;
                     text-align:center;
                     font-family: sans-serif;
                  ">
                     View Not Found
                  </h1>';
         }
      }
   }

   
   if (!function_exists('extend')) {
    /**
     * Extend a view with the specified path.
     *
     * This function attempts to load a view file and extend it by saving a modified version in storage.
     * The extended view file is returned as a path.
     *
     * @param string $path The path to the view file to extend (dot notation).
     * @return mixed       The path to the extended view file.
     */ 
      function extend(string $path) {
         $file= config('view.path').'/'.str_replace('.', '/', $path).'.php';

         if (file_exists($file)) {
            return view_engine($file, [], true);
         }
      }
   }


   if (!function_exists('view_engine')) {
    /**
     * Process and render a view file with the provided variables.
     *
     * This function reads the view file, processes it by replacing specific syntax with PHP code, and either
     * includes the file or saves it in storage depending on the `extend` flag.
     * 
     * @param string $view The path to the view file.
     * @param array $vars  An associative array of variables to pass to the view.
     * @param bool $extend If true, the modified view will be saved in storage; if false, it will be included directly.
     * @return void|string|null
     */
      function view_engine(string $view, array $vars=[], bool $extend=false) {
         if (is_array($vars)) {
            foreach ($vars as $key => $value) {
               ${$key} = $value;
            }
         }

         $file_name = base_path('storage/views/'.md5($view).'.php');
         $file_view = file_get_contents($view);

         if (!$file_view) {
            echo '<h1>Failed loading view file</h1>';
         }

         $file_view = str_replace('{{', '<?=', $file_view);
         $file_view = str_replace('}}', '?>', $file_view);
         
         $file_view = str_replace('@php', '<?php', $file_view);
         $file_view = str_replace('@endphp', '?>', $file_view);

         $file_view = preg_replace('/@include\s*\((.*\)*)\)/i', '<?php view($1) ?>', $file_view);
         $file_view = preg_replace('/@extends\s*\((.*\)*)\)/i', '<?php include extend($1) ?>', $file_view);

         $file_view = preg_replace('/@section\s*\((.*\)*)\)/i', '<?= ${$1} ?>', $file_view);
         $file_view = preg_replace('/@start\s*\((.*\)*)\)/i', '<?php ob_start() ?>', $file_view);
         $file_view = preg_replace('/@end\s*\((.*\)*)\)/i', '<?php ${$1} = ob_get_clean() ?>', $file_view);

         $file_view = preg_replace('/@title\s*\((.*\)*)\)/i', '<script> title($1) </script>', $file_view);
         $file_view = preg_replace('/@link\s*\((.*\)*)\)/i', '<script> link($1) </script>', $file_view);
         $file_view = preg_replace('/@script\s*\((.*\)*)\)/i', '<script> script($1) </script>', $file_view);

         $file_view = preg_replace('/@if\s*\((.*\)*)\)+/i', '<?php if($1): ?>', $file_view);
         $file_view = preg_replace('/@elseif\s*\((.*\)*)\)+/i', '<?php elseif($1): ?>', $file_view);
         $file_view = preg_replace('/@else/i', '<?php else: ?>', $file_view);
         $file_view = preg_replace('/@endif/i', '<?php endif ?>', $file_view);

         $file_view = preg_replace('/@while\s*\((.*\)*)\)+/i', '<?php while($1): ?>', $file_view);
         $file_view = preg_replace('/@endwhile/i', '<?php endwhile ?>', $file_view);

         $file_view = preg_replace('/@foreach\s*\((.*?) as (.*?)\)+/i', '<?php foreach($1 as $2): ?>', $file_view);
         $file_view = preg_replace('/@endforeach/i', '<?php endforeach ?>', $file_view);

         $file_view = preg_replace('/@for\s*\((.*\)*)\)+/i', '<?php for($1): ?>', $file_view);
         $file_view = preg_replace('/@endfor/i', '<?php endfor ?>', $file_view);


         $file_view = preg_replace('/@break/i', '<?php break ?>', $file_view);
         $file_view = preg_replace('/@continue/i', '<?php continue ?>', $file_view);



         file_put_contents($file_name, $file_view);

         if ($extend) {
            return $file_name;
         }
         
         include $file_name;
      }
   }