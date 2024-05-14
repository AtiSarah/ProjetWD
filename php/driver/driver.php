<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];

// Si le bouton Disconnect est cliqué, déconnectez l'utilisateur et redirigez-le vers la page de connexion
if (isset($_POST['disconnect'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <link rel="stylesheet" href="driver.css">
</head>
<body>
    <div class="sidebar">
        <h2>MENU</h2>
        <ul>
            <li><a href="driver.php">DASHBOARD</a></li>
            <li><a href="incidentals.php">INCIDENTALS</a></li>
            <li><a href="account.php">ACCOUNT</a></li>
            <li>
                <!-- Formulaire pour le bouton Disconnect -->
                <form method="post">
                    <button type="submit" name="disconnect">Disconnect</button>
                </form>
            </li>
        </ul>
    </div>
    <div id="DASHBOARD">
        <table border="1"> 
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Arrival City</th>
                    <th>Departure Date</th>
                    <th>Duration (Deadline)</th>
                    <th>Cost</th>
                    <th>Vehicle</th>
                </tr>
            </thead>  
            <tbody>
                <tr>
                    <td><!-- Mission Type content --></td> 
                    <td><!-- Departure City content --></td>
                    <td><!-- Arrival City content --></td>
                    <td><!-- Departure Date content --></td>
                    <td><!-- Duration content --></td>
                    <td><!-- Cost content --></td>
                    <td><!-- Vehicle content --></td>
                </tr>
                <!-- More mission entries can be added here -->
            </tbody>
        </table>
       <button>DONE</button>
    </div>
    
</body>
</html>
