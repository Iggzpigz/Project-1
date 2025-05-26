


<?php
// Database connection settings for XAMPP
$host = "localhost";
$username = "root";
$password = "";
$database = "project_part_2"; 

// Create connection
$conn = @mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    $conn_temp = @mysqli_connect($host, $username, $password);
    
    if (!$conn_temp) {
        die("Cannot connect to MySQL server. Make sure MySQL is running in XAMPP.");
    }
    
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn_temp->query($sql) === TRUE) {
        $conn_temp->close();
        // Reconnect to the new database
        $conn = mysqli_connect($host, $username, $password, $database);
        if (!$conn) {
            die("Error connecting to created database: " . mysqli_connect_error());
        }
    } else {
        die("Error creating database: " . $conn_temp->error);
    }
}

$jobs_table_sql = "CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Job VARCHAR(100) NOT NULL,
    JobDescription TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($jobs_table_sql) === TRUE) {
    // Check if jobs table is empty 
    $check_jobs = $conn->query("SELECT COUNT(*) as count FROM jobs");
    $row = $check_jobs->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Insert sample job data for team coordination
        $insert_jobs = "INSERT INTO jobs (Job, JobDescription) VALUES 
        ('Cloud Engineer', 'Design and maintain cloud infrastructure systems for optimal performance and security.'),
        ('Software Developer', 'Develop and maintain software applications using modern programming languages.')";
        $conn->query($insert_jobs);
    }
}
?>
