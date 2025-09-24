<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"];
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
        echo "<p><strong>Generated Hash:</strong> " . $hash . "</p>";
    } else {
        echo "<p style='color:red;'>Please enter a password!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Password Hash Generator</title>
</head>
<body>
  <h2>Generate Password Hash</h2>
  <form method="post">
    <input type="text" name="password" placeholder="Enter password" required>
    <button type="submit">Generate Hash</button>
  </form>
</body>
</html>
