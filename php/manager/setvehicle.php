<?php
session_start();
include("../dbp.php");

if (isset($_SESSION['mission_added']) && $_SESSION['mission_added'] === true) {
  


    // Sélectionnez toutes les données des véhicules depuis la base de données
    $sql = "SELECT id_vehicle, immatriculation, type, license_type, brand, state FROM vehicle";
    $result = $link->query($sql);

    // Vérifiez s'il y a des données disponibles
    if ($result->num_rows > 0) {
        echo "<h1>Vehicle</h1>";
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
    echo '<a href="manager"><button>Cancel</button></a>';
}
?>
