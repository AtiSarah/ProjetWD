<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>driver</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <div class="sidebar">
<h2>MENU </h2>
<ul>
    <li><a href="driver.php">DASHBOARD</a></li>
    <li><a href="incidentals.php">INCIDENTALS</a></li>
    <li><a href="account.php">ACCOUNT</a></li></ul>

<div class="mission-details"><h3>Personal Information: </h3><br>
<?php

$sql = $link->prepare("SELECT * FROM driver WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?>

    <label  id="name">First Name: <?php echo $row['firstname']; ?></label><br>
    <label id="firstname">Last Name: <?php echo $row['lastname']; ?></label><br>
    <label id="licenseType"> License Type :<?php echo $row['license_type']; ?> </label><br>
    <label id="date of birth"> License Type :<?php echo $row['datenaiss']; ?> </label><br>
    <label id="phone">Employee Code:<?php echo $row['phone']; ?> </label><br>
</div>
</div>
</body>
</html>