<?php

   $sql = "
      CREATE TABLE `posts` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
         `title` varchar(255) NOT NULL,
         `slug` varchar(255) NOT NULL,
         `intro` text NOT NULL,
         `content` longtext DEFAULT NULL,
         `image` varchar(255) DEFAULT NULL,
         `user_id` bigint(20) NOT NULL,
         `category_id` bigint(20) NOT NULL,
         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
         PRIMARY KEY (`id`),
         KEY `user_id` (`user_id`),
         KEY `category_id` (`category_id`),
         CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
         CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
   ";

   $stmt = $database->prepare($sql);

   if ($stmt->execute()) {
      logs('posts');
   }
