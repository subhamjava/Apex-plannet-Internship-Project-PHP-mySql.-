// @Ritesh Kumar Jena
<?php
// Database configuration
$DB_HOST = "127.0.0.1";       // localhost
$DB_NAME = "internship_project"; // database name
$DB_USER = "root";            // default XAMPP user
$DB_PASS = "";                // default password is empty in XAMPP

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);

    // Enable PDO errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: default fetch mode = associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Stop execution and show error
    die("Database connection failed: " . $e->getMessage());
}
?>

