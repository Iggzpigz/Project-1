<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: apply.php");
    exit();
}

include_once("settings.php");

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

// validate date format
function validate_date($date) {
    $date_parts = explode('/', $date);
    if (count($date_parts) != 3) return false;
    
    $day = intval($date_parts[0]);
    $month = intval($date_parts[1]);
    $year = intval($date_parts[2]);
    
    return checkdate($month, $day, $year);
}

// Function to validate postcode based on state
function validate_postcode($postcode, $state) {
    $postcode = intval($postcode);
    
    switch($state) {
        case 'VIC':
            return ($postcode >= 3000 && $postcode <= 3999) || ($postcode >= 8000 && $postcode <= 8999);
        case 'NSW':
            return ($postcode >= 1000 && $postcode <= 2999) || ($postcode >= 9000 && $postcode <= 9999);
        case 'QLD':
            return ($postcode >= 4000 && $postcode <= 4999) || ($postcode >= 9000 && $postcode <= 9999);
        case 'NT':
            return ($postcode >= 800 && $postcode <= 999);
        case 'WA':
            return ($postcode >= 6000 && $postcode <= 6999);
        case 'SA':
            return ($postcode >= 5000 && $postcode <= 5999);
        case 'TAS':
            return ($postcode >= 7000 && $postcode <= 7999);
        case 'ACT':
            return ($postcode >= 200 && $postcode <= 299) || ($postcode >= 2600 && $postcode <= 2699);
        default:
            return false;
    }
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

// Validation
if (empty($job_reference)) {
    $errors[] = "Job reference number is required.";
}

if (empty($first_name)) {
    $errors[] = "First name is required.";
} elseif (strlen($first_name) > 20) {
    $errors[] = "First name must be maximum 20 characters.";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
    $errors[] = "First name must contain only alphabetic characters.";
}

if (empty($last_name)) {
    $errors[] = "Last name is required.";
} elseif (strlen($last_name) > 20) {
    $errors[] = "Last name must be maximum 20 characters.";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
    $errors[] = "Last name must contain only alphabetic characters.";
}

// Convert date from HTML format (yyyy-mm-dd) to dd/mm/yyyy format
if (!empty($date_of_birth)) {
    $date_parts = explode('-', $date_of_birth);
    if (count($date_parts) == 3) {
        $formatted_date = $date_parts[2] . '/' . $date_parts[1] . '/' . $date_parts[0];
        if (!validate_date($formatted_date)) {
            $errors[] = "Invalid date of birth format. Use dd/mm/yyyy.";
        }
        $date_of_birth = $formatted_date;
    }
} else {
    $errors[] = "Date of birth is required.";
}

if (empty($gender)) {
    $errors[] = "Gender selection is required.";
}

if (empty($street_address)) {
    $errors[] = "Street address is required.";
} elseif (strlen($street_address) > 40) {
    $errors[] = "Street address must be maximum 40 characters.";
}

if (empty($suburb)) {
    $errors[] = "Suburb/Town is required.";
} elseif (strlen($suburb) > 40) {
    $errors[] = "Suburb/Town must be maximum 40 characters.";
}

if (empty($state)) {
    $errors[] = "State is required.";
}

if (empty($postcode)) {
    $errors[] = "Postcode is required.";
} elseif (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
} elseif (!validate_postcode($postcode, $state)) {
    $errors[] = "Postcode does not match the selected state.";
}

if (empty($email)) {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email address format.";
}

if (empty($phone_number)) {
    $errors[] = "Phone number is required.";
} elseif (!preg_match("/^[\d\s]{8,12}$/", $phone_number)) {
    $errors[] = "Phone number must be 8-12 digits, spaces allowed.";
}

if (empty($skills)) {
    $errors[] = "At least one technical skill must be selected.";
}

// Enhancement: Check if "Other" skill is selected but other_skills field is empty
if (in_array('other', $skills) && empty($other_skills)) {
    $errors[] = "Please specify other skills when 'Other' is selected.";
}

// Enhancement: Validate that other_skills is not empty when provided
if (!empty($other_skills) && strlen(trim($other_skills)) < 10) {
    $errors[] = "Other skills description must be at least 10 characters long.";
}

// If no errors, proceed with database operations
if (empty($errors)) {
    // Check if connection exists from settings.php
    if (!$conn) {
        $errors[] = "Database connection failed.";
    } else {
        // Create EOI table if it doesn't exist
        $create_table_sql = "CREATE TABLE IF NOT EXISTS eoi (
            EOInumber INT AUTO_INCREMENT PRIMARY KEY,
            job_reference VARCHAR(10) NOT NULL,
            first_name VARCHAR(20) NOT NULL,
            last_name VARCHAR(20) NOT NULL,
            date_of_birth VARCHAR(10) NOT NULL,
            gender ENUM('Male', 'Female', 'Other') NOT NULL,
            street_address VARCHAR(40) NOT NULL,
            suburb VARCHAR(40) NOT NULL,
            state ENUM('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
            postcode VARCHAR(4) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone_number VARCHAR(12) NOT NULL,
            skill1 VARCHAR(50),
            skill2 VARCHAR(50),
            other_skills TEXT,
            status ENUM('New', 'Current', 'Final') DEFAULT 'New',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($create_table_sql) === TRUE) {
            // Prepare skills for insertion
            $skill1 = isset($skills[0]) ? $skills[0] : null;
            $skill2 = isset($skills[1]) ? $skills[1] : null;
            
            // Insert EOI record
            $insert_sql = "INSERT INTO eoi (job_reference, first_name, last_name, date_of_birth, gender, 
                                           street_address, suburb, state, postcode, email, phone_number, 
                                           skill1, skill2, other_skills, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";
            
            $stmt = $conn->prepare($insert_sql);
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
            $errors[] = "Error creating table: " . $conn->error;
        }
    }
}

// Set page variables for display
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
                    <h2>Thank You for Your Application!</h2>
                    <p>Your Expression of Interest has been successfully submitted.</p>
                    <p><strong>Your EOI Number is: <?php echo $eoi_number; ?></strong></p>
                    <p>Please keep this number for your records. We will contact you if your application is successful.</p>
                    <p><a href="apply.php">Submit Another Application</a> | <a href="index.php">Return to Home</a></p>
                <?php else: ?>
                    <h2>Application Submission Failed</h2>
                    <p>There were errors in your application:</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p><a href="apply.php">Please go back and correct the errors</a></p>
                <?php endif; ?>
            </article>
        </div>
    </main>
</div>

<?php
// Close connection
if (isset($conn)) {
    $conn->close();
}
include("footer.inc");
?>
