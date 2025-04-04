<?php
// @Reference: https://codeshack.io/review-system-php-mysql-ajax/?
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
// checking to see if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// checks if the form is submitted uising the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // used to trim and sanitize user input prevent XSS attacks by escaping special HTML characters
    $game_name = htmlspecialchars(trim($_POST['game_name']));
    // used to trim and sanitize user input prevent XSS attacks by escaping special HTML characters
    $review_text = htmlspecialchars(trim($_POST['review_text']));
    $rating = intval($_POST['rating']);
    // validate form inputs
    if (!empty($game_name) && !empty($review_text) && $rating >= 1 && $rating <= 10) {
        // checks the user id against the session id
        $user_id = $_SESSION['user_id'];
        // inserts the users review into the database
        $sql = "INSERT INTO reviews (game_name, review_text, rating, user_id)
                VALUES (:game_name, :review_text, :rating, :user_id)";
        // bind the perameters to the SQL query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':game_name', $game_name);
        $stmt->bindParam(':review_text', $review_text);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':user_id', $user_id);
        // execute the query and check if registration was successful
        if ($stmt->execute()) {
            // store a success message in the session
            $_SESSION['message'] = 'Review submitted successfully!';
            // redirect the user to the home page
            header('Location: index.php');
            exit();
        } else {
            // store an error message in the session if review submission fails
            $_SESSION['message'] = 'Failed to submit the review!';
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
        <title>Submit Review - Game Review App</title>
        <!-- link to the external CSS file -->
        <link href="../assets/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- includes the header file -->
        <?php include('../includes/header.php'); ?>

        <div class="container">
            <h2>Submit a Review</h2>
            <!-- display session messages an error or success message when needed -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?></div>
        </div>
            <?php endif; ?>
            <!-- review submission form -->
            <form action="review.php" method="POST">
                <label for="game_name">Game Name:</label><input type="text" name="game_name" required><br>
                <label for="review_text">Review:</label><textarea name="review_text" required></textarea><br>
                <label for="rating">Rating (1-10):</label><input type="number" name="rating" min="1" max="10" required><br>
                <button type="submit">Submit Review</button>
            </form>
        </div>
        <!-- includes the footer file -->
        <?php include('../includes/footer.php'); ?>

    </body>
</html>
