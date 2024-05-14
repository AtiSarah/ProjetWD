<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vehicles</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this vehicle?');
        }
    </script>
</head>
<body>
    <h2>Update Vehicles</h2>
    
    <br><br>

    <?php
    session_start();
    include("../dbp.php"); 
    if (!isset($_SESSION['user_id'])) {
        session_destroy();
        header("Location: ../error.php");
        exit();
    }
    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id_vehicle = $_POST['id_vehicle'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['type'];
        $license_type = $_POST['license_type'];
        $brand = $_POST['brand'];
        $state = $_POST['state'];

        // Update the vehicle details in the database
        $updateSql = $link->prepare("UPDATE vehicle SET immatriculation=?, type=?, license_type=?, brand=?, state=? WHERE id_vehicle=?");
        $updateSql->bind_param("issssi", $immatriculation, $type, $license_type, $brand, $state, $id_vehicle);
        
        // Check if confirmation is submitted
        if (isset($_POST['confirmUpdate'])) {
            $updateSql->execute();
            $updateSql->close();
            echo "Vehicle updated successfully.";
        } else {
            // Display confirmation message
            echo "<script>
                    function confirmUpdate() {
                        return confirm('Are you sure you want to update this vehicle?');
                    }
                </script>";
        }
    }

    // Fetch all vehicles from the database
    $sql = "SELECT * FROM vehicle";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Immatriculation</th>
                <th>Type</th>
                <th>License Type</th>
                <th>Brand</th>
                <th>State</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_vehicle'] . "</td>";
            echo "<td>" . $row['immatriculation'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['license_type'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['state'] . "</td>";
            echo "<td>
                    <form method='post' action='' id='updateForm'>
                        <input type='hidden' name='id_vehicle' value='" . $row['id_vehicle'] . "'>
                        <input type='number' name='immatriculation' value='" . $row['immatriculation'] . "'>
                        <input type='text' name='type' value='" . $row['type'] . "'>
                        <input type='text' name='license_type' value='" . $row['license_type'] . "'>
                        <input type='text' name='brand' value='" . $row['brand'] . "'>
                        <input type='text' name='state' value='" . $row['state'] . "'>
                        <input type='submit' name='update' value='Update' onclick='return confirmUpdate();'>
                        <input type='hidden' name='confirmUpdate' value='true'>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No vehicles found.";
    }

    mysqli_close($link);
    echo '<a href="../admin.php"><button>done</button></a>';
    ?>
</body>
</html>
