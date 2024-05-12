<?php
// Include the database connection file
include("../dbp.php");

// Query to select all records from the manager table
$sql = "SELECT id_manager, id, firstname, lastname, datenaiss, phone FROM manager";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if there are any records returned
if ($result && mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>ID Manager</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Date of Birth</th>
    <th>Phone</th>
    </tr>";

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['id_manager'] . "</td>";
        echo "<td>" . $row['firstname'] . "</td>";
        echo "<td>" . $row['lastname'] . "</td>";
        echo "<td>" . $row['datenaiss'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
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
