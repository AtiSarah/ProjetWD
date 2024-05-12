<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Check if the user confirms the deletion
    if (isset($_POST['confirm_delete'])) {
        try {
            $deleteSql = $link->prepare("DELETE FROM user WHERE id = ?");
            $deleteSql->bind_param("i", $id);
            $deleteSql->execute();
            $deleteSql->close();

            echo "User deleted successfully.";

            mysqli_close($link);
        } catch (mysqli_sql_exception $e) {
            // Simplified error message for foreign key constraint failure
            echo "Cannot delete user. The user is associated with other data.";
        }
    } else {
        echo "Deletion cancelled.";
    }
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
   
    <br><br>

    <?php
    include("../dbp.php");

    $sql = "SELECT * FROM user";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Profile</th>
        <th>Action</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["profile"] . "</td>";
            echo "<td><form method='post' action='deleteuser.php' onsubmit='return confirm(\"Are you sure you want to delete this user?\")'>
                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                    <input type='hidden' name='confirm_delete' value='true'> <!-- Added hidden input for confirmation -->
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
</body>
</html>
