<?php
// Include the database connection file
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $driverId = $_POST['driver_id'];
    $vehicleId = $_POST['vehicle_id'];
    $departureCity = $_POST['departure_city'];
    $arrivalCity = $_POST['arrival_city'];
    $departureDate = $_POST['departure_date'];
    $duration = $_POST['duration'];
    $cost = $_POST['cost'];
    $type = $_POST['type'];

    // Check if both driver ID and vehicle ID exist in their respective tables
    $checkDriver = $link->prepare("SELECT id_driver FROM driver WHERE id_driver = ?");
    $checkDriver->bind_param("i", $driverId);
    $checkDriver->execute();
    $checkDriverResult = $checkDriver->get_result();

    $checkVehicle = $link->prepare("SELECT id_vehicle FROM vehicle WHERE id_vehicle = ?");
    $checkVehicle->bind_param("i", $vehicleId);
    $checkVehicle->execute();
    $checkVehicleResult = $checkVehicle->get_result();

    if ($checkDriverResult->num_rows > 0 && $checkVehicleResult->num_rows > 0) {
        // Both driver ID and vehicle ID exist, proceed with mission insertion
        $sql = $link->prepare("INSERT INTO mission (id_driver, id_vehicle, departure_city, arrival_city, departure_date, duration, cost, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("iisssiis", $driverId, $vehicleId, $departureCity, $arrivalCity, $departureDate, $duration, $cost, $type);
        $sql->execute();

        if ($sql->affected_rows > 0) {
            echo "<p>Mission added successfully!</p>";
        } else {
            echo "<p>Error adding mission. Please try again.</p>";
        }
        // Close the prepared statement for mission insertion
        $sql->close();
    } else {
        echo "<p>Error: Invalid driver ID or vehicle ID.</p>";
    }

    // Close prepared statements and database connection
    $checkDriver->close();
    $checkVehicle->close();
    mysqli_close($link);
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
    <a href="dashdriver.php" ><button>Show Driver List</button></a>
    <a href="dashvehicle.php"><button>Show Vehicle List</button></a>
    <form action="mission.php" method="post">
        <label for="driver_id">Driver ID:</label><br>
        <input type="text" id="driver_id" name="driver_id" required><br><br>
        <label for="vehicle_id">Vehicle ID:</label><br>
        <input type="text" id="vehicle_id" name="vehicle_id" required><br><br>
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
        <input type="submit" value="Add Mission">
    </form>
</body>
</html>
