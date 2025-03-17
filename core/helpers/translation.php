<?php

   if (!function_exists('set_locale')) {
    /**
     * Set the application's locale.
     *
     * This function stores the selected language/locale in the session, so it can be used for translations.
     *
     * @param string $lang The language code to set as the locale (e.g., 'en', 'fr').
     * @return void
     */
      function set_locale(string $lang) {
         session('locale', $lang);
      }
   }


   if (!function_exists('trans')) {
    /**
     * Retrieve a translation string for a given key.
     *
     * This function looks up the translation for the specified key, using the current session's locale.
     * If the locale is not set, it defaults to the system's configured default or fallback language.
     *
     * @param string $key The translation key in the format 'file_name.key'.
     * @return string The translated string if found, or the key name if not found.
     */
      function trans(string $key): string {
         $dir_array = explode('.', $key);
         $file_name = $dir_array[0];

         if (session_has('locale')){
            $lang = session('locale');
         } else {
            $lang = config('lang.default') ? config('lang.default') : config('lang.fallback');
         }

         $file = config('lang.path')."/$lang/$file_name.php";

         if (file_exists($file)) {
            $result = include $file;

            return isset($result[end($dir_array)]) ? $result[end($dir_array)] : end($dir_array).'_key';
         }

         return "`$file` does not exists.";
      }
   }