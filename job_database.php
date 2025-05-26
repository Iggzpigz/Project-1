<?php
require_once "settings.php";
include("header.inc");
include("nav.inc");
# connect to database
$conn = @mysqli_connect($host, $username, $password, $database);

    if ($conn) {
        $query = "SELECT * FROM jobs";
        $result = mysqli_query ($conn, $query);
        if ($result) {}
        else {}
        mysqli_close($conn);
    } else echo "<p>Unable to connect to the database.</p>";
?>
<!--
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Job Title</th><th>Job Description</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Job'] . "</td>";
        echo "<td>" . $row['JobDescription'] . "</td>";
        echo "</tr>";
    } 
--> 
<section class="banner">
    <div class="banner-wrapper">
        <h1>Jobs Database</h1>
    </div>
</section>

<div id="padding">
    <main>
        <div id="card-thing">
            <article>
                <table>
                    <tr>
                        <td>Job Title</td>
                        <td colspan="2">Job Description</td>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['Job'] . "</td>";
                        echo "<td colspan'2'>" . $row['JobDescription'] . "</td>";
                        echo "</tr>";
                    }?>
                </table> 
            </article>
        </div>
    </main>
</div>
<?php
include("footer.inc");
?>