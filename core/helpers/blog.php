<?php 

   if (!function_exists('subtitle')) {
      function subtitle($table, $col, $val, $route, $redirect, $prefix='admin/') {
         $row = get_items($table, $col, $val);

         if (!$row) {
            redirect($redirect);
         } else {
            $html = '<span style="font-size: 25px">
                           ( <a href="'.url($prefix.$route.$row[$col]).'">
                              '.$row['name'].'
                           </a> )
                     </span>';
                     
            return $html;
         }
      }
   }


   if (!function_exists('posts_related_tag')) {
      /**
     * Retrieves posts related to a specific tag.
     *
     * @param string $tags_table The name of the tags table.
     * @param string $key        The key to find the tag by.
     * @return array             An array of post IDs related to the tag.
     */
      function posts_related_tag (string $tags_table, string $key): array {
         $posts_related_tag = fetch_items($tags_table, '
            tags.id AS tag_id,
            tags.name AS tag_name,
            GROUP_CONCAT(posts.id SEPARATOR ", ") AS posts_id', '
            JOIN post_tag ON post_tag.tag_id = tags.id
            JOIN posts ON posts.id = post_tag.post_id
            GROUP BY tags.id, tags.name'
         );

         $tag_info = find_by_id($posts_related_tag, $key, request($key));
         $posts_id = explode(', ', $tag_info['posts_id']);

         return $posts_id;
      }
   }


   if (!function_exists('tags_related_post')) {
    /**
     * Retrieves tags related to a specific post.
     *
     * @param string $posts_table The name of the posts table.
     * @param int    $post_id     The ID of the post.
     * @return array              An associative array where keys are tag IDs and values are tag names.
     */
      function tags_related_post(string $posts_table, int $post_id): array {
         $tags_related_post = fetch_items($posts_table, '
            posts.id AS post_id,
            posts.title AS post_title,
            GROUP_CONCAT(tags.id SEPARATOR ", ") AS tags_id,
            GROUP_CONCAT(tags.name SEPARATOR ", ") AS tags_name', '
            JOIN post_tag ON posts.id = post_tag.post_id
            JOIN tags ON post_tag.tag_id = tags.id
            GROUP BY posts.id, posts.title'
         );

         $tags_info = find_by_id($tags_related_post, 'post_id', $post_id);
         $tags_id = array_values(explode(', ', $tags_info['tags_id']));
         $tags_name = array_values(explode(', ', $tags_info['tags_name']));
         $tags = zip($tags_id, $tags_name);

         return $tags;
      }
   }