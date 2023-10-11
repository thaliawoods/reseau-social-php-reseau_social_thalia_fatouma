<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Nouveau Post</title>
    <meta name="author" content="Jeremie Patot">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social" />
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
                <li><a href=<?php echo "deconnexion.php?user_id=".$_SESSION['connected_id']?>>Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Créer un nouveau post</h3>
                <form action="process_newpost.php" method="post">
                    <textarea name="content" placeholder="Entrez votre message ici" rows="4" cols="50" required></textarea>
                    <br />
                    <input type="submit" value="Poster">
                </form>
            </section>
        </aside>
    </div>
</body>

</html>
