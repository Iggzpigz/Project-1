<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "user");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['Manager']);
    $password = mysqli_real_escape_string($conn, $_POST['ManagerPassword']);

    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: manage.php");
        exit();
    } else {
        echo "Wrong username or password.";
    }
}

?>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>