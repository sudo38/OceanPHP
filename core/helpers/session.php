<?php

   if (!function_exists('session')) {
    /**
     * Retrieves or sets a session variable with optional encryption.
     *
     * If a value is provided, it encrypts and stores it in the session.
     * If no value is provided, it decrypts and returns the session value.
     *
     * @param string $key The session key to retrieve or set.
     * @param mixed $value (optional) The value to store in the session (default is null).
     * @return string The decrypted session value, or an empty string if the session key does not exist.
     */
      function session(string $key, mixed $value=null): string {
         if ($value) {
            $_SESSION[$key] = encrypt($value);
         }

         return isset($_SESSION[$key]) ? decrypt($_SESSION[$key]) : '';
      }
   }


   if (!function_exists('session_has')) {
    /**
     * Checks if a session variable exists.
     *
     * This function checks if the specified session key is set.
     *
     * @param string $key The session key to check.
     * @return bool Returns true if the session key exists, false otherwise.
     */
      function session_has(string $key): bool {
         return isset($_SESSION[$key]);
      }
   }


   if (!function_exists('session_flash')) {
    /**
     * Retrieves and deletes a flash session variable.
     *
     * This function retrieves a session variable, decrypts it, and then removes it from the session.
     *
     * @param string $key The session key to retrieve and remove.
     * @param mixed $value (optional) The value to set in the session (default is null).
     * @return string The decrypted flash session value, or an empty string if the session key does not exist.
     */
      function session_flash(string $key, mixed $value=null): string {
         $session = isset($_SESSION[$key]) ? decrypt($_SESSION[$key]) : '';
         session_forget($key);
         return $session;
      }
   }


   if (!function_exists('session_forget')) {
    /**
     * Deletes a session variable.
     *
     * This function removes the specified session variable from the session.
     *
     * @param string $key The session key to delete.
     * @return void
     */
      function session_forget(string $key) {
         if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
         }
      }
   }