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
// Regenerate session ID to prevent session fixation
session_regenerate_id(true);
// if the user is already logged in, redirect them to the homepage
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// checks if the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize user input to prevent XSS attacks
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Ensure all fields are filled before proceeding
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Check if email already exists
        $check_email_sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        // prepared statement to prevent SQL query injection
        $stmt = $pdo->prepare($check_email_sql);
        // bind perameters to the SQL query
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $email_exists = $stmt->fetchColumn();

        if ($email_exists) {
            // Store an error message in the session if email already exists
            $_SESSION['message'] = 'Email is already registered! Please use a different email.';
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user details into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            // prepared statement to prevent SQL query injection
            $stmt = $pdo->prepare($sql);
            // bind perameters to the SQL query
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            // Execute the query and check if registration was successful
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Registration successful!';
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['message'] = 'Registration failed!';
            }
        }
    }
}
?>

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
            <div class="message"><?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- registration form -->
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <!-- username input field -->
                <input type="text" name="username" required><br>

                <label for="email">Email:</label>
                <!-- email input field -->
                <input type="email" name="email" required><br>

                <label for="password">Password:</label>
                <!-- password input field -->
                <input type="password" name="password" required><br>
                <!-- submit button> -->
                <button type="submit">Register</button>
            </form>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
