<?php

   if (!function_exists('auth')) {
    /**
     * Retrieves the authenticated user's information for a specific role from the session.
     *
     * @param string $role The role for which the authentication data is retrieved.
     * @return object|null The authenticated user's data as an object, or null if the role is not in the session.
     */
      function auth(string $role): object|null {
         if (session_has($role)) {
            return json_decode(session($role));
         }

         return null;
      }
   }