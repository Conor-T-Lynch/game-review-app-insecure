<?php
// @Reference: https://www.tutorialspoint.com/php/php_mysql_login.htm?
// @Reference: https://codeshack.io/secure-login-system-php-mysql/?
// @Reference: https://www.geeksforgeeks.org/creating-a-registration-and-login-system-with-php-and-mysql/
// @Reference: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
// @Reference:“Session in PHP: Creating, Destroying, and Working With Session in PHP,” Simplilearn.com, Apr. 26, 2021. https://www.simplilearn.com/tutorials/php-tutorial/session-in-php#:~:text=To%20set%20session%20variables%2C%20you
// @Reference:“Simple signup and login system with PHP and Mysql database | Full Tutorial | How to & source code,” www.youtube.com. https://www.youtube.com/watch?v=WYufSGgaCZ8&ab_channel=QuickProgramming
// @Reference:“How To Create A OOP PHP Login System For Beginners | OOP PHP & PDO | OOP PHP Tutorial,” www.youtube.com. https://www.youtube.com/watch?v=BaEm2Qv14oU&ab_channel=DaniKrossing
// @Reference:Andropov Ajuatah Ajebua, “Building a Secure Login and Registration System with HTML, CSS, JavaScript, PHP, and MySQL,” Medium, Apr. 12, 2024. https://medium.com/@ajuatahcodingarena/building-a-secure-login-and-registration-system-with-html-css-javascript-php-and-mysql-591f839ee8f3

// starts the session to track user data across pages
session_start();
// includes the database connection file
require_once '../config/db.php';
// if the user is already logged in, redirect them to the homepage
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// checks if the form is submitted uising the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // retrieve form data from user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ensure all the fields are filled before proceeding
    if (!empty($username) && !empty($email) && !empty($password)) {
        // insert user details into the database (insecure passsword shpuld be hashed)
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        // execute query and check if insertion was successful
        if ($pdo->exec($sql)) {
            // store a success message in session and redirect to login page
            $_SESSION['message'] = 'Registration successful!';
            header('Location: login.php');
            exit();
        } else {
            // store an error message in session if registration fails
            $_SESSION['message'] = 'Registration failed!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- title of the page -->
        <title>Register - Game Review App</title>
        <!-- link to the external CSS file -->
        <link href="../assets/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- includes the header file -->
        <?php include('../includes/header.php'); ?>

        <div class="container">
            <h2>Register</h2>
            <!-- display session messages an error or success message when needed -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- registration form -->
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <!-- username input field -->
                <input type="text" name="username" required><br>

                <label for="email">Email:</label>
                <!-- Email input field -->
                <input type="text" name="email" required><br>

                <label for="password">Password:</label>
                <!-- password input field -->
                <input type="password" name="password" required><br>
                <!-- submit button -->
                <button type="submit">Register</button>
            </form>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
