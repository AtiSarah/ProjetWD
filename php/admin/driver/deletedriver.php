<?php
session_start();
include("../dbp.php"); 

$message = ""; // Initialize a message variable

if ( !isset($_SESSION['admin']) ) {
    header("Location: ../../error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $selectDriverSql = $link->prepare("SELECT id_driver FROM driver WHERE id = ?");
    $selectDriverSql->bind_param("i", $id);
    $selectDriverSql->execute();
    $result = $selectDriverSql->get_result(); 
    $row = $result->fetch_assoc();
    $selectDriverSql->close();
    $id_driver = $row["id_driver"];
   

    // Check if the user confirms the deletion
    if (isset($_POST['confirm_delete'])) {
        // Check if there are related records in the mission table
        $checkMissionSql = $link->prepare("SELECT id_mission FROM mission WHERE id_driver = ?");
        $checkMissionSql->bind_param("i", $id_driver);
        $checkMissionSql->execute();
        $checkMissionResult = $checkMissionSql->get_result();

        if ($checkMissionResult->num_rows > 0) {
            // Display error message or handle related records deletion
            $message = "Cannot delete driver. Related mission records exist.";
        } else {
            // No related records found, proceed with driver deletion
            $deleteDriverSql = $link->prepare("DELETE FROM driver WHERE id = ?");
            $deleteDriverSql->bind_param("i", $id);
            $deleteDriverSql->execute();
            $deleteDriverSql->close();
            
            // Delete the associated user
            $deleteUserSql = $link->prepare("DELETE FROM user WHERE id = ?");
            $deleteUserSql->bind_param("i", $id);
            $deleteUserSql->execute();
            $deleteUserSql->close();

            $message = "Driver and associated user deleted successfully.";
        }

        // Close prepared statements and database connection
        $checkMissionSql->close();
        mysqli_close($link);
    } else {
        $message = "Deletion cancelled.";
    }
}
?>

<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="deletedriver.css">
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
        <li><a href="../user/dashuser.php">User</a></li>
          <li><a href="dashdriver.php">Driver</a></li>
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
        <li><a href="../user/user.php">User</a></li>
          <li><a href="../vehicle/vehicle.php">Vehicle</a></li>
        </ul>
      </li>
     <li> <!--DELETE -->     
       <div class="iocn-link">
         <a href="#">
         <i class="fa-solid fa-minus"></i>
           <span class="link_name">DELETE</span>
         </a>
         <i class='bx bxs-chevron-down arrow' ></i>
       </div>
       <ul class="sub-menu">
         <li><a href="deletedriver.php">Driver</a></li>
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
       <li><a href="../user/updateuser.php">User</a></li>
         <li><a href="updatedriver.php">Driver</a></li>
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
    <!--DASH-DRIVER-->
    <div class="delete-driver">
        <h1>Delete Driver:</h1>
        <?php
        // Include the database connection file
        include("../dbp.php");

        // Query to select all records from the driver table
        $sql = "SELECT * FROM driver";
        $result = $link->query($sql);

        // Check if there are any records returned
        if ($result && $result->num_rows > 0) {
            // Display table header
            
            echo "<table border='1'>
            <tr>
            <th>ID Driver</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Phone</th>
            <th>Action</th>
            </tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_driver"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<td>" . $row["datenaiss"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td><form method='post' action='deletedriver.php?id=" . $row["id"] . "' onsubmit='return confirm(\"Are you sure you want to delete this driver?\")'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <input type='hidden' name='confirm_delete' value='true'> <!-- Added hidden input for confirmation -->
                        <input type='submit' name='delete' value='Delete' class='delete-btn'>
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

        // Display message
        if ($message) {
            echo "<p class='message'>$message</p>";
        }
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
