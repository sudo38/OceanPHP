<?php

   if (!function_exists('setup')) {
    /**
     * Returns an object with language and direction settings.
     *
     * @return object An object containing `lang` (language) and `dir` (direction).
     */
      function setup(): object {
         $setup = new stdClass();

         if (session_has('locale') && session('locale') == 'ar') {
            $setup->lang = session('locale');
            $setup->dir = 'rtl';
         } else {
            $setup->lang = 'en';
            $setup->dir = 'ltr';
         }

         return $setup;
      }
   }

   if (!function_exists('slug')) {
    /**
     * Converts a string into a URL-friendly slug.
     *
     * @param string $str The input string to be converted.
     * @return string     The generated slug.
     */
      function slug(string $str): string {
         $slug = strtolower($str);
         $slug = preg_replace('/[^a-z0-9-]+/', ' ', $slug);
         $slug = preg_replace('/\s+/', '-', $slug);
         $slug = preg_replace('/-+/', '-', $slug);
         $slug = trim($slug, '-');

         return $slug;
      }
   }


   if (!function_exists('asset')) {
    /**
     * Generates a full URL for an asset located in the 'assets' directory.
     *
     * @param string $segment The relative path to the asset.
     * @return string         The full URL to the asset.
     */
      function asset(string $segment): string {
         return url('assets/'.$segment);
      }
   }


   if (!function_exists('dd')) {
    /**
     * Dumps the given data using `print_r` or `var_dump` based on the mode and stops the script execution.
     *
     * @param mixed  $data The data to be dumped.
     * @param string $mode The mode of dumping ('p' for `print_r`, 'v' for `var_dump`).
     * @return mixed This function does not return a value (terminates the script).
     */
      function dd(mixed $data, string $mode='p'): mixed {
         echo '<pre>';
         if ($mode='p') {
            print_r($data);
         } elseif ($mode='v') {
            var_dump($data);
         }
         echo '</pre>';

         die;
      }
   }


   if (!function_exists('zip')) {
    /**
     * Combines two arrays into a key-value paired associative array.
     *
     * @param array $arr1 The first array (keys).
     * @param array $arr2 The second array (values).
     * @return array      The zipped associative array.
     */
      function zip(array $arr1, array $arr2): array {
         $zipped_array = [];
         $length = min(count($arr1), count($arr2));
      
         for ($i = 0; $i < $length; $i++) {
            $zipped_array[$arr1[$i]] = $arr2[$i];
         }
      
         return $zipped_array;
      }
   }


   if (!function_exists('find_by_id')) {
    /**
     * Searches for an element in an array by a specific column and ID.
     *
     * @param array  $arr    The array to search in.
     * @param string $id_col The column name to match.
     * @param int    $id     The ID to search for.
     * @return mixed         The found element or null if not found.
     */
      function find_by_id(array $arr, string $id_col, int $id): mixed {
         foreach ($arr as $element) {
            if ($element[$id_col] == $id) {
               return $element;
            }
         }
         
         return null;
      }
   }