//As you have done in the labs use a PHP include file “settings.php” that contains the
host, user, password and database name connection variables, and use this in your PHP to
connect to your MySQL database on the local database server.


<?php
// Database connection settings for XAMPP
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "exhibition_db";

// Create connection
$conn = @mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    $conn = @mysqli_connect($host, $username, $password);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        // Reconnect to the new database
        $conn = mysqli_connect($host, $username, $password, $database);
    } else {
        die("Error creating database: " . $conn->error);
    }
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
