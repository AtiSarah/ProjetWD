<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="deletevehicle.css">
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
          <li><a href="../manager/dashmanager.php">Manager</a></li>
          <li><a href="dashvehicle.php">Vehicle</a></li>
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
        <li><a href="../user/dashuser.php">User</a></li>
          <li><a href="../driver/driver.php">Driver</a></li>
          <li><a href="../manager/manager.php">Manager</a></li>
          <li><a href="vehicle.php">Vehicle</a></li>
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
         <li><a href="../manager/deletemanager.php">Manager</a></li>
         <li><a href="deletevehicle.php">Vehicle</a></li>
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
    
<!--DELETE VEHICLE-->
 <div class="delete-vehicle">
 <?php
session_start();
include("../dbp.php"); 
if ( !isset($_SESSION['admin']) ) {
    header("Location: ../../error.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    try {
        // Delete vehicle
        $deleteSql = $link->prepare("DELETE FROM vehicle WHERE id_vehicle = ?");
        $deleteSql->bind_param("i", $id);
        $deleteSql->execute();
        $deleteSql->close();

        // Redirect to the same page to refresh the table
        header("Location: deletevehicle.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint error
        echo "Cannot delete vehicle. It is associated with existing missions.";
    }
}
echo "<h1>Delete vehicle:</h1>";

// Query to select all records from the vehicle table
$sql = "SELECT * FROM vehicle";
$result = $link->query($sql);

// Check if there are any records returned
if ($result && $result->num_rows > 0) {
    // Table header
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Immatriculation</th>
    <th>Type</th>
    <th>Brand</th>
    <th>State</th>
    <th>License Type</th>
    <th>Action</th>
    </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id_vehicle"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["immatriculation"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["state"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["license_type"]) . "</td>";
        echo "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to delete this vehicle?\")' action='deletevehicle.php'>
                <input type='hidden' name='id' value='" . $row["id_vehicle"] . "'>
                <input type='submit' name='delete' value='Delete' class='delete-btn'>
            </form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found";
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


