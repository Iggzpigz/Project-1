<html>
    <head></head>
    <body>
    <?php 
    require_once "settings.php";
    $conn = @mysqli_connect($host,$username,$password,$database);


    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Job</th><th>Job Description</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Job'] . "</td>";
        echo "<td>" . $row['JobDescription'] . "</td>";
        echo "</tr>";
    } 
    ?>
    </body>
</html>