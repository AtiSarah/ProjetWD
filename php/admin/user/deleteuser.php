<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Check if there are related records in other tables
    // Example: Check if the user is associated with any missions or other data before deletion

    // Proceed with user deletion
    $deleteSql = $link->prepare("DELETE FROM user WHERE id = ?");
    $deleteSql->bind_param("i", $id);
    $deleteSql->execute();
    $deleteSql->close();

    echo "User deleted successfully.";

    // Close database connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
    <h2>Delete User</h2>
    <a href="user.php"><button>Add User</button></a>
    <br><br>

    <?php
    // Include the database connection file
    include("../dbp.php");

    // Query to select all records from the user table
    $sql = "SELECT * FROM user";
    $result = $link->query($sql);

    // Check if there are any records returned
    if ($result && $result->num_rows > 0) {
        // Display table header
        echo "<table border='1'>
        <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Profile</th>
        <th>Action</th>
        </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["profile"] . "</td>";
            echo "<td><form method='post' action='deleteuser.php'>
                    <input type='hidden' name='id' value='" . $row["id"] . "'>
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
