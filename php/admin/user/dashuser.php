<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}


// Query to select all records from the user table
$sql = "SELECT id, email, profile FROM user";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if there are any records returned
if ($result && mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<h1>User</h1>";
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Email</th>
    <th>Profile</th>
    </tr>";

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['profile'] . "</td>";
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
mysqli_close($link);
echo '<a href="../admin.php"><button>done</button></a>';
?>
