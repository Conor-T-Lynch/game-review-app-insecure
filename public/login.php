<?php
// @Reference: https://www.tutorialspoint.com/php/php_mysql_login.htm?
// @Reference: https://codeshack.io/secure-login-system-php-mysql/?
// @Reference: https://www.geeksforgeeks.org/creating-a-registration-and-login-system-with-php-and-mysql/
// @Reference: https://www.simplilearn.com/tutorials/php-tutorial/php-login-form
// @Reference: https://www.youtube.com/watch?v=tnfhky8Hg0c&ab_channel=JamalProgrammingTips
// @Reference: https://www.youtube.com/watch?app=desktop&v=PXugYdXCBck&ab_channel=OnlineITtutsTutorials
// @Reference: https://medium.com/%40jpmorris/how-to-build-a-php-login-form-using-sessions-c7fb6d8ecebe
// @Reference: https://stackoverflow.com/questions/10097887/using-sessions-session-variables-in-a-php-login-script
// @Reference: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
// @Reference: https://codeshack.io/review-system-php-mysql-ajax/?
// @Reference:“Session in PHP: Creating, Destroying, and Working With Session in PHP,” Simplilearn.com, Apr. 26, 2021. https://www.simplilearn.com/tutorials/php-tutorial/session-in-php#:~:text=To%20set%20session%20variables%2C%20you
// @Reference:“Simple signup and login system with PHP and Mysql database | Full Tutorial | How to & source code,” www.youtube.com. https://www.youtube.com/watch?v=WYufSGgaCZ8&ab_channel=QuickProgramming
// @Reference:“How To Create A OOP PHP Login System For Beginners | OOP PHP & PDO | OOP PHP Tutorial,” www.youtube.com. https://www.youtube.com/watch?v=BaEm2Qv14oU&ab_channel=DaniKrossing
// @Reference:Andropov Ajuatah Ajebua, “Building a Secure Login and Registration System with HTML, CSS, JavaScript, PHP, and MySQL,” Medium, Apr. 12, 2024. https://medium.com/@ajuatahcodingarena/building-a-secure-login-and-registration-system-with-html-css-javascript-php-and-mysql-591f839ee8f3

// starts the session and to enable session variables across papes
session_start();
// includes the database connection file
require_once '../config/db.php';
// checking to see if the form has been submitted ising the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // trim and retrieve user input from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // checking to see if the fields are not empty
    if (!empty($email) && !empty($password)) {
        // SQL query to fetch user details from the database based on email
        $email = $pdo->quote($email);
        $sql = "SELECT * FROM users WHERE email = $email AND password = '$password'";
        $user = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        // validating user credentials (insecure password is in pliantext)
        if ($user && $user['password'] == $password) {
            // storing user details in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // redirecting user to the index page after successful login
            header('Location: index.php');
            exit();
        } else {
            // storing an error message in the session if the login fails
            $_SESSION['message'] = 'Invalid credentials';
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
        <title>Login - Game Review App</title>
        <!-- link to the external CSS file -->
        <link href="../assets/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- includes the header file -->
        <?php include('../includes/header.php'); ?>

        <div class="container">
            <!-- heading of the login page -->
            <h2>Login</h2>
            <!-- display an error message when needed -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- login form -->
            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <!-- email input field -->
                <input type="text" name="email" required><br>
                <!-- password input field -->
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
                <!-- submit button -->
                <button type="submit">Login</button>
            </form>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
