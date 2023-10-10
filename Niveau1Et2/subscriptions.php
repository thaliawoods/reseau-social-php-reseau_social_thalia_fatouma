<?php
session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
    <meta name="author" content="Jeremie Patot">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<header>
    <img src="resoc.jpg" alt="Logo de notre réseau social"/>
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <a href=<?php echo "wall.php?user_id=" . $_SESSION['connected_id'] ?>>Mur</a>
        <a href=<?php echo "feed.php?user_id=" . $_SESSION['connected_id'] ?>>Flux</a>
        <a href=<?php echo "tags.php?tag_id=" . $_SESSION['connected_id'] ?>>Mots-clés</a>
    </nav>
    <nav id="user">
        <a href="#">Profil</a>
        <ul>
            <li><a href=<?php echo "settings.php?user_id=" . $_SESSION['connected_id'] ?>>Paramètres</a></li>
            <li><a href=<?php echo "followers.php?user_id=" . $_SESSION['connected_id'] ?>>Mes suiveurs</a></li>
            <li><a href=<?php echo "subscriptions.php?user_id=" . $_SESSION['connected_id'] ?>>Mes abonnements</a></li>
        </ul>
    </nav>
</header>

<div id="wrapper">
    <aside>
        <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page, vous trouverez la liste des personnes que l'utilisatrice suit les messages.</p>
        </section>
        <form action="subscribe.php" method="post">
    <input type="hidden" name="followed_user_id" value="<?php echo $userId; ?>">
    <input type="submit" value="S'abonner">
</form>

    </aside>

    <main class='contacts'>
        <?php
        // Vérifier si user_id est défini dans $_GET
        if (isset($_GET['user_id'])) {
            // Récupérer l'id de l'utilisateur
            $userId = intval($_GET['user_id']);

            // Se connecter à la base de données
            include "./connexion.php";

            // Récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                SELECT users.* 
                FROM followers 
                LEFT JOIN users ON users.id=followers.followed_user_id 
                WHERE followers.following_user_id='$userId'
                GROUP BY users.id
                ";

            $lesInformations = $mysqli->query($laQuestionEnSql);

            // Boucle pour afficher les abonnements
            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <h3> <a href=<?php echo "wall.php?user_id=" . $post['id'] ?>>Mur</a> <?php echo $post['alias'] ?></h3>
                    <p>Id:<?php echo $post['id'] ?></p>
                </article>
                <?php
            }
        } else {
            echo "L'ID de l'utilisateur n'est pas défini dans l'URL.";
        }
        ?>
    </main>
</div>
</body>
</html>
