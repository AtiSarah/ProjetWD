<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="user.css">
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
        <li><a href="dashuser.php">User</a></li>
          <li><a href="../driver/dashdriver.php">Driver</a></li>
          <li><a href="../manager/dashmanager.php">Manager</a></li>
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
        <li><a href="user.php">User</a></li>
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
       <li><a href="deleteuser.php">User</a></li>
         <li><a href="../driver/deletedriver.php">Driver</a></li>
         <li><a href="../manager/deletemanager.php">Manager</a></li>
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
       <li><a href="updateuser.php">User</a></li>
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
<!--CREATE-USER-->
 <div class="create-user">
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
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['profile'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $profile = $_POST['profile'];

            // Vérifier si l'e-mail existe déjà dans la base de données
            $check_email_query = "SELECT * FROM user WHERE email = ?";
            $check_email_stmt = $link->prepare($check_email_query);
            $check_email_stmt->bind_param("s", $email);
            $check_email_stmt->execute();
            $result = $check_email_stmt->get_result();

            if ($result->num_rows > 0) {
                // L'e-mail existe déjà, afficher un message d'erreur ou effectuer une autre action
                echo "Cet e-mail existe déjà dans la base de données.";
            } else {
                // L'e-mail n'existe pas encore, procéder à l'insertion

                // Hasher le mot de passe 
                $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insérer les données de l'utilisateur
                $sql = $link->prepare("INSERT INTO user (email, pass, profile) VALUES (?, ?, ?)");
                $sql->bind_param("sss", $email, $pwd_hash, $profile);
                $sql->execute();

                // Obtenir l'ID de l'utilisateur inséré
                $user_id = $link->insert_id;

                // Stocker l'ID de l'utilisateur en session pour une utilisation future
                $_SESSION['user_id'] = $user_id;

                // Fermer l'instruction
                $sql->close();

                // Rediriger en fonction du profil
                if ($profile == 0) {
                    header("Location: ../manager/manager.php");
                    exit();
                } elseif ($profile == 1) {
                    header("Location: ../driver/driver.php");
                    exit();
                } elseif ($profile == 3) {
                    header("Location: ../admin.php");
                    exit();
                }
            }
            // Fermer l'instruction de vérification de l'e-mail
            $check_email_stmt->close();
        }
    }
}
?>
    <div id="inscreption-form">
    <h1>Create User :</h1>
    <form action="user.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="password" required><br><br>
        
        <label for="profile">Profile:</label><br>
        <select id="profile" name="profile" required>
        <option value="0">Manager</option>
        <option value="1">Driver</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="CREATE">
    </form>
    </div>
   
</body>
</html>


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






