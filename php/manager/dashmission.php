<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['profile0'])) {
  header("Location: ../error.php");
  exit();
}
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
    <link rel="stylesheet" href="dashmission.css">
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
    <!-- DASH MISSION-->
    <div class="dash-mission">
      <?php
      // Query to select all records from the mission table
      $sql = "SELECT id_mission, id_driver, id_vehicle, departure_city, arrival_city, departure_date, arrival_date, cost, type, finish FROM mission";

      // Execute the query
      $result = mysqli_query($link, $sql);

      // Check if there are any records returned
      if ($result && mysqli_num_rows($result) > 0) {
          // Display table header
          echo "<h1>Mission:</h1>";
          echo "<table border='1'>
          <tr>
          <th>ID</th>
          <th>ID Driver</th>
          <th>ID Vehicle</th>
          <th>Departure City</th>
          <th>Arrival City</th>
          <th>Departure Date</th>
          <th>Arrival Date</th>
          <th>Cost</th>
          <th>Type</th>
          <th>Finish</th>
          <th>Action</th>
          </tr>";

          // Output data of each row
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id_mission']) . "</td>";
              echo "<td>" . htmlspecialchars($row['id_driver']) . "</td>";
              echo "<td>" . htmlspecialchars($row['id_vehicle']) . "</td>";
              echo "<td>" . htmlspecialchars($row['departure_city']) . "</td>";
              echo "<td>" . htmlspecialchars($row['arrival_city']) . "</td>";
              echo "<td>" . htmlspecialchars($row['departure_date']) . "</td>";
              echo "<td>" . htmlspecialchars($row['arrival_date']) . "</td>";
              echo "<td>" . htmlspecialchars($row['cost']) . "</td>";
              echo "<td>" . htmlspecialchars($row['type']) . "</td>";
              echo "<td>" . ($row['finish'] == 0 ? 'False' : 'True') . "</td>";
              echo "<td>
                    <form action='incidentals.php' method='POST'>
                        <input type='hidden' name='mission_id' value='" . $row['id_mission'] . "'>
                        <button type='submit' class='view-button'>View Incidentals</button>
                    </form>
                  </td>";
              echo "</tr>";
          }

          // Close the table
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
    arrow[i].addEventListener("click", (e) => {
      let arrowParent = e.target.parentElement.parentElement; // selecting main parent of arrow
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
