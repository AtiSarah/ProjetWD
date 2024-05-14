<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Missions</title>
</head>
<body>
    <h2>Update Missions</h2>
    <br>

    <?php
    session_start();
    include("../dbp.php"); 
    if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
    }
    $id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id_mission = $_POST['id_mission'];
        $departure_city = $_POST['departure_city'];
        $arrival_city = $_POST['arrival_city'];
        $departure_date = $_POST['departure_date'];
        $duration = $_POST['duration'];
        $cost = $_POST['cost'];
        $type = $_POST['type'];

        // Update the mission details in the database
        $updateSql = $link->prepare("UPDATE mission SET departure_city=?, arrival_city=?, departure_date=?, duration=?, cost=?, type=? WHERE id_mission=?");
        $updateSql->bind_param("sssiisi", $departure_city, $arrival_city, $departure_date, $duration, $cost, $type, $id_mission);
        $updateSql->execute();
        $updateSql->close();

        echo "Mission updated successfully.";
    }

    // Fetch all missions from the database
    $sql = "SELECT * FROM mission";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Departure City</th>
                <th>Arrival City</th>
                <th>Departure Date</th>
                <th>Duration</th>
                <th>Cost</th>
                <th>Type</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_mission'] . "</td>";
            echo "<td>" . $row['departure_city'] . "</td>";
            echo "<td>" . $row['arrival_city'] . "</td>";
            echo "<td>" . $row['departure_date'] . "</td>";
            echo "<td>" . $row['duration'] . "</td>";
            echo "<td>" . $row['cost'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='id_mission' value='" . $row['id_mission'] . "'>
                        <input type='text' name='departure_city' value='" . $row['departure_city'] . "'>
                        <input type='text' name='arrival_city' value='" . $row['arrival_city'] . "'>
                        <input type='date' name='departure_date' value='" . $row['departure_date'] . "'>
                        <input type='number' name='duration' value='" . $row['duration'] . "'>
                        <input type='number' name='cost' value='" . $row['cost'] . "'>
                        <input type='text' name='type' value='" . $row['type'] . "'>
                        <input type='submit' name='update' value='Update'>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No missions found.";
    }

    mysqli_close($link);
    ?>
    <a href="manager.php"><button>done</button></a>
</body>
</html>
