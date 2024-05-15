
<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];
$sql = $link->prepare("SELECT * FROM driver WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="test.css">
    <style>
        /* Insérer ici le code CSS fourni */
    </style>
</head>
<body>

<div class="wrapper">
   
<div class="section">
        <div class="top_navbar">
            <div class="hamburger">
                <a href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
        </div>
    </div>
        <div class="sidebar">
            
            <div class="profile">
            <img src="Capture.png">  
                <h3 id="name"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></h3>
                <p>Driver</p>
                
            </div>
            <ul>
                <li>
                    <a href="test.php" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">DASHBOARD</span>
                    </a>
                </li>
                
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-database"></i></span>
                        <span class="item">INCIDENTALS</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        <span class="item">REPORTS</span>
                    </a>
                </li>
                <li>
                    <a href="account.php">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <span class="item">ACCOUNT</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

  

    <script>
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function(){
            document.querySelector("body").classList.toggle("active");
        })
    </script>
</body>
</html>