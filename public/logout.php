<?php
// @Reference:Andropov Ajuatah Ajebua, “Building a Secure Login and Registration System with HTML, CSS, JavaScript, PHP, and MySQL,” Medium, Apr. 12, 2024. https://medium.com/@ajuatahcodingarena/building-a-secure-login-and-registration-system-with-html-css-javascript-php-and-mysql-591f839ee8f3
// @Reference: https://www.geeksforgeeks.org/creating-a-registration-and-login-system-with-php-and-mysql/
// @Reference: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php

// starts the session to manage session variables
session_start();
// unsets all session variables to logout the user
session_unset();
// destroy the session completely
session_destroy();
// redirect to the login page after logout
header('Location: login.php');
exit();
