<?php
// Include the database connection file
include("../dbp.php");

// Query to select all records from the mission table
$sql = "SELECT id_mission, id_driver, id_vehicle, departure_city, arrival_city, departure_date, duration, cost, type FROM mission";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if there are any records returned
if ($result && mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<h1>Mission</h1>";
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>ID Driver</th>
    <th>ID Vehicle</th>
    <th>Departure City</th>
    <th>Arrival City</th>
    <th>Departure Date</th>
    <th>Duration</th>
    <th>Cost</th>
    <th>Type</th>
    </tr>";

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_mission'] . "</td>";
        echo "<td>" . $row['id_driver'] . "</td>";
        echo "<td>" . $row['id_vehicle'] . "</td>";
        echo "<td>" . $row['departure_city'] . "</td>";
        echo "<td>" . $row['arrival_city'] . "</td>";
        echo "<td>" . $row['departure_date'] . "</td>";
        echo "<td>" . $row['duration'] . "</td>";
        echo "<td>" . $row['cost'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
mysqli_close($link);
echo "<a href='manager.php'><button>done</button></a>";
?>
