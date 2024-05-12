<?php
session_start();
include("../dbp.php"); 
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>driver</title>
    <link rel="stylesheet" href="incidentals.css">
</head>
<body>
    <div class="sidebar">
<h2>MENU </h2>
<ul>
    <li><a href="driver.php?id=<?php echo $id;?>">DASHBOARD</a></li>
    <li><a href="incidentals.php?id=<?php echo $id;?>">INCIDENTALS</a></li>
    <li><a href="account.php?id=<?php echo $id;?>">ACCOUNT</a></li></ul>
</ul>

<div id="frais-imprevus">
    <form action="" name="imprevus">
        <legend><strong>Incidentals</strong></legend>
        <input type="text" placeholder="enter incidentals..."><br>
        <input type="number" placeholder="enter amount..."><br>
        <input type="submit" value="Send">&nbsp;
        <input type="reset" value="Cancel">
    </form>
</div>
</body>
</html>