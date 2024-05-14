<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>mission</title>
    <link rel="stylesheet" href="mission.css" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    

<!-- Sidebar -->
<div class="sidebar">
<h2>MENU </h2>
<ul>
    <li><a href="dashmission.php">MISSION</a></li>
    <li><a href="mission.php">ADD MISSION</a></li>
    <li><a href="deletemission.php">DELETE MISSION</a></li>
    <li><a href="updatemission.php">EDIT MISSION</a></li>
</ul>
</div>






</body>
</html>
