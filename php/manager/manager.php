<?php
session_start();
include("../dbp.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['datenaiss']) && isset($_POST['phone'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $datenaiss = $_POST['datenaiss'];
            $phone = $_POST['phone'];

            // Check if user ID is available in session
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                // Insert the driver data
                $sql = $link->prepare("INSERT INTO manager (id, firstname, lastname, datenaiss, phone) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("issss", $user_id, $firstname, $lastname, $datenaiss, $phone);
                $sql->execute();

                // Close the statement
                $sql->close();

                // Redirect to appropriate page after insertion
                header("Location: manager.php"); // Adjust the location if needed
                exit();
            } else {
                // Handle error if user ID is not available in session
                echo "User ID not found. Please insert user data first.";
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
    <link rel="stylesheet" href="#">
    <title>Create manager</title>
</head>
<body>
    <div id="inscreption-form">
    <h2>CREATE MANAGER: :</h2>
    <form action="manager.php" method="post">
        <label for="firstname">First Name:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>
        
        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>
        
        <label for="datenaiss">Date of Birth:</label><br>
        <input type="date" id="datenaiss" name="datenaiss" required><br><br>
        
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>
       
        <input type="submit" name="submit" value="CREATE">
    </form>
    </div>
</body>
</html>
