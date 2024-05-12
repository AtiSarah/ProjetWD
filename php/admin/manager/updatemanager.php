<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Manager</title>
</head>
<body>
    <h2>Update Manager</h2>
    <br>

    <?php
    session_start();
    include("../dbp.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id_manager = $_POST['id_manager'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $datenaiss = $_POST['datenaiss'];
        $phone = $_POST['phone'];
        
        // Update the manager details in the database
        $updateSql = $link->prepare("UPDATE manager SET firstname=?, lastname=?, datenaiss=?, phone=? WHERE id_manager=?");
        $updateSql->bind_param("ssssi", $firstname, $lastname, $datenaiss, $phone, $id_manager);
        $updateSql->execute();
        $updateSql->close();

        echo "Manager updated successfully.";
    }

    // Fetch all managers from the database
    $sql = "SELECT * FROM manager";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID Manager</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_manager'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['datenaiss'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='id_manager' value='" . $row['id_manager'] . "'>
                        <input type='text' name='firstname' value='" . $row['firstname'] . "'>
                        <input type='text' name='lastname' value='" . $row['lastname'] . "'>
                        <input type='date' name='datenaiss' value='" . $row['datenaiss'] . "'>
                        <input type='text' name='phone' value='" . $row['phone'] . "'>
                        <input type='submit' name='update' value='Update'>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No managers found.";
    }

    mysqli_close($link);
    ?>
    <a href="../admin.php"><button>done</button></a>
</body>
</html>
