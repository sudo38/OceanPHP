<?php

   if (!function_exists('storage')) {
    /**
     * Outputs a file for download from the server.
     *
     * This function sends the appropriate headers and reads the file
     * to output it for download if the file exists.
     *
     * @param string $path The path of the file to be delivered for download.
     * @return void
     */
      function storage(string $path) {
         if (file_exists($path)) {
            header('Content-Description: file from server');
            header('Content-Type: attachment; filename='.dirname($path));
            header('Expiers: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-length: '.filesize($path));
            readfile($path);
         }

         exit;
      }
   }


   if (!function_exists('storage_url')) {
    /**
     * Generates a URL for accessing a file in the storage directory.
     *
     * This function returns a URL pointing to the file in the storage directory.
     *
     * @param string $path The relative path of the file in storage.
     * @return string The URL to access the file in storage.
     */
      function storage_url(string $path): string {
         return url('storage/'.$path);
      }
   }


   if (!function_exists('store_file')) {
    /**
     * Stores an uploaded file to a specified location.
     *
     * This function moves an uploaded file from its temporary location
     * to a specified directory, creating any necessary directories.
     *
     * @param array|string $from The uploaded file array (from `$_FILES`)  or current file name.
     * @param string $to The target path where the file should be stored.
     * @return string The path where the file was stored..
     */
      function store_file(array|string $from, string $to): string {
         $to = ltrim($to, '/');
         $path = config('file.upload').'/'.$to;
         $exp = explode('/', $path);
         $file_name = end($exp);
         $path_without_file_name = str_replace($file_name, '', $path);

         if (!file_exists($path_without_file_name)) {
            mkdir($path_without_file_name, 0777, true);
         }
         
         if (is_array($from) && isset($from['tmp_name'])) {
            move_uploaded_file($from['tmp_name'], $path);
         } else {
            move_uploaded_file($from, $path);
         }

         return $to;
      }
   }


   if (!function_exists('file_name')) {
    /**
     * Generates a unique file name with extension based on the original file.
     *
     * This function returns a new file name with a unique ID and the original file extension.
     *
     * @param array|string $file The uploaded file array (from `$_FILES`) or current file name.
     * @param string $name The new file name (without extension).
     * @return string The new file name, or null if the file is not valid.
     */
      function file_name(array|string $file, string $name=''): string {
         if (is_array($file)) {
            $file_name_ext = explode('.', $file['name']);
            $file_name_ext = end($file_name_ext);

         } else {
            $file_name_ext = explode('.', $file);
            $file_name_ext = end($file_name_ext);
         }

         if ($name) {
            $new_file_name = $name.'.'.$file_name_ext;
         } else {
            $new_file_name = uniqid().'.'.$file_name_ext;
         }

         return $new_file_name;
      }
   }