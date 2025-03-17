<?php

   try {
      return [
         'database' => new PDO("mysql:host=localhost;dbname=blog;charset=utf8;", 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
         ])
      ];
   } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
   }