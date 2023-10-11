<?php
session_start(); // Démarrez la session (assurez-vous de l'appeler au début de chaque script qui utilise des sessions)

// Effectuez toutes les opérations nécessaires liées à la session

session_destroy(); // Détruisez la session actuelle

// Vous pouvez également vider les données de session si nécessaire
$_SESSION = array();

// Redirigez l'utilisateur vers une page de déconnexion ou ailleurs
header("Location: login.php");
?>