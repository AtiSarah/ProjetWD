<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="updatemanager.css">
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
          <li><a href="../driver/driver.php">Driver</a></li>
          <li><a href=".manager.php">Manager</a></li>
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
       <li><a href="../user/deleteuser.php">User</a></li>
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
<!--UPDATE MANAGER-->
 <div class="update-manager">
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
echo "<h1>Update Manager:</h1>";
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
                    <button type='submit' name='update' onclick='confirmUpdate(" . $row['id_manager'] . ")' class='update-button'>Update</button>
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

<form id="confirmForm" method="post" action="">
    <input type="hidden" id="id_driver" name="id_driver">
    <input type="hidden" id="confirmAction" name="confirmAction">
</form>

<script>
    function confirmUpdate(id_driver) {
        if (confirm("Are you sure you want to update this driver?")) {
            document.getElementById("id_driver").value = id_driver;
            document.getElementById("confirmAction").value = "update";
            document.getElementById("confirmForm").submit();
        }
    }
</script>
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


