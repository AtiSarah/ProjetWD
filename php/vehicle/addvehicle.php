<?php
session_start();
include("../dbp.php"); // Inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['immatriculation']) && isset($_POST['type']) && isset($_POST['brand']) && isset($_POST['state']) && isset($_POST['license_type'])) {
            $immatriculation = $_POST['immatriculation'];
            $type = $_POST['type'];
            $brand = $_POST['brand'];
            $state = $_POST['state'];
            $license_type = $_POST['license_type'];

            // Insérer les données du véhicule dans la base de données
            $sql = $link->prepare("INSERT INTO vehicle (immatriculation, type, brand, state, license_type) VALUES (?, ?, ?, ?, ?)");
            $sql->bind_param("sssss", $immatriculation, $type, $brand, $state, $license_type);
            $sql->execute();
            $sql->close();

            // Rediriger vers une page de confirmation ou autre
            header("Location: addvehicle.php");
            exit();
        } else {
            echo "Tous les champs doivent être remplis.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
</head>
<body>
    <h2>Add Vehicle</h2>
    <form action="addvehicle.php" method="post">
        <label for="immatriculation">Immatriculation:</label><br>
        <input type="text" id="immatriculation" name="immatriculation" required><br><br>
        
        <label for="type">Type:</label><br>
        <select id="type" name="type" required>
            <option value="Car">Car</option>
            <option value="Truck">Truck</option>
            <option value="Van">Van</option>
            <option value="Moto">Moto</option>
            <!-- Ajoutez d'autres options selon vos besoins -->
        </select><br><br>
        <label for="license_type">license need:</label><br>
        <select id="license_type" name="license_type" required>
        
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        </select><br><br>
        <label for="brand">Brand:</label><br>
        <input type="text" id="brand" name="brand" required><br><br>
        
        <label for="state">State:</label><br>
        <select id="state" name="state" required>
        
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="Add Vehicle">
    </form>
</body>
</html>
