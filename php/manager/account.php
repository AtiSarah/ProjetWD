
<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || !isset($_SESSION['profile0'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}$id = $_SESSION['user_id'];
$sql = $link->prepare("SELECT * FROM manager WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="account.css">
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
      <li>
        <a href="dashmission.php"><!-- DASHBOARD MISSION-->
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="dashmission.php">Dashboard</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-collection' ></i>
            <span class="link_name">Mission</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
        <li><a href="addmission.php">Add Mission</a></li><!-- ADD MISSION-->
          <li><a href="updatemission.php">Update Mission</a></li><!-- UPDATE INCIDENTALS-->
          <li><a href="deletemission.php">Delete Mission</a></li><!-- DELETE MISSION-->
          
        </ul>
      </li>
      <li>
      <a href="account.php"><!-- ACCOUNT-->
            <i class="fa-solid fa-user"></i>
          <span class="link_name">Account</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="account.php">Account</a></li>
        </ul>
      </li>
      <li>
    <div class="profile-details">
      <div class="profile-content">
      <img src="../../html/img/manager.PNG" alt="profileImg">
      </div>
      <div class="name-job">
      <h3 id="name"></h3>
        <div class="profile_name"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></div>
        <div class="job">Manager</div>
      </div>
<a href="../disconnect.php" class="logout-link">
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
    <!-- Information manager-->
 <div class="info-manager">
        <h3>Personal Information: </h3><br>
            <?php
                $sql = $link->prepare("SELECT * FROM manager WHERE id = ?");
                $sql->bind_param("i", $id);
                $sql->execute();
                $result = $sql->get_result();
                $row = $result->fetch_assoc();
            ?>
        <label  id="name">First Name: <?php echo $row['firstname']; ?></label><br>
        <label id="firstname">Last Name: <?php echo $row['lastname']; ?></label><br>
        <label id="date of birth"> Date of birth : <?php echo $row['datenaiss']; ?> </label><br>
        <label id="phone">Phone: <?php echo $row['phone']; ?> </label><br>
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


