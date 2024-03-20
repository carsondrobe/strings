<?php
// Path: config.php
//Server Configuration
// $host_name = "localhost";
// $db_user = "90172180";
// $db_pass = "90172180";
// $db_name = "db_90172180";

// Personal Connection
$host_name = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "strings";

$conn = mysqli_connect("$host_name", "$db_user", "$db_pass", "$db_name");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
