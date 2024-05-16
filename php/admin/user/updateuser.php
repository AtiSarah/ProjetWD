<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="updateuser.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar close">
    <div class="logo-details">
    <i class="#"></i>
      <span class="logo_name">VROOMCAR</span>
    </div>
    <ul class="nav-links">
    <li> <!--DASHBOARD -->
        <div class="iocn-link">
          <a href="#">
          <i class='bx bx-grid-alt' ></i>
            <span class="link_name">Dashboard</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
        <li><a href="dashuser.php">User</a></li>
          <li><a href="../driver/dashdriver.php">Driver</a></li>
          <li><a href="../manager/dashmanager.php">Manager</a></li>
          <li><a href="../vehicle/dashvehicle.php">Vehicle</a></li>
        </ul>
      </li>
      <li> <!--ADD --> 
        <div class="iocn-link">
          <a href="#">
          <i class="fa-solid fa-plus"></i>
            <span class="link_name">ADD</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
        <li><a href="user.php">User</a></li>
          <li><a href="../vehicle/vehicle.php">Vehicle</a></li>
        </ul>
      </li>
      <li>
     <li> <!--DELETE -->     
       <div class="iocn-link">
         <a href="#">
         <i class="fa-solid fa-minus"></i>
           <span class="link_name">DELETE</span>
         </a>
         <i class='bx bxs-chevron-down arrow' ></i>
       </div>
       <ul class="sub-menu">
       <li><a href="deleteuser.php">User</a></li>
         <li><a href="../driver/deletedriver.php">Driver</a></li>
         <li><a href="../manager/deletemanager.php">Manager</a></li>
         <li><a href="../vehicle/deletevehicle.php">Vehicle</a></li>
       </ul>
     </li>
     <li>     
      <li> <!--EDIT --> 
       <div class="iocn-link">
         <a href="#">
         <i class="fa-regular fa-pen-to-square"></i>
           <span class="link_name">EDIT</span>
         </a>
         <i class='bx bxs-chevron-down arrow' ></i>
       </div>
       <ul class="sub-menu">
       <li><a href="updateuser.php">User</a></li>
         <li><a href="../driver/updatedriver.php">Driver</a></li>
         <li><a href="../manager/updatemanager.php">Manager</a></li>
         <li><a href="../vehicle/updatevehicle.php">Vehicle</a></li>
       </ul>
     </li>
     <li>

    <div class="profile-details">
      <div class="profile-content">
      <img src="../../../html/img/admin.PNG" alt="profileImg">
      </div>
      <div class="name-job">
      <h3 id="name"></h3>
        <div class="profile_name">ADMIN</div>
      </div>
<a href="../../disconnect.php" class="logout-link">
    <i class='bx bx-log-out'></i>
</a>
    </div>
  </li>
</ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text"></span>
    </div>
<!--DASH-MANAGER-->
 <div class="update-user">
<?php
echo  "<h1>Update User:</h1>";
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
session_destroy();
header("Location: ../error.php");
exit();
}

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


</div>
 </section>

  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>
</body>
</html>






