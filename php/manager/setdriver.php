<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
//home page affichage
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
    <link rel="stylesheet" href="setdriver.css">
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
   
    <!--Set-driver-->
 <div class="set-driver">
 <?php
if(isset($_POST['selected_vehicle'])) {
    $id_vehicle = $_POST['selected_vehicle'];
    $departureCity = $_SESSION['departure_city'];
    $arrivalCity = $_SESSION['arrival_city'];
    $departureDate = $_SESSION['departure_date'];
    $duration = $_SESSION['duration'];
    $cost = $_SESSION['cost'];
    $type = $_SESSION['type'];

    // Sélectionnez le type de licence du véhicule sélectionné
    $sql_vehicle = "SELECT license_type FROM vehicle WHERE id_vehicle = $id_vehicle";
    $result_vehicle = $link->query($sql_vehicle);
    $row_vehicle = $result_vehicle->fetch_assoc();
    $vehicle_license_type = $row_vehicle['license_type'];

    // Vérifiez si le type de licence du véhicule est défini
    if(isset($vehicle_license_type)) {
        // Sélectionnez les conducteurs ayant le même type de licence que le véhicule sélectionné
        $sql = "SELECT d.id_driver, d.id, d.firstname, d.lastname, d.datenaiss, d.phone, d.license_type 
                FROM driver d
                JOIN user u ON d.id = u.id
                WHERE d.license_type = '$vehicle_license_type'";
        $result = $link->query($sql);
        
        // Vérifiez s'il y a des données disponibles
        if ($result->num_rows > 0) {
            echo "<h1>Driver:</h1>";
            // Démarrez la sortie du tableau HTML
            echo "<table border='1'>
            <tr>
            <th>ID</th>
            <th>ID Driver</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Phone</th>
            <th>License Type</th>
            <th>Action</th>
            </tr>";
        
            // Sortie des données de chaque ligne
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["id_driver"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<td>" . $row["datenaiss"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["license_type"] . "</td>";
                echo "<td><form action='' method='post' onclick='return confirmMission()'>
                <input type='hidden' name='selected_driver' value='" . $row["id_driver"] . "'>
                <input type='hidden' name='selected_vehicle' value='" . $id_vehicle . "'>
                <button type='submit' name='confirm_mission' >Confirm</button>
                </form></td>";
                 echo "</tr>";
               
            }
            // Fin du tableau HTML
            echo "</table>";
            echo '<a href="setvehicle.php"><button>Return</button></a>';
            echo'  <span class="button-space"></span> <!-- Espace -->';
            echo '<a href="account.php"><button>done</button></a>';
            
        } else {
            
            echo "No drivers available for the selected vehicle's license type. ";
            echo'<br>';
            echo '<a href="setvehicle.php"><button>Return</button></a>';
        }
    } else {
        echo "License type for the selected vehicle is not defined.";
        echo'<br>';
        echo '<a href="setvehicle.php"><button>Return</button></a>';
        
    }

    // Si le formulaire pour confirmer la mission est soumis
    if(isset($_POST['confirm_mission'])) {
        $id_driver = $_POST['selected_driver'];

        // Insérer les données de la mission dans la base de données
        $sql = "INSERT INTO mission (id_driver, id_vehicle, departure_city, arrival_city, departure_date, duration, cost, type) 
                VALUES ('$id_driver', '$id_vehicle', '$departureCity', '$arrivalCity', '$departureDate', '$duration', '$cost', '$type')";

        if (!$link->query($sql) === TRUE) {
          echo "Error: " . $sql . "<br>" . $link->error;
        }
            
    }
    $link->close();
} else {
    echo "Vehicle ID not found in session.";
}
?>
</div>

</section>
    
<script>
  function confirmMission() {
    // Afficher une boîte de dialogue d'alerte pour la confirmation
    if (confirm("Are you sure you want to send this mission?")) {
      return true;
    }
   
    return false;
  }


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
