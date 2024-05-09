<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vehicle</title>
</head>
<body>
    <h2>Delete Vehicle</h2>
    <a href="addvehicle.php"><button>Add Vehicle</button></a>
    <br><br>

    <?php
    // Include the database connection file
    include("../dbp.php");

    // Query to select all records from the vehicle table
    $sql = "SELECT * FROM vehicle";
    $result = $link->query($sql);

    // Check if there are any records returned
    if ($result && $result->num_rows > 0) {
        // hada table header
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

        // show data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_vehicle"] . "</td>";
            echo "<td>" . $row["immatriculation"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["brand"] . "</td>";
            echo "<td>" . $row["state"] . "</td>";
            echo "<td>" . $row["license_type"] . "</td>";
            echo "<td><form method='post' action='deletevehicle.php'>
                    <input type='hidden' name='id' value='" . $row["id_vehicle"] . "'>
                    <input type='submit' name='delete' value='Delete'>
                </form></td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No records found";
    }

    // Check if the delete clicked
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        // Delete vehicle 
        $deleteSql = $link->prepare("DELETE FROM vehicle WHERE id_vehicle = ?");
        $deleteSql->bind_param("i", $id);
        $deleteSql->execute();
        $deleteSql->close();

        // Redirect to the same page refresh the table
        header("Location: deletevehicle.php");
        exit();
    }

    
    mysqli_close($link);
    ?>
</body>
</html>
