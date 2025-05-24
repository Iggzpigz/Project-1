//As you have done in the labs use a PHP include file “settings.php” that contains the
host, user, password and database name connection variables, and use this in your PHP to
connect to your MySQL database on the local database server.

<?php
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "exhibition_db";

$conn = mysqli_connect(hostname: $host, username: $username, password: $password, database: $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
