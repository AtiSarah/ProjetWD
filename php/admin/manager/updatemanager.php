<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];
include("../dbp.php");
echo "<h1>Update Manager</h1>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id_manager = $_POST['id_manager'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $datenaiss = $_POST['datenaiss'];
        $phone = $_POST['phone'];
        
        // Calculate the age based on the date of birth
        $today = new DateTime();
        $birthdate = new DateTime($_POST['datenaiss']);
        $age = $birthdate->diff($today)->y;

        // Check if the age is 19 or above
        if ($age >= 19) {
            // Update the manager details in the database
            $updateSql = $link->prepare("UPDATE manager SET firstname=?, lastname=?, datenaiss=?, phone=? WHERE id_manager=?");
            $updateSql->bind_param("ssssi", $firstname, $lastname, $datenaiss, $phone, $id_manager);
            $updateSql->execute();
            $updateSql->close();

            echo "Manager updated successfully.";
        } else {
            echo "Manager must be 19 years or older.";
        }
    }
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
                    <button type='submit' name='update' onclick='confirmUpdate(" . $row['id_manager'] . ")'>Update</button>
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

<form id="confirmForm" method="post" action="">
    <input type="hidden" id="id_manager" name="id_manager">
    <input type="hidden" id="confirmAction" name="confirmAction">
</form>

<script>
    function confirmUpdate(id_manager) {
        if (confirm("Are you sure you want to update this manager?")) {
            document.getElementById("id_manager").value = id_manager;
            document.getElementById("confirmAction").value = "update";
            document.getElementById("confirmForm").submit();
        }
    }
</script>

<a href="../admin.php"><button>Done</button></a>
