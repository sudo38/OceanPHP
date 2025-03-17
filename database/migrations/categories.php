<?php

   $sql = "
      CREATE TABLE `categories` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
         `name` varchar(255) NOT NULL,
         `slug` varchar(255) NOT NULL,
         `desc` text NOT NULL,
         PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
   ";

   $stmt = $database->prepare($sql);

   if ($stmt->execute()) {
      logs('categories');
   }
