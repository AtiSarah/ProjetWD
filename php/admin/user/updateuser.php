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
        
        // Check if the confirmation has been submitted
        if (isset($_POST['confirmAction']) && $_POST['confirmAction'] === 'update') {
            // Update the user details in the database
            $updateSql = $link->prepare("UPDATE user SET email=?, pass=? WHERE id=?");
            $updateSql->bind_param("ssi", $email, $password, $id);
            $updateSql->execute();
            $updateSql->close();

            echo "User updated successfully.";
        } else {
            // Display confirmation message
            echo "<script>
                    function confirmUpdate(id) {
                        if (confirm('Are you sure you want to update this user?')) {
                            document.getElementById('id').value = id;
                            document.getElementById('confirmAction').value = 'update';
                            document.getElementById('confirmForm').submit();
                        }
                    }
                </script>";
        }
    }

    // Fetch all users from the database
    $sql = "SELECT * FROM user";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Email</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='email' name='email' value='" . $row['email'] . "'>
                        <input type='password' name='password' placeholder='Enter new password'>
                        <button type='submit' name='update' onclick='confirmUpdate(" . $row['id'] . ")'>Update</button>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No users found.";
    }
    mysqli_close($link);
    ?>

    <form id="confirmForm" method="post" action="">
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="confirmAction" name="confirmAction">
    </form>

    <a href="../admin.php"><button>done</button></a>
</body>
</html>
