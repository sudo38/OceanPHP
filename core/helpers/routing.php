<?php

   define('ADMIN', 'admin');
   $routes = [];

   if (!function_exists('segment')) {
    /**
     * Get the current URL segment.
     *
     * Retrieves the current request URI, trims the leading slash, removes query
     * parameters, and returns the clean segment.
     *
     * @return string The cleaned URL segment.
     */
      function segment(): string {
         $segment = ltrim($_SERVER['REQUEST_URI'], '/');
         $segment = explode('?', $segment)[0];
         
         return $segment;
      }
   }

   if (!function_exists('route_get')) {
    /**
     * Register a GET route.
     *
     * Adds a GET route to the global routes array, converting route placeholders (e.g., {id}) 
     * into regex patterns for matching.
     *
     * @param string $segment The route segment.
     * @param string|callable $handle The controller method to handle the request.
     */
      function route_get(string $segment, string|callable $handle) {
         global $routes;

         if (!in_array($segment, ['/', ''])) {
            $segment = '/'.ltrim($segment, '/');
         }

         $segment = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([a-zA-Z0-9_-]+)', $segment);

         $routes['GET'][] = [
            'segment' => $segment,
            'handle'  => $handle
         ];
      }
   }


   if (!function_exists('route_post')) {
    /**
     * Register a POST route.
     *
     * Similar to `route_get`, but for POST requests. Transforms placeholders into regex
     * patterns for matching.
     *
     * @param string $segment         The route segment.
     * @param string|callable $handle The controller method to handle the request.
     */
      function route_post(string $segment, string|callable $handle) {
         global $routes;

         if (!in_array($segment, ['/', ''])) {
            $segment = '/'.ltrim($segment, '/');
         }

         $segment = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $segment);

         $routes['POST'][] = [
            'segment' => $segment,
            'handle'  => $handle
         ];
      }
   }

   if (!function_exists('get')) {
    /**
     * Shortcut for defining a GET route.
     *
     * Returns the arguments required to register a GET route.
     *
     * @param string $segment         The route segment.
     * @param string|callable $handle The controller method.
     * @return array                  An array containing the function name and arguments.
     */
      function get(string $segment, string|callable $handle): array {

         return [
            'funcName' => 'route_get',
            'funcArgs' => func_get_args()
         ];
      }
   }

   if (!function_exists('post')) {
    /**
     * Shortcut for defining a POST route.
     *
     * Returns the arguments required to register a POST route.
     *
     * @param string $segment         The route segment.
     * @param string|callable $handle The controller method.
     * @return array                  An array containing the function name and arguments.
     */
      function post(string $segment, callable|string $handle): array {

         return [
            'funcName' => 'route_post',
            'funcArgs' => func_get_args()
         ];
      }
   }


   if (!function_exists('route_group')) {
    /**
     * Group routes with a common prefix.
     *
     * Groups multiple routes under a shared prefix.
     *
     * @param array $params  Parameters for the group (e.g., 'prefix').
     * @param array $methods The routes to group.
     */
      function route_group(array $params, array $methods) {
         $prefix = $params['prefix'];

         foreach ($methods as $method) {
            $arr = explode('/', $method['funcArgs'][0]);
            $arg1 = $prefix.'/';

            foreach ($arr as $a) {
               $arg1 .= $a.'/';
            }

            $arg1 = rtrim($arg1, '/');
            $arg2 = $prefix.'.'.$method['funcArgs'][1];
            $method_name = $method['funcName'];

            call_user_func($method_name, $arg1, $arg2);
         }
      }
   }


   if (!function_exists('run')) {
    /**
     * Execute the routing logic.
     *
     * Matches the current request URI and method against the registered routes.
     * If no match is found, returns a 404 or 405 response.
     */
      function run() {
         global $routes;

         $GET_ROUTES = isset($routes['GET']) ? $routes['GET'] : [];
         $POST_ROUTES = isset($routes['POST']) ? $routes['POST'] : [];

         $page_found = false;
         foreach($GET_ROUTES as $GET_ROUTE) {
            if (preg_match('#^'.$GET_ROUTE['segment'].'$#', '/'.segment(), $matches)) {
               array_shift($matches);
               controller($GET_ROUTE['handle'], $matches);
               $page_found = true;

               break;
            }
         }
         
         if (!$page_found) {
            $page_found = false;
            $page_handle = null;

            foreach($POST_ROUTES as $POST_ROUTE) {
               if (preg_match('#^'.$POST_ROUTE['segment'].'$#', '/'.segment(), $matches)) {
                  array_shift($matches);
                  $page_handle = $POST_ROUTE['handle'];
                  $page_found = true;
                  break;
               }
            }

            if (!$page_found) {
               header('HTTP/1.1 404 Not Found');
               view('components.404');
               exit;

            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
               controller($page_handle, $matches);

            } else {
               header('HTTP/1.1 405 Method Not Allowed');
               header('Allow: POST');
               view('components.405');
               exit;
            }
         }
      }
   }


   if (!function_exists('url')) {
    /**
     * Generate a full URL.
     *
     * Combines the current scheme, host, and a given path.
     *
     * @param string $segment The URL path segment.
     * @return string         The full URL.
     */
      function url(string $segment): string {
         $url =  'http://';
         $url .= $_SERVER['HTTP_HOST'];

         if (!in_array($segment, ['/', ''])) {
            $url .= '/'.ltrim($segment, '/');
         }

         return $url;
      }
   }


   if (!function_exists('aurl')) {
    /**
     * Generate an admin URL.
     *
     * Combines the base URL with the 'admin' prefix and a given segment.
     *
     * @param string $segment The URL path segment.
     * @return string         The admin URL.
     */
      function aurl(string $segment): string {
         $aurl = 'http://';
         $aurl .= $_SERVER['HTTP_HOST'];

         if (in_array($segment, ['/', ''])) {
            $aurl .= '/'.ADMIN;
         } else {
            $aurl .= '/'.ADMIN.'/'.ltrim($segment, '/');
         }

         return $aurl;
      }
   }


   if (!function_exists('redirect')) {
     /**
     * Redirect to a given path or URL.
     * Sends a redirect header to the browser and exits the script.
     *
     * @param string $path The path or URL to redirect to.
     */
      function redirect(string $path) {
         $path_parse = parse_url($path);

         if (isset($path_parse['scheme']) && isset($path_parse['host'])) {
            header('Location: '.$path);
         } else {
            header('Location: '.url($path));
         }

         exit;
      }
   }


   if (!function_exists('back')) {
    /**
     * Redirect to the previous page.
     *
     * Uses the HTTP_REFERER header to redirect the user back.
     */
      function back() {
         header('Location: '.$_SERVER['HTTP_REFERER']);
         exit;
      }
   }