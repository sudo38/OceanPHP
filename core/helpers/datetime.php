<?php

   if (!function_exists('now')) {
    /**
     * Get the current date and time in the format 'Y-m-d H:i:s'.
     * This function returns the current date and time based on the server's timezone.
     * The format returned is suitable for storing timestamps in a database.
     *
     * @return string The current date and time as a string in 'Y-m-d H:i:s' format.
     */
      function now(): string {
         return date('Y-m-d H:i:s');
      }
   }


   if (!function_exists('format_date')) {
    /**
     * Formats a given date string into a specified format.
     *
     * @param string $date   The date string to be formatted. (e.g., '2025-01-09')
     * @param string $format The format in which the date should be returned. 
     *                       Default is 'F d, Y' (e.g., "January 09, 2025").
     *                       Supported format specifiers:
     *                       - `F` : Full month name (e.g., January)
     *                       - `M` : Short month name (e.g., Jan)
     *                       - `d` : Day of the month (e.g., 09)
     *                       - `Y` : Year (e.g., 2025)
     *                       - `l` : Full weekday name (e.g., Thursday)
     * @return string The formatted date string with the first character capitalized.
     */
      function format_date(string $date, string $format='M d, Y'): string {
         $date = new DateTime($date);
         $date = $date->format($format);

         return ucfirst($date);
      }
   }