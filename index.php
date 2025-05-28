<?php
$title = "Bluewave IT - Cloud Engineer Job";
$description = "Home page";
$author = "Hung";

include("header.inc");
include("nav.inc");
?>

<!-- Main banner section -->
<section class="banner">
    <div class="banner-wrapper">
        <h1>Cloud Engineer Job</h1>
    </div>
</section>

<!-- Job description container -->
<main class="content-wrapper">
    <div class="job-card">
        <div class="card-content">
            <div class="job-content">
                <h2>Cloud Engineer Recruitment Announcement</h2>
                <p>Our group is currently hiring several Cloud Engineers. We are looking for motivated and skilled professionals who are passionate about cloud technologies and eager to contribute to innovative and impactful projects.</p>
                <h3>Position Overview:</h3>
                <p>As a Cloud Engineer, you will be responsible for designing, implementing, and maintaining cloud infrastructure to ensure the performance, scalability, and security of our systems. You will work closely with software developers, system administrators, and other stakeholders to deploy and optimize cloud-based solutions that support our business goals.</p>
                <h3>Preferred Qualifications:</h3>
                <ul>
                    <li>Bachelor's degree in Computer Science, Information Technology, or a related field.</li>
                    <li>2+ years of experience working with cloud platforms such as AWS, Azure, or Google Cloud.</li>
                    <li>Proficiency in scripting or programming languages such as Python, Bash, or PowerShell.</li>
                    <li>Familiarity with containerization technologies (e.g., Docker, Kubernetes).</li>
                    <li>Strong problem-solving skills and the ability to work both independently and in a team environment.</li>
                    <li>Cloud certification(s) such as AWS Certified Solutions Architect or Google Cloud Professional Engineer is a plus.</li>
                </ul>
            </div>
            <div class="job-illustration">
                <img src="images/cloud_engineer.png" alt="Cloud Engineers Working">
            </div>
        </div>
    </div>

    <!-- Quick Links section -->
    <div class="quick-links-container">
        <div class="quick-link-row">
            <a href="apply.php" class="quick-link-card-wrapper">
                <div class="quick-link-card">
                    <h3 class="quick-link-header">Apply for the job</h3>
                    <div class="quick-link-content">
                        <div class="quick-link-icon">
                            <img src="images/apply_logo.png" alt="Apply Icon">
                        </div>
                        <p class="quick-link-text">To learn more about the application process and access the application form, please click on the "Apply" button. Once you click, you will be guided through the steps to submit your application. Ensure that you fill out all the required fields and attach any necessary documents.</p>
                    </div>
                </div>
            </a>
            <a href="jobs.php" class="quick-link-card-wrapper">
                <div class="quick-link-card">
                    <h3 class="quick-link-header">Job listing</h3>
                    <div class="quick-link-content">
                        <div class="quick-link-icon">
                            <img src="images/job_listing_logo.png" alt="Job Listing Icon">
                        </div>
                        <p class="quick-link-text">View all available positions including cloud engineer and software developer roles. Make sure to check regularly for new opportunities.</p>
                    </div>
                </div>
            </a>
            <a href="about.php" class="quick-link-card-wrapper">
                <div class="quick-link-card">
                    <h3 class="quick-link-header">About Us</h3>
                    <div class="quick-link-content">
                        <div class="quick-link-icon">
                            <img src="images/about_us_logo.png" alt="About Us Icon">
                        </div>
                        <p class="quick-link-text">To learn more about our team members and the areas we work in, feel free to click on the 'About Us' link to read more information about us.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Services grid -->
    <div class="services-grid">
        <div class="service-category">
            <h3>Cloud Services</h3>
            <ul>
                <li><a href="#">Cloud migration</a></li>
                <li><a href="#">Cloud optimization</a></li>
            </ul>
        </div>
         <div class="service-category">
            <h3>Security Solutions</h3>
            <ul>
                <li><a href="#">Network security</a></li>
                <li><a href="#">Data protection</a></li>
            </ul>
        </div>
        <div class="service-category">
            <h3>IT Consulting</h3>
            <ul>
                <li><a href="#">Strategic planning</a></li>
                <li><a href="#">Business solutions</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Info cards -->
    <div class="info-cards">
        <div class="info-card">
            <h3>Training & Certification</h3>
            <p>Our employees will be eligible for free cloud certification courses and training opportunities.</p>
        </div>
        <div class="info-card">
            <h3>Remote Work Options</h3>
            <p>We offer flexible remote work arrangements that allow you to work from anywhere while staying connected with your team.</p>
        </div>
    </div>
</main>

<?php
// Include footer ONCE
include("footer.inc");
?>
