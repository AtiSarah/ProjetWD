<?php
session_start();
include("../dbp.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile = $_POST['profile'];

    // Hash the password 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // insert the user data
    $stmt = $link->prepare("INSERT INTO user (email, pass, profile) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $hashed_password, $profile);

    if ($stmt->execute()) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Email: $email</p>";
        echo "<p>Profile: " . ($profile == '0' ? 'Manager' : 'Driver') . "</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
} else {
    // Redirect back to the form if accessed directly
    header("Location: user.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>insert user</title>
</head>
<body>
  <h2>Registration Form</h2>
  <form action="user.php" method="post">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    <label for="profile">Profile:</label><br>
    <select id="profile" name="profile" required>
      <option value="0">Manager</option>
      <option value="1">Driver</option>
    </select><br>
    <input type="submit" value="Create">
  </form>
</body>
</html>
