<?php

   $sql = "
      CREATE TABLE `users` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
         `name` varchar(255) NOT NULL,
         `email` varchar(255) NOT NULL,
         `password` varchar(255) NOT NULL,
         PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
   ";

   $stmt = $database->prepare($sql);

   if ($stmt->execute()) {
      logs('users');
   }
