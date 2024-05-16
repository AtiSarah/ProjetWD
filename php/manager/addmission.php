<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
if (!empty($_POST['departure_city']) && !empty($_POST['arrival_city']) && !empty($_POST['departure_date']) && !empty($_POST['duration']) && !empty($_POST['cost']) && !empty($_POST['type'])) {
  
        $departureCity = $_POST['departure_city'];
        $arrivalCity = $_POST['arrival_city'];
        $departureDate = $_POST['departure_date'];
        $duration = $_POST['duration'];
        $cost = $_POST['cost'];
        $type = $_POST['type'];
        
        // Check if departure date is greater than the current date
        if (strtotime($departureDate) >= time()) {
            // Set session variables and redirect
            $_SESSION['mission_added'] = true;
            $_SESSION['departure_city'] = $departureCity;
            $_SESSION['departure_date'] = $departureDate;
            $_SESSION['arrival_city'] = $arrivalCity;
            $_SESSION['duration'] = $duration;
            $_SESSION['cost'] = $cost;
            $_SESSION['type'] = $type;
            header("Location: setvehicle.php");
            exit();
        } else {


          echo '<script>
          window.onload = function() {
              alert("Departure date should be greater than the current date!");
          }
        </script>';
        }
           }
        
            
        
     else {


      echo '<script>
      window.onload = function() {
          alert("Error adding mission. Please try again!");
      }
    </script>';
    }
                  
    }}



//home page info
$id = $_SESSION['user_id'];
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
    <link rel="stylesheet" href="addmission.css">
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
    <!-- Add Mission-->
   <div class="add-mission">
    <h2>Add Mission:</h2>
    <form method="post">
        <label for="departure_city">Departure City:</label><br>
        <input type="text" id="departure_city" name="departure_city" required><br><br>
        <label for="arrival_city">Arrival City:</label><br>
        <input type="text" id="arrival_city" name="arrival_city" required><br><br>
        <label for="departure_date">Departure Date:</label><br>
        <input type="date" id="departure_date" name="departure_date" required><br><br>
        <label for="duration">Duration (min):</label><br>
        <input type="number" id="duration" name="duration" required><br><br>
        <label for="cost">Cost:</label><br>
        <input type="number" id="cost" name="cost" required><br><br>
        <label for="state">Type:</label><br>
        <input type="text" id="type" name="type" required><br><br>
        <input type="submit" name="submit" value="Set Vehicle">
        <input type="reset" name="cancel" value="Cancel">
    </form>
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

    


















    
















