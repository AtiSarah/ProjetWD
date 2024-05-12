<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    try {
        // Delete vehicle
        $deleteSql = $link->prepare("DELETE FROM vehicle WHERE id_vehicle = ?");
        $deleteSql->bind_param("i", $id);
        $deleteSql->execute();
        $deleteSql->close();

        // Redirect to the same page to refresh the table
        header("Location: deletevehicle.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint error
        echo "Cannot delete vehicle. It is associated with existing missions.";
    }
}

// Include the database connection file
include("../dbp.php");

// Query to select all records from the vehicle table
$sql = "SELECT * FROM vehicle";
$result = $link->query($sql);

// Check if there are any records returned
if ($result && $result->num_rows > 0) {
    // Table header
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Immatriculation</th>
    <th>Type</th>
    <th>Brand</th>
    <th>State</th>
    <th>License Type</th>
    <th>Action</th>
    </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id_vehicle"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["immatriculation"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["state"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["license_type"]) . "</td>";
        echo "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to delete this vehicle?\")' action='deletevehicle.php'>
                <input type='hidden' name='id' value='" . $row["id_vehicle"] . "'>
                <input type='submit' name='delete' value='Delete'>
            </form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found";
}

mysqli_close($link);

echo '<a href="../admin.php"><button>done</button></a>';
?>
