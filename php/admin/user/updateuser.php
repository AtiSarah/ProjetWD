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
    if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
    }
    $id = $_SESSION['user_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];

        // Check if the confirmation has been submitted
        if (isset($_POST['confirmUpdate'])) {
            // Check if the new email already exists in the database
            $check_email_query = "SELECT * FROM user WHERE email = ? AND id <> ?";
            $check_email_stmt = $link->prepare($check_email_query);
            $check_email_stmt->bind_param("si", $email, $id);
            $check_email_stmt->execute();
            $result = $check_email_stmt->get_result();

            if ($result->num_rows > 0) {
                // Email already exists for another user, display error message
                echo "Email already exists in the database.";
            } else {
                // Email does not exist for any other user, proceed with the update
                // Hash the password only if provided
                $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

                // Update the user details in the database
                $updateSql = $link->prepare("UPDATE user SET email=?, pass=? WHERE id=?");
                $updateSql->bind_param("ssi", $email, $password, $id);
                $updateSql->execute();
                $updateSql->close();

                echo "User updated successfully.";
            }
        } else {
            // Display confirmation message
            echo "<script>
                    function confirmUpdate() {
                        if (confirm('Are you sure you want to update this user?')) {
                            document.getElementById('confirmUpdate').value = 'true';
                            document.getElementById('updateForm').submit();
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
                    <form method='post' action='' id='updateForm'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='email' name='email' value='" . $row['email'] . "'>
                        <input type='password' name='password' placeholder='Enter new password'>
                        <input type='submit' name='update' value='Update' onclick='confirmUpdate();'>
                        <input type='hidden' name='confirmUpdate' id='confirmUpdate' value=''>
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

    <a href="../admin.php"><button>Done</button></a>
</body>
</html>
