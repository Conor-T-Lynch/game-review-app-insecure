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
// Regenerate session ID to prevent session fixation
session_regenerate_id(true);
// checks to see if user is logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// checking to see if the form has been submitted ising the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // used to trim and sanitize user input prevent XSS attacks by escaping special HTML characters
    $email = htmlspecialchars(trim($_POST['email']));
      // used to trim and sanitize user input prevent XSS attacks by escaping special HTML characters
    $password = htmlspecialchars(trim($_POST['password']));
    // checking to see if the fields are not empty
    if (!empty($email) && !empty($password)) {
        // prepare an SQL statement to fetch the user by email
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        // fetch user details from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // verify the provided password against the hashed password stored in the database
        if ($user && password_verify($password, $user['password'])) {
            // store user details in the session upon successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // redirect to the home page
            header('Location: index.php');
            exit();
        } else {
            // set an error message if the credentials are invalid
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
            <div class="message"><?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- login form -->
            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <!-- email input field -->
                <input type="email" name="email" required><br>
                <label for="password">Password:</label>
                <!-- password input field -->
                <input type="password" name="password" required><br>
                <!-- submit button -->
                <button type="submit">Login</button>
            </form>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
