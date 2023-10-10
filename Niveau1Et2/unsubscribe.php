<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "Vous devez être connecté pour vous désabonner.";
    exit;
}

// Vérifiez si l'ID de l'utilisateur cible est spécifié dans le formulaire
if (!isset($_POST['target_user_id'])) {
    echo "ID de l'utilisateur cible non spécifié.";
    exit;
}

// Obtenez l'ID de l'utilisateur connecté et l'ID de l'utilisateur cible
$connectedUserId = $_SESSION['connected_id'];
$targetUserId = intval($_POST['target_user_id']);

// Connectez-vous à votre base de données (inclus dans le fichier connexion.php)
include "./connexion.php";

// Vérifiez si l'utilisateur est déjà abonné à l'utilisateur cible
$checkSubscriptionQuery = "
    SELECT * 
    FROM followers 
    WHERE followed_user_id = $targetUserId 
    AND following_user_id = $connectedUserId
";
$checkSubscriptionResult = $mysqli->query($checkSubscriptionQuery);

if ($checkSubscriptionResult && $checkSubscriptionResult->num_rows > 0) {
    // Effectuez le désabonnement
    $unsubscribeQuery = "
        DELETE FROM followers 
        WHERE followed_user_id = $targetUserId 
        AND following_user_id = $connectedUserId
    ";

    if ($mysqli->query($unsubscribeQuery)) {
        echo "Vous vous êtes désabonné avec succès de cet utilisateur.";
    } else {
        echo "Erreur lors du désabonnement : " . $mysqli->error;
    }
} else {
    echo "Vous n'êtes pas abonné à cet utilisateur.";
}

// Fermez la connexion à la base de données si nécessaire
$mysqli->close();
?>
