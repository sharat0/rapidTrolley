<?php
$hostname="localhost";
$database="StoreCourier";
$username="root";
$password="root@123";
$conn=mysqli_connect($hostname, $username, $password);
$db=mysqli_select_db($conn, $database);

date_default_timezone_set('Asia/Kolkata');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

?>