<?php
$title = "About us";
$description = "About the authors";
$author = "Hung";

// Include header
include("header.inc");
// Include navigation
include("nav.inc");
?>

    <!-- Main banner section -->
    <section class="banner">
        <div class="banner-wrapper">
            <h1>About us</h1>
        </div>
    </section>
    <div id="padding">
        <main>
        <div id="card-thing">
            <aside>
                <h3>Group Members</h3>
                    <ol>
                        <li>105900985 / Jacob</li>
                        <li>105074314 / Hung</li>
                        <li>105914708 / Tom</li>
                    </ol>
            </aside>
            <article>
                <h2>Bluewave IT</h2>
                <h3>Class Tutor</h3>
                    <p>Rahul R</p>
                <h3>Individual Contributions</h3>
                    <h4>Project Part 2 Contributions:</h4>
                    <p>Jacob: </p>
                    <ul>
                        <li>Application Page (apply.php)</li>
                        <li>About Page (about.php) - Task 6</li>
                        <li>PHP include files creation (header.inc, nav.inc, footer.inc) - Task 1</li>
                        <li>Database settings file (settings.php) - Task 2</li>
                        <li>Converting HTML files to PHP with includes</li>
                        <li>File structure organization</li>
                    </ul>
                    <p>Tom: </p>
                    <ul>
                        <li>Jobs Page (jobs.php)</li>
                        <li>Job descriptions and styling</li>
                        <li>CSS layout for job descriptions (jd-layout.css)</li>
                        <li>Process EOI PHP script development</li>
                        <li>Database table creation and management</li>
                    </ul>
                    <p>Hung: </p>
                    <ul>
                        <li>Home Page (index.php)</li>
                        <li>Main styles CSS (styles.css)</li>
                        <li>Overall website styling and design</li>
                        <li>Manager queries page development</li>
                        <li>Job descriptions database integration</li>
                        <li>Website visual design and layout</li>
                    </ul>
                
                <h3>Technologies Used in Part 2</h3>
                <ul>
                    <li>PHP for server-side scripting</li>
                    <li>MySQL for database management</li>
                    <li>XAMPP for local development environment</li>
                    <li>HTML5 and CSS3 for structure and styling</li>
                    <li>Form processing and validation</li>
                    <li>Include files for code modularity</li>
                </ul>
                
                <h3>Group Photo</h3>
                <img src="images/group_photo.png" alt="Drawn image of Bluewave IT working on the project">
                
                <table>
                    <tr>
                        <th>Group Member</th>
                        <th colspan="3">Interests</th>
                    </tr>
                    <tr>
                        <td>Jacob:</td>
                        <td>Gaming</td>
                        <td>Reading</td>
                        <td>PHP Development</td>
                    </tr>
                    <tr>
                        <td>Tom:</td>
                        <td>Gaming</td>
                        <td>Wiki editing</td>
                        <td>Database Design</td>
                    </tr>
                    <tr>
                        <td>Hung:</td>
                        <td>Gaming</td>
                        <td>Watching movies</td>
                        <td>Web Design</td>
                    </tr>
                </table>
            </article>   
        </div>
        </main>
    </div>

<?php
// Include footer
include("footer.inc");
?>
