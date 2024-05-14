<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit(); // Stop script execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['datenaiss']) && isset($_POST['phone']) && isset($_POST['license'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $datenaiss = $_POST['datenaiss'];
            $phone = $_POST['phone'];
            $license_type = $_POST['license']; 

            // Calculate the age based on the date of birth
            $today = new DateTime();
            $birthdate = new DateTime($_POST['datenaiss']);
            $age = $birthdate->diff($today)->y;

            // Check if the age is 18 or above
            if ($age >= 18) {
                // Check if user ID is available in session
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Insert the driver data
                    $sql = $link->prepare("INSERT INTO driver (id, firstname, lastname, datenaiss, phone, license_type) VALUES (?, ?, ?, ?, ?, ?)");
                    $sql->bind_param("isssss", $user_id, $firstname, $lastname, $datenaiss, $phone, $license_type);
                    $sql->execute();
                    $sql->close();

                    // Redirect after insertion
                    header("Location: ../admin.php"); // Adjust the location if needed
                    exit();
                } else {
                    // Handle error if user ID is not available in session
                    echo "User ID not found. Please insert user data first.";
                }
            } else {
                echo "Driver must be 18 years or older.";
            }
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="managers.css">
    <title>Create User</title>
</head>
<body>
    <div id="inscreption-form">
    <h2>CREATE DRIVERS :</h2>
    <form action="driver.php" method="post">
        <label for="firstname">First Name:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>
        
        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>
        
        <label for="datenaiss">Date of Birth:</label><br>
        <input type="date" id="datenaiss" name="datenaiss" required><br><br>
        
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="license">License Type:</label><br>
        <select id="license" name="license" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select><br><br>

        <input type="submit" name="submit" value="CREATE">
    </form>
    </div>
    
</body>
</html>
