<?php
session_start();
include("../dbp.php"); 

// Vérifie si la session n'est pas définie
if(!isset($_SESSION["id"]))
{  
    // Redirige vers la page de connexion avec un message d'erreur
    header("location: login.php?error=Veuillez vous connecter pour accéder à cette page.");
    exit; // Assurez-vous d'arrêter l'exécution du script après la redirection
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
