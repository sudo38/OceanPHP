<?php

   if (!function_exists('validator')) {
    /**
     * Perform form validation on input data.
     * 
     * @param array $attributes   Associative array of attributes and their validation rules (e.g., 'email' => 'required|email')
     * @param array $trans        (optional) Custom translations for attribute names
     * @param string $http_header (optional) Defines response type: 'redirect' (default) or 'api'
     * @param string $back        (optional) URL to redirect back after validation failure
     * 
     * @return mixed Returns validated input values or validation errors
     */
      function validator(array $attributes, array $trans=[], string $http_header='redirect', string $back='') {
         $validations = [];

         foreach ($attributes as $attribute => $rules) {
            $error_msg = '';

            $value = request($attribute);

            if (is_string($value)) {
               $value = trim($value);
            }

            if ($attribute == 'email' && is_string($value)) {
               $value = sanitize_data($value, '.@');
            } elseif (!in_array($attribute, ['password', 'conf_password', 'conf_new_password']) && is_string($value)) {
               $value = sanitize_data($value);
            }

            $values[$attribute] = $value;
            $final_attr = $trans ? $trans[$attribute] : $attribute;
      
            foreach (explode('|', $rules) as $rule) {
               $rule = trim($rule);

               if ($rule == 'required' && (is_null($value) || empty($value))) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.required'));

                  break;
               }

               elseif ($rule == 'required' && is_array($value) && (count($value) == 0 || (count($value) > 0 && isset($value['name']) && empty($value['name'])))) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.required'));

                  break;
               }

               elseif (preg_match('/^unique/i', $rule)) {
                  $rule_array = explode(':', $rule);

                  if (count($rule_array) > 1) {
                     $get_unique_info = explode(',', $rule_array[1]);

                     $table = $get_unique_info[0];
                     $key = $attribute;

                     if (count($get_unique_info) > 1) {
                        $id = $get_unique_info[1];
                        $check_unique_db = exclude_item($table, $key, $value, $id);
                     } else {
                        $check_unique_db = get_items($table, $key, $value);
                     }

                     if ($check_unique_db) {
                        $error_msg = str_replace(':attr:', $final_attr, trans('validation.unique'));
                     }
                  }
               }

               elseif (preg_match('/^equal/i', $rule)) {
                  $rule_array = explode(':', $rule);

                  if (trim($value) !== request(trim($rule_array[1]))) {
                     $error_msg = str_replace(':attr:', $final_attr, trans('validation.equal'));
                  }
               }

               elseif (preg_match('/^min/i', $rule)) {
                  $rule_array = explode(':', $rule);

                  if (strlen($value) < (int) $rule_array[1]) {
                     $search = [
                        ':attr:',
                        ':value:',
                        ':unit:',
                     ];

                     $replace = [
                        $final_attr,
                        $rule_array[1],
                        trans('front.characters'),
                     ];

                     $error_msg = str_replace($search, $replace, trans('validation.min'));
                  }
               }

               elseif (preg_match('/^max/i', $rule)) {
                  $rule_array = explode(':', $rule);

                  if (strlen($value) > (int) $rule_array[1]) {
                     $search = [
                        ':attr:',
                        ':value:',
                        ':unit:',
                     ];

                     $replace = [
                        $final_attr,
                        $rule_array[1],
                        trans('front.characters'),
                     ];

                     $error_msg = str_replace($search, $replace, trans('validation.max'));
                  }
               }

               elseif (preg_match('/^in/i', $rule)) {
                  $rule_array = explode(':', $rule);

                  if (isset($rule_array[1])) {
                     $rule_in = explode(',', $rule_array[1]);

                     if (is_array($rule_in) && !in_array($value, $rule_in)) {
                        $error_msg = str_replace(':attr:', $value, trans('validation.in'));
                     }
                  }
               }

               elseif ($rule == 'string' && !is_alpha($value)) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.string'));
               }

               elseif ($rule == 'integer' && !filter_var($value, FILTER_VALIDATE_INT)) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.integer'));
               }

               elseif ($rule == 'numeric' && !filter_var($value, FILTER_VALIDATE_FLOAT)) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.numeric'));
               }

               elseif ($rule == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                  $error_msg = str_replace(':attr:', $value, trans('validation.email'));
               }

               elseif ($rule == 'image' && is_array($value) && isset($value['type']) && !empty($value['type']) && !str_contains($value['type'], 'image/')) {
                  $error_msg = str_replace(':attr:', $final_attr, trans('validation.image'));
               }
            }

            if ($error_msg) {
               $validations[$attribute] = $error_msg;
            }
         }
         
         session('old', json_encode($values));

         if (count($validations)) {
            if ($http_header == 'redirect') {
               session('validations', json_encode($validations));

               if ($back) {
                  redirect($back);
               } else {
                  back();
               }

            } elseif ($http_header == 'api') {
               return json_encode($validations, JSON_UNESCAPED_UNICODE);
            }
         } else {
            return $values;
         }
      }
   }


   if (!function_exists('error_msg')) {
    /**
     * Fetch or set error messages for specific attributes.
     *
     * @param string $offset The attribute name.
     * @param string $error (optional) Error message to set for the attribute.
     * @return string|null Returns the error message if set; otherwise null.
     */
      function error_msg(string $offset, string $error='') {
         $array = json_decode(session('validations'), true);

         if (!empty($error)) {
            $array[$offset] = $error;
            session('validations', json_encode($array));

         } elseif (!empty($offset) && isset($array[$offset])) {
            $err = $array[$offset];

            return $err;
         }
      }
   }


   if (!function_exists('old')) {
    /**
     * Retrieve the old input value for a specific form field after validation failure.
     * 
     * @param string $offset The name of the form field for which to get the old value
     * 
     * @return mixed         The old value of the form field or null if no old value is found
     */
      function old(string $offset) {
         $old_values = json_decode(session('old'), true);

         if (is_array($old_values) && in_array($offset, array_keys($old_values))){
            return $old_values[$offset];
         }
      }
   }


   if (!function_exists('sanitize_data')) {
    /**
     * Sanitize a string by removing unwanted characters.
     *
     * This function removes all characters from the input string except alphanumeric characters,
     * spaces, and any additional characters specified in the $exclude parameter.
     *
     * @param string $data    The input string to be sanitized.
     * @param string $exclude A string of characters to exclude from removal. These characters will
     *                        remain in the sanitized string. Defaults to an empty string.
     *
     * @return string The sanitized string containing only allowed characters.
     */
      function sanitize_data(string $data, string $exclude=''): string {
         $escaped_exclude = preg_quote($exclude, '/');
         $pattern = '/[^a-zA-Z0-9\s'.$escaped_exclude.'\x{0600}-\x{06FF}]/u';

         return preg_replace($pattern, '', $data);
      }
   }


   if (!function_exists('is_alpha')) {
    /**
     * Check if a string contains only alphabetic characters.
     *
     * This function uses a regular expression to determine if the provided string consists only of 
     * alphabetic characters, including letters from all languages (Unicode support).
     *
     * @param string $str    The input string to check.
     *
     * @return bool|int      Returns 1 if the string contains only alphabetic characters, 
     *                       0 if it contains any non-alphabetic characters, or false on error.
     */
      function is_alpha(string $str): bool|int {

         return preg_match('/[^a-zA-Z\x{0600}-\x{06FF}]/u', $str);
      }
   }