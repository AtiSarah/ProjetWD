<?php
session_start();
include("../dbp.php"); 
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../error.php");
    exit();
}
$id = $_SESSION['user_id'];

if(isset($_POST['selected_vehicle'])) {
    $id_vehicle = $_POST['selected_vehicle'];
    $departureCity = $_SESSION['departure_city'];
    $arrivalCity = $_SESSION['arrival_city'];
    $departureDate = $_SESSION['departure_date'];
    $duration = $_SESSION['duration'];
    $cost = $_SESSION['cost'];
    $type = $_SESSION['type'];

    // Sélectionnez le type de licence du véhicule sélectionné
    $sql_vehicle = "SELECT license_type FROM vehicle WHERE id_vehicle = $id_vehicle";
    $result_vehicle = $link->query($sql_vehicle);
    $row_vehicle = $result_vehicle->fetch_assoc();
    $vehicle_license_type = $row_vehicle['license_type'];

    // Vérifiez si le type de licence du véhicule est défini
    if(isset($vehicle_license_type)) {
        // Sélectionnez les conducteurs ayant le même type de licence que le véhicule sélectionné
        $sql = "SELECT d.id_driver, d.id, d.firstname, d.lastname, d.datenaiss, d.phone, d.license_type 
                FROM driver d
                JOIN user u ON d.id = u.id
                WHERE d.license_type = '$vehicle_license_type'";
        $result = $link->query($sql);
        
        // Vérifiez s'il y a des données disponibles
        if ($result->num_rows > 0) {
            echo "<h1>Driver</h1>";
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
            <th>Action</th>
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
                echo "<td><form action='' method='post'> <!-- Utilisez le même fichier pour l'action -->
                <input type='hidden' name='selected_driver' value='" . $row["id_driver"] . "'>
                <input type='hidden' name='selected_vehicle' value='" . $id_vehicle . "'>
                <button type='submit' name='confirm_mission'>Confirm</button> <!-- Renommez le bouton pour indiquer la confirmation de la mission -->
                </form></td>";
                 echo "</tr>";
            }
            // Fin du tableau HTML
            echo "</table>";
            
        } else {
            echo "No drivers available for the selected vehicle's license type."; // Si aucun conducteur n'est disponible avec le type de licence du véhicule
        }
    } else {
        echo "License type for the selected vehicle is not defined.";
    }

    // Si le formulaire pour confirmer la mission est soumis
    if(isset($_POST['confirm_mission'])) {
        $id_driver = $_POST['selected_driver'];

        // Insérer les données de la mission dans la base de données
        $sql = "INSERT INTO mission (id_driver, id_vehicle, departure_city, arrival_city, departure_date, duration, cost, type) 
                VALUES ('$id_driver', '$id_vehicle', '$departureCity', '$arrivalCity', '$departureDate', '$duration', '$cost', '$type')";

        if ($link->query($sql) === TRUE) {
            header("Location: manager.php");
        } else {
            echo "Error: " . $sql . "<br>" . $link->error;
        }

    }

    $link->close();
    
    echo '<a href="manager.php"><button>Cancel</button></a>';
} else {
    echo "Vehicle ID not found in session.";
}
?>
