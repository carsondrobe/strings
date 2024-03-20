<?php

$connString = "mysql:host=localhost;dbname=90172180";
$user = "90172180";
$pass = "90172180";

$pdo = new PDO($connString, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>