<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $departureCity = $_POST['departure_city'];
        $arrivalCity = $_POST['arrival_city'];
        $departureDate = $_POST['departure_date'];
        $duration = $_POST['duration'];
        $cost = $_POST['cost'];
        $type = $_POST['type'];
        
        $_SESSION['mission_added'] = true;
        $_SESSION['departure_city'] = $departureCity;
        $_SESSION['departure_date'] = $departureDate;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['arrival_city'] = $arrivalCity;
        $_SESSION['duration'] = $duration;
        $_SESSION['cost'] = $cost;
        $_SESSION['type'] = $type;  
        header("Location: ./Setvehicle.php");
        exit();
            } else {
                echo "<p>Error adding mission. Please try again.</p>";}
    } 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Mission</title>
</head>
<body>
    <h2>Add Mission</h2>
    <form action="mission.php" method="post">
        <label for="departure_city">Departure City:</label><br>
        <input type="text" id="departure_city" name="departure_city" required><br><br>
        <label for="arrival_city">Arrival City:</label><br>
        <input type="text" id="arrival_city" name="arrival_city" required><br><br>
        <label for="departure_date">Departure Date:</label><br>
        <input type="date" id="departure_date" name="departure_date" required><br><br>
        <label for="duration">Duration (min):</label><br>
        <input type="number" id="duration" name="duration" required><br><br>
        <label for="cost">Cost:</label><br>
        <input type="number" id="cost" name="cost" required><br><br>
        <label for="state">Type:</label><br>
        <input type="text" id="type" name="type" required><br><br>
        <input type="submit" name="submit" value="Set Vehicle">
    </form>
    <a href='manager.php'><button>cancel</button></a>
</body>
</html>
