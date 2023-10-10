<?php
session_start();

include "./connexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $userId = $_SESSION['connected_id'];

        // Assurez-vous de sécuriser les données avant de les insérer dans la base de données pour éviter les injections SQL
        $content = mysqli_real_escape_string($mysqli, $content);

        // Insérer le nouveau post dans la base de données
        $insertQuery = "INSERT INTO posts (user_id, content) VALUES ('$userId', '$content')";
        $result = $mysqli->query($insertQuery);

        if ($result) {
            // Redirigez l'utilisateur vers une page de confirmation ou la page de mur, par exemple
            header("Location: wall.php?user_id=$userId");
            exit();
        } else {
            // Gestion des erreurs d'insertion
            echo "Erreur lors de l'insertion du post : " . $mysqli->error;
        }
    }
}
?>
