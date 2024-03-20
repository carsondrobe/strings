<?php
// Path: config.php
//Server Configuration
$host_name = "localhost";
$db_user = "90172180";
$db_pass = "90172180";
$db_name = "db_90172180";

$conn = mysqli_connect("localhost", "90172180", "90172180", "db_90172180");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
