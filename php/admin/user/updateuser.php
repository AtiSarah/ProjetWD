<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <br>

    <?php
    session_start();
    include("../dbp.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password before storing
        
        // Update the user details in the database
        $updateSql = $link->prepare("UPDATE user SET email=?, pass=? WHERE id=?");
        $updateSql->bind_param("ssi", $email, $password, $id);
        $updateSql->execute();
        $updateSql->close();

        echo "User updated successfully.";
    }

    // Fetch all users from the database
    $sql = "SELECT * FROM user";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>*****</td>"; // Display password as asterisks for security reasons
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='email' name='email' value='" . $row['email'] . "'>
                        <input type='password' name='password' placeholder='Enter new password'>
                        <input type='submit' name='update' value='Update'>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No users found.";
    }
    echo '<a href="../admin.php"><button>done</button></a>';
?>
   
