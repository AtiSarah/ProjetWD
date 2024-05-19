<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['profile1'])) {
  header("Location: ../error.php");
  exit();
}
$id = $_SESSION['user_id'];

// Récupérer l'id_driver associé à l'utilisateur connecté
$sql1 = $link->prepare("SELECT id_driver FROM driver WHERE id = ?");
$sql1->bind_param("i", $id);
$sql1->execute();
$result1 = $sql1->get_result();
$rowW = $result1->fetch_assoc();
$id_driver = $rowW['id_driver'];

// Récupérer les informations de l'utilisateur
$sql = $link->prepare("SELECT * FROM driver WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

// Récupérer les missions pour le conducteur connecté
$mission_sql = $link->prepare("SELECT * FROM mission WHERE id_driver = ?");
$mission_sql->bind_param("i", $id_driver);
$mission_sql->execute();
$mission_result = $mission_sql->get_result();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Account</title>
  <link rel="stylesheet" href="driver.css">
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
        <a href="driver.php"><!-- DASHBOARD-->
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="driver.php">Dashboard</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="mission.php">
            <i class='bx bx-collection' ></i>
            <span class="link_name">Mission</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a href="mission.php">View Mission</a></li><!-- MISSION-->
          <li><a href="incidentals.php">Add Incidentals</a></li><!-- ADD INCIDENTALS-->
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
      <img src="../../html/img/driver.PNG" alt="profileImg">
      </div>
      <div class="name-job">
      <h3 id="name"></h3>
        <div class="profile_name"><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></div>
        <div class="job">Driver</div>
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
<!-- Dashboard driver-->
 <div class="Dashboard-driver">
        <table border="1"> 
            <thead>
                <tr>
                    <th>Departure_City</th>
                    <th>Arrival_City</th>
                    <th>Departure_Date</th>
                    <th>Duration (Deadline)</th>
                    <th>Cost</th>
                    <th>Type</th>
                    <th>Vehicle</th>
                </tr>
            </thead>  
            <tbody>
                <?php while ($mission_row = $mission_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mission_row['departure_city']); ?></td>
                    <td><?php echo htmlspecialchars($mission_row['arrival_city']); ?></td>
                    <td><?php echo htmlspecialchars($mission_row['departure_date']); ?></td>
                    <td><?php echo htmlspecialchars($mission_row['duration']); ?></td>
                    <td><?php echo htmlspecialchars($mission_row['cost']); ?></td>
                    <td><?php echo htmlspecialchars($mission_row['type']); ?></td>
                    <!-- You need to fetch and display the vehicle details for this mission -->
                    <td><?php echo htmlspecialchars($mission_row['id_vehicle']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
       <button>Start</button>
    </div>
  </section>
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
      let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
      arrowParent.classList.toggle("showMenu");
    });
  }

  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
  });
</script>

</body>
</html>
