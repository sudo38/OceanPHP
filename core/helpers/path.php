<?php

   if (!function_exists('base_path')) {
    /**
     * Gets the base path of the application with an optional additional path.
     *
     * This function returns the base directory of the project combined with the provided path.
     *
     * @param string $path The relative path to append to the base directory.
     * @return string The full base path combined with the given path.
     */
      function base_path(string $path): string {
         return getcwd()."/../$path";
      }
   }


   if (!function_exists('public_path')) {
    /**
     * Gets the public path of the application with an optional additional path.
     *
     * This function returns the public directory of the project combined with the provided path.
     *
     * @param string $path The relative path to append to the public directory.
     * @return string The full public path combined with the given path.
     */
      function public_path(string $path): string {
         return getcwd()."/$path";
      }
   }


   if (!function_exists('config')) {
    /**
     * Retrieves the configuration value based on the provided key.
     *
     * This function reads a configuration file located in the `config` directory, based on the dot-separated
     * key format (e.g., `app.name`) and returns the corresponding value.
     *
     * @param string $key The configuration key, formatted as `file.key` (e.g., `app.name`).
     * @return mixed The value corresponding to the configuration key.
     */
      function config(string $key): mixed {
         $config = explode('.', $key);

         if (count($config) > 0) {
            $result = include base_path("config/$config[0].php");
            return $result[$config[1]];
         }

         return null;
      }
   }