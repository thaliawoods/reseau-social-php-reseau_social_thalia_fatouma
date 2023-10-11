<?php
session_start();
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
if (isset($_GET['id'])) {
    // Obtenez la valeur de 'id' depuis $_GET
    $getid = (int) $_GET['id'];
    $userId = $_SESSION['connected_id'];
    // Vérifiez si l'utilisateur a déjà liké ce post
    $checkLikeQuery = "SELECT * FROM likes WHERE post_id = $getid AND user_id = $userId";
    $result = $mysqli->query($checkLikeQuery);
    if ($result->num_rows == 0) {
        // L'utilisateur n'a pas encore liké ce post, insérez le like
        $ins = "INSERT INTO likes (post_id, user_id) VALUES ($getid, $userId)";
        $mysqli->query($ins);
    } else {
        // L'utilisateur a déjà liké ce post, supprimez le like
        $del = "DELETE FROM likes WHERE post_id = $getid AND user_id = $userId";
        $mysqli->query($del);
    }
    // Redirigez l'utilisateur vers la page précédente
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo "L'ID n'est pas défini dans la requête GET.";
    // Gérez cette situation d'erreur comme vous le souhaitez
}
?>









