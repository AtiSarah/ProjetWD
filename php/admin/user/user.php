<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['profile'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $profile = $_POST['profile'];

            // Hash the password 
            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user data
            $sql = $link->prepare("INSERT INTO user (email, pass, profile) VALUES (?, ?, ?)");
            $sql->bind_param("sss", $email, $pwd_hash, $profile);
            $sql->execute();

            // Get the ID of the inserted user
            $user_id = $link->insert_id;

            // Store user ID in session for future use
            $_SESSION['user_id'] = $user_id;

            // Close the statement
            $sql->close();

            // Redirect based on the profile
            if ($profile == 0) {
                header("Location: ../manager/manager.php");
                exit();
            } elseif ($profile == 1) {
                header("Location: ../driver/driver.php");
                exit();
            }
        } 
    }
}
?>



<!-- create_user_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adduser.css">
    <title>CREATE USER</title>
</head>
<body>
<!-- <div class="sidebar">
        <h2>ADMIN</h2>
        <details>
            <summary>DASHBOARD</summary>
            <li><a href="dwda.php">USERS</a></li>
            <li><a href="#">MANAGERS</a></li>
            <li><a href="driver.html">DRIVERS</a></li>
            <li><a href="#">VEHICLES</a></li>
            
        </details>
        <details>
            <summary>ADD</summary>
            <li><a href="#">USERS</a></li>
            <li><a href="#">MANAGERS</a></li>
            <li><a href="addDriver.html">DRIVERS</a></li>   
            <li><a href="addVehicle.html">VEHICLES</a></li>
         
        </details>
        <details>
            <summary>EDIT</summary>
            <li><a href="#">USERS</a></li>
            <li><a href="#">MANAGERS</a></li>
            <li><a href="#">DRIVERS</a></li>   
            <li><a href="#">VEHICLES</a></li>
         
        </details>
        <details>
            <summary>DELETE</summary>
            <li><a href="#">USERS</a></li>
            <li><a href="#">MANAGERS</a></li>
            <li><a href="#">DRIVERS</a></li>
            <li><a href="#">VEHICLES</a></li>
         
        </details>
        </ul>
    </div> -->
    <div id="inscreption-form">
    <h2>CREATE USER :</h2>
    <form action="user.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="password" required><br><br>
        
        <label for="profile">Profile:</label><br>
        <select id="profile" name="profile" required>
        <option value="0">Manager</option>
        <option value="1">Driver</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="CREATE">
    </form>
    </div>
</body>
</html>