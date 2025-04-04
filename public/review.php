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
// checks if the form is submitted uising the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // retrieve form data from user input
    $game_name = $_POST['game_name'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];
    // validate form inputs
    if (!empty($game_name) && !empty($review_text) && $rating >= 1 && $rating <= 10) {
        $email = $pdo->quote($review_text);
        // get the logged in user id or set to null if the user is not logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';
        // insert the review onto the database (insecure vulnerable to SQL injection)
        $sql = "INSERT INTO reviews (game_name, review_text, rating, user_id)
                VALUES ('$game_name', '$review_text', $rating, $user_id)";
        // execute the query and check if insertion was successful
        if ($pdo->quote($sql)) {
            // store a success message in the session and redirect to the homepage
            $_SESSION['message'] = 'Review submitted successfully!';
            header('Location: index.php');
            exit();
        } else {
            // store an error message in the session of the review submission fails
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
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
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
