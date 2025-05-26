<?php
// settings.php should be included for database credentials
// but theres nothing there rn, FIX THIS LATER FUTURE ME
include('settings.php');
include('header.inc');
include('nav.inc');
// reminder do not hard-code user and pwd
$conn = mysqli_connect("localhost", "root", "", "project_part_2");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// checks to see if forms are submitted or not
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'list_all':
        listalleoi($conn);
        break;
    
    case 'list_by_position':
        listbypos($conn);
        break;

    case 'list_by_applicant':
        listbyapplicant($conn);
        break;

    case 'delete_by_position':
        deletebypos($conn);
        break;

    case 'change_status':
        changestatus($conn);
        break;

    default:
        displayForm();
        break;
}

function listalleoi($conn) {
    $query = "SELECT * FROM expressions_of_interest";
    $result = mysqli_query($conn, $query);
    
    
    echo "<h2>All EOIs</h2>";
    echo "<table border='1'>";
    echo "<tr><th>EOI Number</th><th>Job Reference Number</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['EOInumber']}</td>
                <td>{$row['JobReferenceNumber']}</td>
                <td>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['Status']}</td>
              </tr>";
              $isnull = false;
    }
    echo "</table>";

    if ($isnull) {
        echo "<p>No result found.</p>";
    }
}

function listbypos($conn) {
    $jobRef = isset($_POST['job_reference']) ? $_POST['job_reference'] : '';
    
    if ($jobRef) {
        $query = "SELECT * FROM expressions_of_interest WHERE JobReferenceNumber = '$jobRef'";
        $result = mysqli_query($conn, $query);
        
        echo "<h2>EOIs for Job Reference Number: $jobRef</h2>";
        echo "<table border='1'>";
        echo "<tr><th>EOI Number</th><th>Job Reference Number</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['EOInumber']}</td>
                    <td>{$row['JobReferenceNumber']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>{$row['Status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Please enter a valid job reference number.</p>";
    }
}

function listbyapplicant($conn) {
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    
    if ($firstName || $lastName) {
        $query = "SELECT * FROM expressions_of_interest WHERE FirstName LIKE '%$firstName%' AND LastName LIKE '%$lastName%'";
        $result = mysqli_query($conn, $query);
        
        echo "<h2>EOIs for Applicant: $firstName $lastName</h2>";
        echo "<table border='1'>";
        echo "<tr><th>EOI Number</th><th>Job Reference Number</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['EOInumber']}</td>
                    <td>{$row['JobReferenceNumber']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>{$row['Status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Please enter a valid first name or last name.</p>";
    }
}

function deletebypos($conn) {
    $jobRef = isset($_POST['job_reference_delete']) ? $_POST['job_reference_delete'] : '';
    
    if ($jobRef) {
        $query = "DELETE FROM expressions_of_interest WHERE JobReferenceNumber = '$jobRef'";
        if (mysqli_query($conn, $query)) {
            echo "<p>All EOIs for Job Reference Number: $jobRef have been deleted.</p>";
        } else {
            echo "<p>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Please enter a valid job reference number to delete.</p>";
    }
}

function changestatus($conn) {
    $eoiNumber = isset($_POST['eoi_number']) ? $_POST['eoi_number'] : '';
    $newStatus = isset($_POST['new_status']) ? $_POST['new_status'] : '';
    
    if ($eoiNumber && $newStatus) {
        $query = "UPDATE expressions_of_interest SET Status = '$newStatus' WHERE EOInumber = '$eoiNumber'";
        if (mysqli_query($conn, $query)) {
            echo "<p>Status of EOI #$eoiNumber has been updated to $newStatus.</p>";
        } else {
            echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Please enter a valid EOI number and new status.</p>";
    }
}

// navigation form
function displayForm() {
    echo "<h1>Manage EOIs</h1>";
    echo "<form action='manage.php?action=list_all' method='get'>
            <button type='submit'>List all EOIs</button>
          </form>";

    echo "<h2>List EOIs for a Job Position</h2>";
    echo "<form action='manage.php?action=list_by_position' method='post'>
            Job Reference Number: <input type='text' name='job_reference' required>
            <button type='submit'>List EOIs</button>
          </form>";

    echo "<h2>List EOIs for an Applicant</h2>";
    echo "<form action='manage.php?action=list_by_applicant' method='post'>
            First Name: <input type='text' name='first_name'>
            Last Name: <input type='text' name='last_name'>
            <button type='submit'>List EOIs</button>
          </form>";

    echo "<h2>Delete EOIs for a Job Position</h2>";
    echo "<form action='manage.php?action=delete_by_position' method='post'>
            Job Reference Number: <input type='text' name='job_reference_delete' required>
            <button type='submit'>Delete EOIs</button>
          </form>";

    echo "<h2>Change EOI Status</h2>";
    echo "<form action='manage.php?action=change_status' method='post'>
            EOI Number: <input type='text' name='eoi_number' required>
            New Status: 
            <select name='new_status'>
                <option value='New'>New</option>
                <option value='Current'>Current</option>
                <option value='Final'>Final</option>
            </select>
            <button type='submit'>Change Status</button>
          </form>";
}
include("footer.inc");
?>
