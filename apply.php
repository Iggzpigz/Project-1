<?php
// Set page-specific variables
$title = "Application Page";
$description = "Job Application Form";
$author = "Jacob";

// Include header
include("header.inc");
// Include navigation
include("nav.inc");
?>

    <!-- Main banner section -->
    <section class="banner">
        <div class="banner-wrapper">
            <h1>Job Application Form</h1>
        </div>
    </section>
    <div id="padding">
        <main>
            <div id="card-thing">
            <article>
            <h6>white</h6>
            <form id="Application" method="post" action="process_eoi.php" novalidate="novalidate">
                <label class="labelstyle">Job Reference Number: </label>
                    <select name="Job">
                        <option id="Cloud_Engineer" value="SB472">Cloud Engineer</option>
                        <option id="Software_Developer" value="AP5D7">Software Developer</option>
                    </select>
                <br><br><label class="labelstyle">First Name: </label>
                    <input type="text" name="fname" size="20">
                <br><br><label class="labelstyle">Last Name: </label>
                    <input type="text" name="lname" size="20">
                <br><br><label class="labelstyle">Date of Birth: </label>
                    <input type="date" name="date">
                <br><br><label class="labelstyle">Gender: </label>
                    <fieldset>
                        <legend>Gender</legend>
                        <label>Male: </label>
                            <input type="radio" name="Gender" value="Male">
                        <label>Female: </label>
                            <input type="radio" name="Gender" value="Female">
                        <label>Other: </label>
                            <input type="radio" name="Gender" value="Other">
                    </fieldset>
                <br><br><label class="labelstyle">Street Address: </label>
                    <input type="text" name="Street" maxlength="40">
                <br><br><label class="labelstyle">Suburb/Town: </label>
                    <input type="text" name="Suburb" maxlength="40">
                <br><br><label class="labelstyle">State: </label>
                    <select name="State">
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                <br><br><label class="labelstyle">Postcode: </label>
                    <input type="text" minlength="4" maxlength="4" name="Postcode">
                <br><br><label class="labelstyle">Email Address: </label>
                    <input type="email" name="Email">
                <br><br><label class="labelstyle">Phone Number: </label>
                    <input type="tel" minlength="8" maxlength="12" name="phone_number">
                <br><br><label class="labelstyle">Required Technical Skills: </label>
                    <br><label>Ability to develop various software</label>
                        <input type="checkbox" name="skills[]" value="software_development">
                    <br><label>Can design cloud based systems</label>
                        <input type="checkbox" name="skills[]" value="cloud_systems">
                <br><br><label class="labelstyle">Other Skills: </label><br>
                    <textarea name="other_skills" rows="4" cols="50"></textarea><br>
                <input type="submit" value="Apply">
                <input type="reset" value="Reset Page">
            </form>
            </article>
            </div>
        </main>
    </div>

<?php
// Include footer
include("footer.inc");
?>
