<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Check if there are related records in the mission table
    $checkMissionSql = $link->prepare("SELECT id_mission FROM mission WHERE id_driver = ?");
    $checkMissionSql->bind_param("i", $id);
    $checkMissionSql->execute();
    $checkMissionResult = $checkMissionSql->get_result();

    if ($checkMissionResult->num_rows > 0) {
        // Display error message or handle related records deletion
        echo "Cannot delete driver. Related mission records exist.";
    } else {
        // No related records found, proceed with driver deletion
        $deleteSql = $link->prepare("DELETE FROM driver WHERE id_driver = ?");
        $deleteSql->bind_param("i", $id);
        $deleteSql->execute();
        $deleteSql->close();

        echo "Driver deleted successfully.";
    }

    // Close prepared statements and database connection
    $checkMissionSql->close();
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Driver</title>
</head>
<body>
    <h2>Delete Driver</h2>
    <a href="driver.php"><button>Add Driver</button></a>
    <br><br>

    <?php
    // Include the database connection file
    include("../dbp.php");

    // Query to select all records from the driver table
    $sql = "SELECT * FROM driver";
    $result = $link->query($sql);

    // Check if there are any records returned
    if ($result && $result->num_rows > 0) {
        // Display table header
        echo "<table border='1'>
        <tr>
        <th>ID Driver</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date of Birth</th>
        <th>Phone</th>
        <th>License Type</th>
        <th>Action</th>
        </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_driver"] . "</td>";
            echo "<td>" . $row["firstname"] . "</td>";
            echo "<td>" . $row["lastname"] . "</td>";
            echo "<td>" . $row["datenaiss"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["license_type"] . "</td>";
            echo "<td><form method='post' action='deletedriver.php'>
                    <input type='hidden' name='id' value='" . $row["id_driver"] . "'>
                    <input type='submit' name='delete' value='Delete'>
                </form></td>";
            echo "</tr>";
        }
        // Close the table
        echo "</table>";
    } else {
        echo "No records found";
    }

    // Close the database connection
    mysqli_close($link);
    ?>
</body>
</html>
