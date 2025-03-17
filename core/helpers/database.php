<?php

   if (!function_exists('create_item')) {
    /**
     * Inserts a new record into the specified table.
     * 
     * @param string $table  The name of the table.
     * @param array $params  Associative array of column names and their values.
     * @return array         Returns success status and the last inserted row ID.
     */
      function create_item(string $table, array $params): array {
         global $database;

         $keys = '';
         $values = '';
         
         foreach(array_keys($params) as $param) {
            $keys .= "`$param`, ";
            $values .= ":$param, ";
         }

         $keys = rtrim($keys, ', ');
         $values = rtrim($values, ', ');
         $stmt = $database->prepare("INSERT INTO $table($keys) VALUES($values)");

         foreach($params as $param => $arg) {
            $stmt->bindValue($param, $arg);
         }

         return [
            'success' => $stmt->execute(),
            'row_id'  => $database->lastInsertId(),
         ];
      }
   }


   if (!function_exists('update_item')) {
    /**
     * Updates a record in the specified table.
     * 
     * @param string $table   The name of the table.
     * @param array $params   Associative array of column names and their new values.
     * @param string $cond    Condition for the update (e.g., "id = 1").
     * @param string $special Optional column to exclude from the update query.
     * @return bool           Returns true on success, false otherwise.
     */
      function update_item(string $table, array $params, string $cond, string $special=''): bool {
         global $database;
         $query = "";
         
         foreach(array_keys($params) as $param) {
            if ($param != $special) {
               $query .= "`$param` = :$param, ";
            }
         }
         
         $query = rtrim($query, ', ');
         $stmt = $database->prepare("UPDATE $table SET $query WHERE $cond");

         foreach($params as $param => $arg) {
            $stmt->bindValue($param, $arg);
         }

         return $stmt->execute();
      }
   }


   if (!function_exists('delete_item')) {
    /**
     * Deletes a record from the specified table.
     * 
     * @param string $table    The name of the table.
     * @param string $key      The column name for the condition.
     * @param string $value    The value for the condition.
     * @param string $operator Comparison operator (default is '=').
     * @return bool            Returns true on success, false otherwise.
     */
      function delete_item(string $table, string $key, string $value, string $operator='='): bool {
         global $database;
      
         $stmt = $database->prepare("DELETE FROM $table WHERE $key $operator :value");
         $stmt->bindParam('value', $value);

         return $stmt->execute();
      }
   }


   if (!function_exists('search_items')) {
    /**
     * Searches for records in a table based on a LIKE condition.
     * 
     * @param string $table   The name of the table.
     * @param string $key     The column to search in.
     * @param string $value   The search value.
     * @param string $cols    Columns to retrieve (default is '*').
     * @return array          Returns matching records as an array.
     */
      function search_items(string $table, string $key, string $value, string $cols="*"): array {
         global $database;
      
         $value = "%$value%";
         $stmt = $database->prepare("SELECT $cols FROM $table WHERE $key LIKE :value");
         $stmt->bindParam("value", $value);
         $stmt->execute();

         if ($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
         } elseif ($stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
         }

         return [];
      }
   }


   if (!function_exists('exclude_item')) {
    /**
     * Fetches a record that matches a condition, excluding a specific ID.
     * 
     * @param string $table   The name of the table.
     * @param string $key     Column name to match.
     * @param string $value   Value to match.
     * @param int $id         ID to exclude.
     * @return mixed          Matching record or null if none found.
     */
      function exclude_item(string $table, string $key, string $value, int $id) {
         global $database;

         $stmt = $database->prepare("SELECT * FROM $table WHERE $key = :value AND id != :id");
         $stmt->bindParam('value', $value);
         $stmt->bindParam('id', $id);
         $stmt->execute();

         if ($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
         }
      }
   }


   if (!function_exists('get_data')) {
     /**
     * Fetches all records from a table.
     * 
     * @param string $table    The name of the table.
     * @return array           All records from the table.
     */
      function get_data(string $table): array {
         global $database;

         $stmt = $database->prepare("SELECT * FROM $table");
         $stmt->execute();

         if ($stmt->rowCount() == 1) {
            return [$stmt->fetch(PDO::FETCH_ASSOC)];
         } elseif ($stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
         }

         return [];
      }
   }


   if (!function_exists('get_items')) {
    /**
     * Fetches records from a database table with optional filtering.
     * 
     * @param string $table    The name of the table.
     * @param string $key      Column name for the condition.
     * @param string $value    Value to match.
     * @param int $limit       Maximum number of records to fetch (default is 100).
     * @param string $cols     Columns to select (default is '*').
     * @return array           Matching records or null if none found.
     */
      function get_items(string $table, string $key='', string $value='', int $limit=100, string $cols='*'): array {
         global $database;
      
         if ($key) {
            $cond = " WHERE $key = :value";
         } else {
            $cond = "";
         }

         $stmt = $database->prepare("SELECT $cols FROM $table".$cond." LIMIT ".$limit);

         if ($value) {
            $stmt->bindParam('value', $value);
         }

         $stmt->execute();

         if ($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
         } elseif ($stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
         }

         return [];
      }
   }


   if (!function_exists('fetch_items')) {
     /**
     * Fetches records with optional conditions and joins.
     * 
     * @param string $table     The name of the table.
     * @param string $cols      Columns to select.
     * @param string $join_str  Join clauses for the query.
     * @param array $cond_args  Optional array of conditions for filtering.
     * @param string $key       Column name for an additional condition.
     * @param string $value     Value to match for the additional condition.
     * @return array            Matching records.
     */
      function fetch_items(string $table, string $cols, string $join_str, array $cond_args=[], string $key='', string $value='') {
         global $database;
         
         $cond = '';
         if ($cond_args) {
            $cond = ' WHERE ';
            foreach($cond_args as $i => $arg){
               $cond .= $table.'.id = :value_'.$i.' OR ';
            }

            $cond = rtrim($cond, ' OR ');
         } elseif($key && $value) {
            $cond = ' WHERE '.$key.' = :value';
         }

         $stmt = $database->prepare("SELECT $cols FROM $table ".$join_str.$cond);

         if ($cond_args) {
            foreach($cond_args as $i => $arg){
               $stmt->bindValue('value_'.$i, $arg);
            }
         } elseif($key && $value) {
            $stmt->bindParam('value', $value);
         }
         
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
   }


   if (!function_exists('pagination')) {
     /**
     * Paginates an array or a table.
     *
     * @param array|string $data The data to paginate (array or table name).
     * @param int $limit         The number of items per page.
     *
     * @return array             Returns an array containing paginated data and pagination details.
     */
      function pagination(array|string $data, int $limit, string $cols="*"):array {
         global $database;

         if (isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0) {
            $current_page = $_GET['p'] - 1;
         } else {
            $current_page = 0;
         }

         if (is_array($data)) {
            $start = $current_page * $limit;
            $total_records = count($data);
            $total_page = ceil($total_records / $limit);
            $page_data = array_slice($data, $start, $limit);
            $records = $page_data;
         } else {
            $start = $current_page * $limit;

            $total_records_query = $database->prepare("SELECT $cols FROM $data");
            $total_records_query->execute();

            $total_records = $total_records_query->rowCount();
            $total_page = ceil($total_records / $limit);

            $stmt = $database->prepare("SELECT $cols FROM $data LIMIT {$start}, {$limit}");
            $stmt->execute();

            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }

         if ($current_page >= $total_page) {
            $start = $total_page + 1;
         }
         
         return [
            'records'      => $records,
            'render'       => render($total_page),
            'total_page'   => $total_page,
            'current_page' => $total_page,
         ];
      }
   }


   if (!function_exists('render')) {
    /**
     * Renders HTML pagination links.
     *
     * @param int $total_page  The total number of pages.
     *
     * @return string          Returns the HTML string for the pagination links.
     */
      function render(int $total_page): string {
         if (request('p') <= 0 ){
            $request_page = 1;
         } elseif (request('p') > $total_page ) {
            $request_page = $total_page;
         } else {
            $request_page = request('p');
         }

         $url = str_replace('?&', '?', preg_replace("/([&?])p=[^&]*/", '', $_SERVER['REQUEST_URI']));

         if (strpos($url, '?')) {
            $link = url($url).'&p=';
         } else {
            $link = url($url).'?p=';
         }

         $current_page = $request_page >= $total_page ? $total_page : $request_page;
         $previous_disabled = (empty(request('p')) || $current_page == 1) ? 'disabled' : '';
         $previous_page = !empty(request('p'))  ? $request_page - 1 : $total_page;

         $html = '<ul class="pagination justify-content-center">
                     <li class="page-item">
                        <a class="page-link '.$previous_disabled.'" href="'.$link.$previous_page.'" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        </a>
                     </li>';

         for ($i=1; $i <= $total_page; $i++) {
            $active = $current_page == $i ? 'active' : '';
            $html .= "<li class='page-item'>
                        <a class='page-link ".$active."' href='$link$i'>$i</a>
                     </li>";
         }

         if (strpos($url, '?')) {
            $link = url($url).'&p=';
         } else {
            $link = url($url).'?p=';
         }

         $next_disabled = (!empty(request('p')) && $current_page == $total_page) ? 'disabled' : '';
         $next_page = !empty(request('p')) ? $request_page + 1 : 1;

         $html .=    '<li class="page-item">
                        <a class="page-link '.$next_disabled.'" href="'.$link.$next_page.'" aria-label="Next">
                           <span aria-hidden="true">&raquo;</span>
                        </a>
                     </li>
                  </ul>';
                  
         return $html;
      }
   }
