<?php

   $sql = "
      CREATE TABLE `post_tag` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
         `post_id` bigint(20) NOT NULL,
         `tag_id` bigint(20) NOT NULL,
         PRIMARY KEY (`id`),
         KEY `post_id` (`post_id`),
         KEY `tag_id` (`tag_id`),
         CONSTRAINT `fk_post_tag_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
         CONSTRAINT `fk_post_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
   ";

   $stmt = $database->prepare($sql);

   if ($stmt->execute()) {
      logs('post_tag');
   }
