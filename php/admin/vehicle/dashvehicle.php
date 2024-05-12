<?php
include("../dbp.php");

// Sélectionnez toutes les données des véhicules depuis la base de données
$sql = "SELECT id_vehicle, immatriculation, type, license_type, state FROM vehicle";
$result = $link->query($sql);

// Vérifiez s'il y a des données disponibles
if ($result->num_rows > 0) {
    // Démarrez la sortie du tableau HTML
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Immatriculation</th>
    <th>Type</th>
    <th>Type de licence</th>
    <th>État</th>
    </tr>";

    // Sortie des données de chaque ligne
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_vehicle"] . "</td>";
        echo "<td>" . $row["immatriculation"] . "</td>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["license_type"] . "</td>";
        echo "<td>" . $row["state"] . "</td>";
        echo "</tr>";
    }
    // Fin du tableau HTML
    echo "</table>";
} else {
    echo "0 results"; // Si aucune donnée n'est disponible
}
$link->close();
echo '<a href="../admin.php"><button>done</button></a>';
?>