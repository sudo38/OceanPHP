<?php

   if (!function_exists('bcrypt')) {
    /**
     * Hashes a password using the bcrypt algorithm.
     *
     * @param string $password The password to be hashed.
     * @return string The hashed password.
     */
      function bcrypt(string $password): string {
         return password_hash($password, PASSWORD_BCRYPT);
      }
   }


   if (!function_exists('hash_check')) {
    /**
     * Verifies a given password against a hashed password.
     *
     * @param string $password The plain text password to verify.
     * @param string $hash The hashed password to compare against.
     * @return bool True if the password matches the hash, false otherwise.
     */
      function hash_check(string $password, string $hash): bool {
         return password_verify($password, $hash);
      }
   }