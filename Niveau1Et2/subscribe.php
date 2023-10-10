<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "Vous devez être connecté pour vous abonner.";
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

// Vérifiez si l'utilisateur est déjà abonné à l'utilisateur cible en utilisant une requête préparée
$checkSubscriptionQuery = "SELECT * FROM followers WHERE followed_user_id = ? AND following_user_id = ?";
$checkSubscriptionResult = $mysqli->prepare($checkSubscriptionQuery);
$checkSubscriptionResult->bind_param('ii', $targetUserId, $connectedUserId);
$checkSubscriptionResult->execute();
$checkSubscriptionResult->store_result();

if ($checkSubscriptionResult->num_rows > 0) {
    echo "Vous êtes déjà abonné à cet utilisateur.";
} else {
    // Effectuez l'abonnement en utilisant une requête préparée
    $subscribeQuery = "INSERT INTO followers (followed_user_id, following_user_id) VALUES (?, ?)";
    $insertSubscription = $mysqli->prepare($subscribeQuery);
    $insertSubscription->bind_param('ii', $targetUserId, $connectedUserId);

    if ($insertSubscription->execute()) {
        echo "Vous vous êtes abonné avec succès à cet utilisateur.";
    } else {
        echo "Erreur lors de l'abonnement : " . $mysqli->error;
    }
    $insertSubscription->close();
}

// Fermez la connexion à la base de données si nécessaire
$mysqli->close();
?>
