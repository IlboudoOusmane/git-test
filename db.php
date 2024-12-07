<?php 
$user = "root";
$password = ""; 

try {
    $db = new PDO("mysql:host=localhost;dbname=gestion_ecole", $user, $password);
} catch (PDOException $e) {
    $e->getMessage();
    exit();
  }
?>