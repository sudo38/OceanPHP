<?php

   if (!function_exists('view_image')) {
    /**
     * Renders the view for displaying an image.
     *
     * This function loads the 'components.view_image' view and passes the image URL to it.
     *
     * @param string $url The URL or path to the image to be displayed.
     * @return void
     */
      function view_image(string $url) {
         view('components.view_image', ['image' => $url]);
      }
   }


   if (!function_exists('delete_record')) {
    /**
     * Renders the view for confirming the deletion of a record.
     *
     * This function loads the 'components.delete_record' view and passes the URL to handle the deletion.
     *
     * @param string $url The URL or route where the deletion will be processed.
     * @return void
     */
      function delete_record(string $url) {
         view('components.delete_record', ['url' => $url]);
      }
   }


   if (!function_exists('delete_file')) {
    /**
     * Deletes a file from the server.
     *
     * This function checks if the file exists in the specified path and deletes it.
     *
     * @param string $path The relative path to the file to be deleted.
     * @return bool Returns true if the file was successfully deleted, false if not.
     */
      function delete_file(string $path): bool {
         $path = config('file.upload').'/'.$path;

         if (file_exists($path)) {
            return unlink($path);
         }

         return false;
      }
   }


   if (!function_exists('remove_folder')) {
    /**
     * Removes a folder from the server.
     *
     * This function deletes the specified folder if it exists.
     * If the folder does not exist, it returns an error message.
     *
     * @param string $path The path of the folder to be deleted.
     * @return bool|string True on success, or an error message if the folder does not exist.
     */
      function remove_folder(string $path): bool|string {
         if (file_exists($path)) {
            return rmdir($path);
         }

         return "`$path` does not exists.";
      }
   }