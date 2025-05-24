<?php
// Prevent direct access to this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: apply.php");
    exit();
}

// Include database settings
require_once("settings.php");

// Initialize variables
$errors = array();
$success = false;
$eoi_number = '';

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Collect and sanitize form data
$job_reference = isset($_POST['Job']) ? sanitize_input($_POST['Job']) : '';
$first_name = isset($_POST['fname']) ? sanitize_input($_POST['fname']) : '';
$last_name = isset($_POST['lname']) ? sanitize_input($_POST['lname']) : '';
$date_of_birth = isset($_POST['date']) ? sanitize_input($_POST['date']) : '';
$gender = isset($_POST['Gender']) ? sanitize_input($_POST['Gender']) : '';
$street_address = isset($_POST['Street']) ? sanitize_input($_POST['Street']) : '';
$suburb = isset($_POST['Suburb']) ? sanitize_input($_POST['Suburb']) : '';
$state = isset($_POST['State']) ? sanitize_input($_POST['State']) : '';
$postcode = isset($_POST['Postcode']) ? sanitize_input($_POST['Postcode']) : '';
$email = isset($_POST['Email']) ? sanitize_input($_POST['Email']) : '';
$phone_number = isset($_POST['phone_number']) ? sanitize_input($_POST['phone_number']) : '';
$skills = isset($_POST['skills']) ? $_POST['skills'] : array();
$other_skills = isset($_POST['other_skills']) ? sanitize_input($_POST['other_skills']) : '';

// Basic validation
if (empty($job_reference)) $errors[] = "Job reference number is required.";
if (empty($first_name)) $errors[] = "First name is required.";
if (empty($last_name)) $errors[] = "Last name is required.";
if (empty($date_of_birth)) $errors[] = "Date of birth is required.";
if (empty($gender)) $errors[] = "Gender selection is required.";
if (empty($street_address)) $errors[] = "Street address is required.";
if (empty($suburb)) $errors[] = "Suburb/Town is required.";
if (empty($state)) $errors[] = "State is required.";
if (empty($postcode)) $errors[] = "Postcode is required.";
if (empty($email)) $errors[] = "Email address is required.";
if (empty($phone_number)) $errors[] = "Phone number is required.";
if (empty($skills)) $errors[] = "At least one technical skill must be selected.";

// Convert date from HTML 
if (!empty($date_of_birth)) {
    $date_parts = explode('-', $date_of_birth);
    if (count($date_parts) == 3) {
        $date_of_birth = $date_parts[2] . '/' . $date_parts[1] . '/' . $date_parts[0];
    }
}

// database operations
if (empty($errors)) {
    // Check connection
    if (!$conn) {
        $errors[] = "Database connection failed.";
    } else {
        // Create EOI table 
        $create_table_sql = "CREATE TABLE IF NOT EXISTS eoi (
            EOInumber INT AUTO_INCREMENT PRIMARY KEY,
            job_reference VARCHAR(10) NOT NULL,
            first_name VARCHAR(20) NOT NULL,
            last_name VARCHAR(20) NOT NULL,
            date_of_birth VARCHAR(10) NOT NULL,
            gender VARCHAR(10) NOT NULL,
            street_address VARCHAR(40) NOT NULL,
            suburb VARCHAR(40) NOT NULL,
            state VARCHAR(10) NOT NULL,
            postcode VARCHAR(4) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone_number VARCHAR(12) NOT NULL,
            skill1 VARCHAR(50),
            skill2 VARCHAR(50),
            other_skills TEXT,
            status VARCHAR(10) DEFAULT 'New',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($create_table_sql) === TRUE) {
            $skill1 = isset($skills[0]) ? $skills[0] : '';
            $skill2 = isset($skills[1]) ? $skills[1] : '';
            
            // Insert EOI record
            $insert_sql = "INSERT INTO eoi (job_reference, first_name, last_name, date_of_birth, gender, 
                                           street_address, suburb, state, postcode, email, phone_number, 
                                           skill1, skill2, other_skills, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";
            
            $stmt = $conn->prepare($insert_sql);
            if ($stmt) {
                $stmt->bind_param("ssssssssssssss", $job_reference, $first_name, $last_name, $date_of_birth, 
                                  $gender, $street_address, $suburb, $state, $postcode, $email, $phone_number, 
                                  $skill1, $skill2, $other_skills);
                
                if ($stmt->execute()) {
                    $eoi_number = $conn->insert_id;
                    $success = true;
                } else {
                    $errors[] = "Error inserting record: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $errors[] = "Error preparing statement: " . $conn->error;
            }
        } else {
            $errors[] = "Error creating table: " . $conn->error;
        }
    }
}

// Set page variables
$title = $success ? "Application Successful" : "Application Error";
$description = "EOI Processing Result";
$author = "Jacob";

// Include header
include("header.inc");
include("nav.inc");
?>

<section class="banner">
    <div class="banner-wrapper">
        <h1><?php echo $success ? "Application Submitted Successfully!" : "Application Error"; ?></h1>
    </div>
</section>

<div id="padding">
    <main>
        <div id="card-thing">
            <article>
                <?php if ($success): ?>
                    <h2>🎉 Thank You for Your Application!</h2>
                    <p>Your Expression of Interest has been successfully submitted.</p>
                    <div style="background-color: #DAEFE6; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                        <p><strong>Your EOI Number is: <?php echo str_pad($eoi_number, 4, '0', STR_PAD_LEFT); ?></strong></p>
                    </div>
                    <p>Please keep this number for your records. We will contact you if your application is successful.</p>
                    <p>
                        <a href="apply.php" style="color: #026473;">Submit Another Application</a> | 
                        <a href="index.php" style="color: #026473;">Return to Home</a>
                    </p>
                <?php else: ?>
                    <h2>❌ Application Submission Failed</h2>
                    <p>There were errors in your application:</p>
                    <div style="background-color: #ffebee; padding: 1rem; border-radius: 8px; border-left: 4px solid #f44336;">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <p><a href="apply.php" style="color: #026473;">← Please go back and correct the errors</a></p>
                <?php endif; ?>
            </article>
        </div>
    </main>
</div>

<?php
include("footer.inc");
?>
