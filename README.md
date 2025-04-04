# game-review-app-insecure

in oder to use this app both the insecure and secure verions you must have the latest version of XAMPP installed onto your machine. This is the MySQL game-reviews databse that the users and reviews tables are stored on. Once you have the latest version installed you need to launch the control panel and turn on the appache server and the Mysql server, you must also have the the game review app folders (secure/insecure versions) in the xampp folder for example the path to where i have them is C:\xampp\htdocs ( both the insecure/secure versions of the app as in both folders need to be in the htdocs folder so where-ever you decide to install XAMPP onto your machine you need to find that xampp directory and place the folders insecure/secure into the htdocs folder on your machine or else when you try to navigate to the URL in the browser i would use chrome but i am pretty sure it will work on any i used chrome, if the folders are not in the htdocs folder the browser will throw up an error). After this you need to navigate to http://localhost/phpmyadmin/ and create the game_reviews databaseby by clicking new on the left side of php MyAdmin and then create following tables

enter this to the SQL tab for creating the user table

CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);

enter this to the SQL tab for creating the review table

CREATE TABLE `reviews` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `game_name` VARCHAR(100) NOT NULL,
  `review_text` TEXT NOT NULL,
  `rating` INT(11) NOT NULL,
  `user_id` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
);

navigate to these URLS to use the application

http://localhost/game-review-app-insecure/public/login.php and this url for the secure version http://localhost/game-review-app-secure/public/login.php.
