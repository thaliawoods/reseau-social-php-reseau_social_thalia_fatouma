<?php session_start();

// Récupérer les ID des utilisateurs auxquels l'utilisateur est abonné
$subscriptionsQuery = "
    SELECT users.* 
    FROM followers 
    LEFT JOIN users ON users.id = followers.followed_user_id 
    WHERE followers.following_user_id = $connectedUserId
    GROUP BY users.id
";
$subscriptionsResult = $mysqli->query($subscriptionsQuery);

if ($subscriptionsResult) {
    while ($row = $subscriptionsResult->fetch_assoc()) {
        $subscribedUserId = $row['id'];
        
        // Utilisez $subscribedUserId pour récupérer les messages de l'utilisateur abonné
        // Affichez les messages sur le mur de l'utilisateur
        // ...
    }
} else {
    // Gérer l'erreur de récupération des abonnements
    echo "Erreur lors de la récupération des abonnements.";
}
?>