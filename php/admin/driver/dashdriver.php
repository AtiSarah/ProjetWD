<?php
include("../dbp.php");

// Sélectionnez toutes les données des conducteurs depuis la base de données
$sql = "SELECT d.id_driver, d.id, d.firstname, d.lastname, d.datenaiss, d.phone, d.license_type 
        FROM driver d
        JOIN user u ON d.id = u.id";
$result = $link->query($sql);

// Vérifiez s'il y a des données disponibles
if ($result->num_rows > 0) {
    // Démarrez la sortie du tableau HTML
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>ID Driver</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Date of Birth</th>
    <th>Phone</th>
    <th>License Type</th>
    </tr>";

    // Sortie des données de chaque ligne
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["id_driver"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["datenaiss"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["license_type"] . "</td>";
        echo "</tr>";
    }
    // Fin du tableau HTML
    echo "</table>";
} else {
    echo "0 results"; // Si aucune donnée n'est disponible
}
$link->close();
?>
