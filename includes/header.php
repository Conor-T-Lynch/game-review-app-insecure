<!-- @Reference: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/nav? -->

<?php
// Generate a secure, base64-encoded nonce (at least 8 characters long)
$nonce = base64_encode(random_bytes(16));
// Set the Content Security Policy (CSP)
("Content-Security-Policy:
default-src 'self';
script-src 'nonce-$nonce' 'strict-dynamic';
style-src 'self' 'unsafe-inline';
img-src 'self' data:;
object-src 'none';
frame-ancestors 'none';
form-action 'self';
base-uri 'self';
require-trusted-types-for 'script';
trusted-types default;");
?>

<!-- header -->
<header>
    <h1>Game Review App</h1>
    <nav>
        <ul>
            <!-- nav links -->
            <li><a href="index.php">Home</a></li>
            <li><a href="review.php">Submit Review</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
