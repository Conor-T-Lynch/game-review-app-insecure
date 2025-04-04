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
    // attempt to create a new PDO and establish a connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception to handle any connection errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // if an error occurs during the connection attempt, display an error message
    die("Connection failed: " . $e->getMessage());
}
?>
