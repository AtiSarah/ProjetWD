<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Delete the mission
    $deleteSql = $link->prepare("DELETE FROM mission WHERE id_mission = ?");
    $deleteSql->bind_param("i", $id);
    $deleteSql->execute();

    if ($deleteSql->affected_rows > 0) {
        echo "Mission deleted successfully.";
    } else {
        echo "Error deleting mission. Please try again.";
    }

    // Close prepared statement and database connection
    $deleteSql->close();
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Mission</title>
</head>
<body>
    <h2>Delete Mission</h2>
    <br>

    <?php
    // Include the database connection file
    include("../dbp.php");

    // Query to select all records from the mission table
    $sql = "SELECT * FROM mission";
    $result = $link->query($sql);

    // Check if there are any records returned
    if ($result && $result->num_rows > 0) {
        // Display table header
        echo "<table border='1'>
        <tr>
        <th>ID Mission</th>
        <th>ID Driver</th>
        <th>ID Vehicle</th>
        <th>Departure City</th>
        <th>Arrival City</th>
        <th>Departure Date</th>
        <th>Duration</th>
        <th>Cost</th>
        <th>Type</th>
        <th>Action</th>
        </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_mission"] . "</td>";
            echo "<td>" . $row["id_driver"] . "</td>";
            echo "<td>" . $row["id_vehicle"] . "</td>";
            echo "<td>" . $row["departure_city"] . "</td>";
            echo "<td>" . $row["arrival_city"] . "</td>";
            echo "<td>" . $row["departure_date"] . "</td>";
            echo "<td>" . $row["duration"] . "</td>";
            echo "<td>" . $row["cost"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td><form method='post' action='deletemission.php'>
                    <input type='hidden' name='id' value='" . $row["id_mission"] . "'>
                    <input type='submit' name='delete' value='Delete'>
                </form></td>";
            echo "</tr>";
        }
        // Close the table
        echo "</table>";
    } else {
        echo "No missions found";
    }

    // Close the database connection
    mysqli_close($link);
    echo "<a href='manager.php'><button>done</button></a>";
    
    ?>
</body>
</html>
