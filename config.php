<?php

$connString = "mysql:host=localhost;dbname=db_43227198";
$user = "43227198";
$pass = "43227198";

$pdo = new PDO($connString, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>