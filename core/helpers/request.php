<?php

   if (!function_exists('request')) {
    /**
     * Retrieves a value from the global `$_REQUEST` or `$_FILES` array.
     *
     * This function checks if the specified request variable is available in the `$_REQUEST` array.
     * If not, it checks the `$_FILES` array for file uploads.
     *
     * @param string $request The key of the request variable to retrieve.
     * @return mixed The value of the request variable if found, null if not found.
     */
      function request(string $request) {
         if (isset($_REQUEST[$request])) {
            return $_REQUEST[$request];
         } elseif (isset($_FILES[$request])) {
            return $_FILES[$request];
         }
      }
   }