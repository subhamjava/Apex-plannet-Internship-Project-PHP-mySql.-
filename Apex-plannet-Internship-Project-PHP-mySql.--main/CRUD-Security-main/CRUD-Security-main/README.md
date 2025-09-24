# CRUD-Security
Security updateded for Task4

Task 4: Security Enhancements for PHP Blog Application
This project is the fourth task in the ApexPlanet Software Pvt. Ltd. Web Development Internship. It builds upon the existing PHP & MySQL blog application from Task 3 by implementing critical security enhancements as per the requirements.

Developer: Ritesh Kumar Jena

1. Objective
The primary goal of this task was to secure the web application against common vulnerabilities by implementing the following key features:

Prepared Statements to prevent SQL Injection.

Enhanced Form Validation for data integrity.

User Roles and Permissions for robust access control.

2. Security Measures Implemented
This project successfully integrates all the required security enhancements.

a. SQL Injection Prevention (Complete)
Method: The application exclusively uses the PHP Data Objects (PDO) extension to interact with the MySQL database.

Implementation: All SQL queries (SELECT, INSERT, UPDATE, DELETE) have been rewritten to use prepared statements. This practice separates the SQL logic from the user-provided data, completely neutralizing the risk of SQL injection attacks.

Files Affected: login.php, register.php, create.php, edit.php, delete.php, dashboard.php.

b. Enhanced Form Validation (Complete)
Both client-side and server-side validation have been implemented to ensure data integrity and improve user experience.

Client-Side Validation:

Uses standard HTML5 attributes like required, minlength, and type="email" to provide immediate feedback to the user in the browser.

Location: register.php, create.php, edit.php forms.

Server-Side Validation:

This is the primary security measure, as it cannot be bypassed by the user.

The register.php script now performs robust checks for:

Minimum username length (4 characters).

Valid email format using filter_var().

Minimum password length (8 characters).

Password and confirmation password match.

The create.php and edit.php scripts ensure that title and content fields are not submitted empty.

c. User Roles and Permissions (Complete)
A Role-Based Access Control (RBAC) system has been successfully implemented to manage user permissions.

Database Modification: The users table was extended with a role column (VARCHAR(50)).

Available Roles:

editor (Default): This is the standard user role. An editor can create new posts and view, edit, or delete only their own posts.

admin: This is the elevated-privilege role. An admin has all the permissions of an editor, but can also view, edit, and delete posts created by any user.

Implementation Details:

The user's role is stored in the $_SESSION upon login.

edit.php and delete.php now contain logic to check if the logged-in user is the post's owner OR if they have the admin role before allowing the action.

The dashboard.php interface conditionally displays the "Edit" and "Delete" buttons based on these permissions, providing a clean user experience.

3. How to Set Up and Run the Project
Follow these steps to run the project on a local machine using XAMPP.

Prerequisites: Ensure you have XAMPP installed and running with the Apache and MySQL modules active.

Place Files: Copy all project files (.php, .css) into a new folder named internship_project inside your XAMPP htdocs directory.

Database Setup:

Navigate to http://localhost/phpmyadmin.

Create a new database named internship_project.

Select the database, go to the SQL tab, and execute the following commands to create the necessary tables:

-- Create the 'users' table with the new 'role' column
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'editor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the 'posts' table
CREATE TABLE `posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

Run the Application: Open your web browser and navigate to http://localhost/internship_project/register.php to begin.

4. How to Test Admin Functionality
Register two different users through the application (e.g., user_one and user_two).

Log in as user_one and create a few posts. Log out.

Log in as user_two and create a post. You will notice you cannot edit or delete posts made by user_one. Log out.

Go to phpMyAdmin, browse the users table, and manually change the role of user_two from editor to admin.

Log back in as user_two. You will now see the "Edit" and "Delete" buttons for all posts, including those made by user_one, confirming your admin privileges.
