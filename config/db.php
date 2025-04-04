<?php
// @Reference: https://www.php.net/manual/en/pdo.connections.php
// @REference: https://www.php.net/manual/en/book.pdo.php
// @REference: https://www.php.net/manual/en/pdo.setattribute.php
// @REference: https://stackify.com/php-try-catch-php-exception-tutorial/?
// @REference: https://www.codewithfaraz.com/article/74/step-by-step-guide-connecting-php-to-mysql-database-with-xampp
// @REference: https://www.youtube.com/watch?v=wMm2lUoMe6k&ab_channel=SteveGriffith-Prof3ssorSt3v3

// dtatbase server hostname
$host = 'localhost';
// name of the database to connect to
$dbname = 'game_reviews';
// username of the database (default for MySQL using XMAPP)
$username = 'root';
// password (default for MySQL using XAMPP)
$password = '';

try {
    // Establish a secure PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        // Enable exceptions for error handling
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Use persistent connection for efficiency
        PDO::ATTR_PERSISTENT => true,
        // Fetch results as associative arrays
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Prevents SQL injection
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Log the error instead of exposing details to the user
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}
?>
