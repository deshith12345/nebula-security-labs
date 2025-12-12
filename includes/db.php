<?php
// includes/db.php
$servername = "localhost";
$username = "root";
$password = ""; // default XAMPP local root password is empty
$dbname = "vulnweb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>