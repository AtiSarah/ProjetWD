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
    <link rel="stylesheet" href="deletemission.css">
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
    <!--DELETE MISSION-->
<div class="delete-mission">
    <?php
    echo"<h1>Delete mission:</h1>";
    
        $sql = "SELECT * FROM mission";
        $result = $link->query($sql);

        // Check if there are any records returned
        if ($result && $result->num_rows > 0) {
            // Display table header
            echo "<table border='1'>
            <tr>
            <th>ID&nbsp;Mission</th>
            <th>ID&nbsp;Driver</th>
            <th>ID&nbsp;Vehicle</th>
            <th>Departure&nbsp;City</th>
            <th>Arrival&nbsp;City</th>
            <th>Departure&nbsp;Date</th>
            <th>&nbsp;Arrival&nbsp;Date</th>
            <th>Cost</th>
            <th>Type</th>
            <th>Finish</th>
             <th>Action</th>
            </tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_mission"] . "</td>";
                echo "<td>" . $row["id_driver"] . "</td>";
                echo "<td>" . $row["id_vehicle"] . "</td>";
                echo "<td>" . $row["departure_city"] . "</td>";
                echo "<td>" . $row["arrival_city"] . "</td>";
                echo "<td>" . $row["departure_date"] . "</td>";
                echo "<td>" . $row["arrival_date"] . "</td>";
                echo "<td>" . $row["cost"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . ($row["finish"] == 0 ? 'false' : 'true') . "</td>";
                echo "<td><form method='post' action='deletemission.php' onsubmit='return confirmDelete(" . $row["finish"] . ", " . $row["id_mission"] . ")'>
                <input type='hidden' name='id' value='" . $row["id_mission"] . "'>
                <input type='submit' name='delete' class='delete-mission-btn' value='Delete'>
            </form></td>";
        
                echo "</tr>";
            }
            // Close the table
            echo "</table>";
        } else {
            echo "No missions found ";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
            $id = $_POST['id'];
            
            // Check if the mission has incidentals
            $checkIncidentalsSql = $link->prepare("SELECT COUNT(*) as count FROM incidental WHERE id_mission = ?");
            $checkIncidentalsSql->bind_param("i", $id);
            $checkIncidentalsSql->execute();
            $incidentalsResult = $checkIncidentalsSql->get_result();
            $incidentalsRow = $incidentalsResult->fetch_assoc();
            
            if ($incidentalsRow['count'] > 0) {
                echo "<script>alert('This mission has incidentals.');</script>";
            } else {
                // Delete the mission
                $deleteSql = $link->prepare("DELETE FROM mission WHERE id_mission = ?");
                $deleteSql->bind_param("i", $id);
                $deleteSql->execute();

                if ($deleteSql->affected_rows > 0) {
                    echo "<script>alert('Mission deleted successfully.'); window.location.href='deletemission.php';</script>";
                } else {
                    echo "<script>alert('Failed to delete mission.');</script>";
                }

                $deleteSql->close();
            }

            $checkIncidentalsSql->close();
        }

        // Close the database connection
        mysqli_close($link);
    ?>
</div>
  </section>
  <script>
  function confirmDelete(finish, missionId) {
    if (finish == 0) {
      return confirm("This mission is still in progress. Are you sure you want to delete it?");
    }
    
    let hasIncidentals = <?php
    $incidentalsCheckSql = "SELECT id_mission, COUNT(*) as count FROM incidental GROUP BY id_mission";
    $incidentalsCheckResult = $link->query($incidentalsCheckSql);
    $incidentalsArray = [];
    while ($row = $incidentalsCheckResult->fetch_assoc()) {
      $incidentalsArray[$row['id_mission']] = $row['count'];
    }
    echo json_encode($incidentalsArray);
    ?>;
    
    if (hasIncidentals[missionId] > 0) {
      alert("This mission has incidentals.");
      return false;
    }
    
    return true;
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