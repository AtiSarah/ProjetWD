<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['profile0'])) {
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
    <link rel="stylesheet" href="setvehicle.css">
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
 
<div class="Set-vehicle">
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


</html>
 <!-- SET VEHICLE-->
<?php
    if (isset($_SESSION['mission_added']) && $_SESSION['mission_added'] === true) {
    // Sélectionnez toutes les données des véhicules depuis la base de données
    $sql = "SELECT v.id_vehicle, v.immatriculation, v.type, v.license_type, v.brand, v.state 
    FROM vehicle v
    LEFT JOIN mission m ON v.id_vehicle = m.id_vehicle AND m.finish = 0
    WHERE m.id_vehicle IS NULL";
    $result = $link->query($sql); 



    // Vérifiez s'il y a des données disponibles
    if ($result->num_rows > 0) {
        echo "<h1>Vehicle:</h1>";
        // Démarrez la sortie du formulaire pour sélectionner un véhicule
        echo "<form action='setdriver.php' method='post'>";
        // Démarrez la sortie du tableau HTML
        echo "<table border='1'>
        <tr>
        <th>ID Vehicle</th>
        <th>Immatriculation</th>
        <th>Type</th>
        <th>License Type</th>
        <th>Brand</th>
        <th>State</th>
        <th>Action</th>
        </tr>";

        // Sortie des données de chaque ligne
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_vehicle"] . "</td>";
            echo "<td>" . $row["immatriculation"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["license_type"] . "</td>";
            echo "<td>" . $row["brand"] . "</td>";
            echo "<td>" . $row["state"] . "</td>";
            // Ajoutez un bouton pour sélectionner ce véhicule
            echo "<td><button type='submit' name='selected_vehicle' value='" . $row["id_vehicle"] . "'>Set Driver</button></td>";
            //envoyer id_vehicle a setdriver 
            echo "</tr>";
        }
        // Fin du tableau HTML
        echo "</table>";
        // Fermez le formulaire
        echo "</form>";
    } else {
        echo "0 results"; // Si aucune donnée n'est disponible
    }
    $link->close();
    echo '<a href="addmission.php"><button>Cancel</button></a>';
 
}else{ //revenir a l'ajout de mission
  header("Location: addmission.php");
  
}
?>
</div>
</body>
 </section>