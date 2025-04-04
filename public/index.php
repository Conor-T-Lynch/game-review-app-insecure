<?php
// @Reference: https://www.tutorialspoint.com/php/php_mysql_login.htm?
// @Reference: https://codeshack.io/secure-login-system-php-mysql/?
// @Reference: https://www.php.net/manual/en/book.session.php
// @Reference: https://www.php.net/manual/en/book.pdo.php
// @Reference: https://www.w3schools.com/Sql/sql_join.asp
// @Reference: https://codeshack.io/secure-login-system-php-mysql/?
// @Reference: https://www.geeksforgeeks.org/creating-a-registration-and-login-system-with-php-and-mysql/
// @Reference:“Session in PHP: Creating, Destroying, and Working With Session in PHP,” Simplilearn.com, Apr. 26, 2021. https://www.simplilearn.com/tutorials/php-tutorial/session-in-php#:~:text=To%20set%20session%20variables%2C%20you
// @Reference:“Simple signup and login system with PHP and Mysql database | Full Tutorial | How to & source code,” www.youtube.com. https://www.youtube.com/watch?v=WYufSGgaCZ8&ab_channel=QuickProgramming
// @Reference:“How To Create A OOP PHP Login System For Beginners | OOP PHP & PDO | OOP PHP Tutorial,” www.youtube.com. https://www.youtube.com/watch?v=BaEm2Qv14oU&ab_channel=DaniKrossing
// @Reference:Andropov Ajuatah Ajebua, “Building a Secure Login and Registration System with HTML, CSS, JavaScript, PHP, and MySQL,” Medium, Apr. 12, 2024. https://medium.com/@ajuatahcodingarena/building-a-secure-login-and-registration-system-with-html-css-javascript-php-and-mysql-591f839ee8f3

// starts the session
session_start();
// include the database connection file
require_once '../config/db.php';
// SQL query to fetch reviews, that include the games name, the review text, rating and the date that the review was created
$sql = "SELECT r.id, r.game_name, r.review_text, r.rating, r.created_at, u.username
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        ORDER BY r.created_at DESC"; // orders the reviews my most recent first
// executes the query and fetches the results as an array
$reviews = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- title of the page -->
        <title>Game Review App</title>
        <!-- link to the external CSS file -->
        <link href="../assets/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- includes the header file -->
        <?php include('../includes/header.php'); ?>

        <div class="container">
            <!-- heading of the game review section -->
            <h2>Game Reviews</h2>
            <!-- display an error message when needed -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- link to the review form -->
            <h3>Submit a Review</h3>
            <div class="submit-link-container">
                <a href="review.php">Go to Review Form</a>
            </div>
            <!-- heading for the reviews section -->
            <h3>Latest Reviews</h3>
            <!-- checking for any reviews and displaying them -->
            <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
            <div class="review">
                <!-- displaying the games name -->
                <h4><?= $review['game_name']; ?></h4>
                <!-- displaying game rating -->
                <p><strong>Rating:</strong> <?= $review['rating']; ?>/10</p>
                <!-- displaying who reviewed the game and when -->
                <p><strong>Reviewed by:</strong> <?= $review['username']; ?> on <?= $review['created_at']; ?></p>
                <!-- displaying the review text -->
                <p><?= $review['review_text']; ?></p>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <!-- no review to display -->
            <p>No reviews found.</p>
            <?php endif; ?>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
