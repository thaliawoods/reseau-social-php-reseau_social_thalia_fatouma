<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>ReSoC - Les messages par mot-clé</title>
    <meta name="author" content="Jeremie Patot">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<header>
    <img src="resoc.jpg" alt="Logo de notre réseau social"/>
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <?php if (isset($_SESSION['connected_id'])) : ?>
            <a href=<?php echo "wall.php?user_id=" . $_SESSION['connected_id'] ?>>Mur</a>
            <a href=<?php echo "feed.php?user_id=" . $_SESSION['connected_id'] ?>>Flux</a>
            <a href=<?php echo "tags.php?tag_id=" . $_SESSION['connected_id'] ?>>Mots-clés</a>
        <?php endif; ?>
    </nav>
    <nav id="user">
        <a href="#">Profil</a>
        <ul>
            <?php if (isset($_SESSION['connected_id'])) : ?>
                <li><a href=<?php echo "settings.php?user_id=" . $_SESSION['connected_id'] ?>>Paramètres</a></li>
                <li><a href=<?php echo "followers.php?user_id=" . $_SESSION['connected_id'] ?>>Mes suiveurs</a></li>
                <li><a href=<?php echo "subscriptions.php?user_id=" . $_SESSION['connected_id'] ?>>Mes abonnements</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<div id="wrapper">
    <?php
    // Etape 1: Le mur concerne un mot-clé en particulier
    $tagId = isset($_GET['tag_id']) ? intval($_GET['tag_id']) : 0;
    ?>
    <?php
    // Etape 2: se connecter à la base de donnée
    include "./connexion.php";
    ?>
    <aside>
        <?php
        // Etape 3: récupérer le nom du mot-clé
        $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        $tag = $lesInformations->fetch_assoc();
        ?>
        <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez les derniers messages comportant
                le mot-clé <?php echo isset($tag['label']) ? $tag['label'] : '' ?>
                (n° <?php echo $tagId ?>)
            </p>
        </section>
    </aside>
    <main>
        <?php
        // Etape 3: récupérer tous les messages avec un mot clé donné
        $laQuestionEnSql = "
            SELECT posts.content,
            posts.created,
            users.alias as author_name,  users.id as author_id,
            count(likes.id) as like_number,  
            GROUP_CONCAT(DISTINCT tags.label) AS taglist 
            FROM posts_tags as filter 
            JOIN posts ON posts.id=filter.post_id
            JOIN users ON users.id=posts.user_id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE filter.tag_id = '$tagId' 
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";

        $lesInformations = $mysqli->query($laQuestionEnSql);
        /**
         * Etape 4: Parcourir les messages et remplir correctement le HTML avec les bonnes valeurs php
         */

        while ($post = $lesInformations->fetch_assoc()) {
            // Inclure le fichier post.php pour afficher le message
            include "post.php";
        }
        ?>
    </main>
</div>
</body>
</html>
