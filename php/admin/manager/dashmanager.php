<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="dashmanager.css">
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
          <li><a href="../driver/dashdriver.php">Driver</a></li>
          <li><a href="dashmanager.php">Manager</a></li>
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
         <li><a href="../driver/deletedriver.php">Driver</a></li>
         <li><a href="deletemanager.php">Manager</a></li>
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
         <li><a href="../driver/updatedriver.php">Driver</a></li>
         <li><a href="updatemanager.php">Manager</a></li>
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
 <div class="dash-manager">
<?php
session_start();
include("../dbp.php"); 
if ( !isset($_SESSION['admin']) ) {
    header("Location: ../../error.php");
    exit();
}


// Query to select all records from the manager table
$sql = "SELECT id_manager, id, firstname, lastname, datenaiss, phone FROM manager";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if there are any records returned
if ($result && mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<h1>Manager:</h1>";
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


