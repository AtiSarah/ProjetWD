<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Driver</title>
</head>
<body>
    <h2>Update Driver</h2>
    
    <br>

    <?php
    session_start();
    include("../dbp.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id_driver = $_POST['id_driver'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $datenaiss = $_POST['datenaiss'];
        $phone = $_POST['phone'];
        $license_type = $_POST['license_type'];
        
        // Update the driver details in the database
        $updateSql = $link->prepare("UPDATE driver SET firstname=?, lastname=?, datenaiss=?, phone=?, license_type=? WHERE id_driver=?");
        $updateSql->bind_param("sssssi", $firstname, $lastname, $datenaiss, $phone, $license_type, $id_driver);
        $updateSql->execute();
        $updateSql->close();

        echo "Driver updated successfully.";
    }

    // Fetch all drivers from the database
    $sql = "SELECT * FROM driver";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID Driver</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Phone</th>
                <th>License Type</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_driver'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['datenaiss'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['license_type'] . "</td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='id_driver' value='" . $row['id_driver'] . "'>
                        <input type='text' placeholder='first name' name='firstname' value='" . $row['firstname'] . " '>
                        <input type='text' placeholder='last name' name='lastname' value='" . $row['lastname'] . "'>
                        <input type='date' name='datenaiss' value='" . $row['datenaiss'] . "'>
                        <input type='text' placeholder='phone' name='phone' value='" . $row['phone'] . "'>
                        <input type='text' placeholder='license type' name='license_type' value='" . $row['license_type'] . "'>
                        <input type='submit' name='update' value='Update'>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No drivers found.";
    }

    mysqli_close($link);
    ?>
    <a href="../admin.php"><button>done</button></a>
</body>
</html>
