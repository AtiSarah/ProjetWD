<?php
session_start();
include("../dbp.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['profile'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $profile = $_POST['profile'];

            // Vérifier si l'e-mail existe déjà dans la base de données
            $check_email_query = "SELECT * FROM user WHERE email = ?";
            $check_email_stmt = $link->prepare($check_email_query);
            $check_email_stmt->bind_param("s", $email);
            $check_email_stmt->execute();
            $result = $check_email_stmt->get_result();

            if ($result->num_rows > 0) {
                // L'e-mail existe déjà, afficher un message d'erreur ou effectuer une autre action
                echo "Cet e-mail existe déjà dans la base de données.";
            } else {
                // L'e-mail n'existe pas encore, procéder à l'insertion

                // Hasher le mot de passe 
                $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insérer les données de l'utilisateur
                $sql = $link->prepare("INSERT INTO user (email, pass, profile) VALUES (?, ?, ?)");
                $sql->bind_param("sss", $email, $pwd_hash, $profile);
                $sql->execute();

                // Obtenir l'ID de l'utilisateur inséré
                $user_id = $link->insert_id;

                // Stocker l'ID de l'utilisateur en session pour une utilisation future
                $_SESSION['user_id'] = $user_id;

                // Fermer l'instruction
                $sql->close();

                // Rediriger en fonction du profil
                if ($profile == 0) {
                    header("Location: ../manager/manager.php");
                    exit();
                } elseif ($profile == 1) {
                    header("Location: ../driver/driver.php");
                    exit();
                } elseif ($profile == 3) {
                    header("Location: ../admin.php");
                    exit();
                }
            }
            // Fermer l'instruction de vérification de l'e-mail
            $check_email_stmt->close();
        }
    }
}
?>

    <div id="inscreption-form">
    <h2>CREATE USER :</h2>
    <form action="user.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="password" required><br><br>
        
        <label for="profile">Profile:</label><br>
        <select id="profile" name="profile" required>
        <option value="0">Manager</option>
        <option value="1">Driver</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="CREATE">
    </form>
    </div>
    <a href="../admin.php"><button>Cancel</button></a>
</body>
</html>