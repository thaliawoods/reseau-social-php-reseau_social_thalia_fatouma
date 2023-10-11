<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="Jeremie Patot">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social" />
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href=<?php echo "wall.php?user_id=".$_SESSION['connected_id']?>>Mur</a>
            <a href=<?php echo "feed.php?user_id=".$_SESSION['connected_id']?>>Flux</a>
            <a href=<?php echo "tags.php?tag_id=".$_SESSION['connected_id']?>>Mots-clés</a>
            <!-- <a href="follow.php?followedid=<?php echo $userId;?>">Suivre cette personne</a> -->
        </nav>
        <nav id="user">
            <a href="#">Profil</a>
            <ul>
                <li><a href=<?php echo "settings.php?user_id=".$_SESSION['connected_id']?>>Paramètres</a></li>
                <li><a href=<?php echo "followers.php?user_id=".$_SESSION['connected_id']?>>Mes suiveurs</a></li>
                <li><a href=<?php echo "subscriptions.php?user_id=".$_SESSION['connected_id']?>>Mes abonnements</a></li>
                <li><a href=<?php echo "deconnexion.php?user_id=".$_SESSION['connected_id']?>>Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <div id="wrapper">

        <?php

        // Etape 1: Le mur concerne un utilisateur en particulier
        // La première étape est donc de trouver quel est l'id de l'utilisateur
        // Celui-ci est indiqué en paramètre GET de la page sous la forme user_id=...
        $userId = intval($_GET['user_id']);

        ?>

        <?php

        // Etape 2: se connecter à la base de données
        include "./connexion.php";

        ?>

        <aside>

            <?php

            // Etape 3: récupérer le nom de l'utilisateur
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();

            //@todo: afficher le résultat de la ligne ci-dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous

            ?>

            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les messages de l'utilisatrice : <?php echo $user['alias'] ?>
                    (n° <?php echo $userId ?>)
                </p>
                <?php if (intval($_GET['user_id']) == $_SESSION['connected_id']) {
                    echo "<a href='newpost.php'><button id='newpost'>
                        Nouveau post !
                    </button></a>";
                // } else {
                //     echo "<a href='subscriptions.php'><button id='newpost'>
                //                 S'abonner
                //             </button></a>";
                } ?>
                <br /><br />
                <?php if (isset($_SESSION['connected_id']) && $_SESSION['connected_id'] != $userId) {
                    $isfollowingornot = $mysqli->prepare('SELECT * FROM followers WHERE followed_user_id = ? AND following_user_id = ?');
                    $isfollowingornot->bind_param('ii', $getfollowedid, $_SESSION['connected_id']);
                    $isfollowingornot->execute();
                    $isfollowingornot->close(); // Libérer les résultats de la requête préparée
                // ?>
                <!-- //     <a href="follow.php?followedid=<?php echo $userId; ?>">Suivre cette personne</a> -->
                <?php } ?>
            </section>
            <!-- <form action="subscribe.php" method="post">
    <input type="hidden" name="target_user_id" value="<?php echo $userId; ?>">
    <input type="submit" value="S'abonner">
</form> -->
            <?php
            // Vérifiez si l'utilisateur est connecté
            if (isset($_SESSION['connected_id'])) {
                $connectedUserId = $_SESSION['connected_id'];

                // Vérifiez si l'ID de l'utilisateur cible est défini dans l'URL
                if (isset($_GET['user_id'])) {
                    $targetUserId = intval($_GET['user_id']);

                    // Vérifiez si l'utilisateur est sur son propre mur
                    $isOwnWall = ($connectedUserId === $targetUserId);

                    // Si l'utilisateur n'est pas sur son propre mur, affichez le bouton d'abonnement ou de désabonnement
                    if (!$isOwnWall) {
                        // Vérifiez si l'utilisateur est déjà abonné
                        $checkSubscriptionQuery = "
                            SELECT * 
                            FROM followers 
                            WHERE followed_user_id = $targetUserId 
                            AND following_user_id = $connectedUserId
                        ";
                        $checkSubscriptionResult = $mysqli->query($checkSubscriptionQuery);

                        $isSubscribed = ($checkSubscriptionResult && $checkSubscriptionResult->num_rows > 0);

                        // Affichez le bouton d'abonnement ou de désabonnement en fonction de l'état actuel de l'abonnement
                        if ($isSubscribed) {
                            echo '<form action="unsubscribe.php" method="post">';
                            echo '<input type="hidden" name="target_user_id" value="' . $targetUserId . '">';
                            echo '<input type="submit" value="Se désabonner">';
                            echo '</form>';
                        } else {
                            echo '<form action="subscribe.php" method="post">';
                            echo '<input type="hidden" name="target_user_id" value="' . $targetUserId . '">';
                            echo '<input type="submit" value="S\'abonner">';
                            echo '</form>';
                        }
                    }

                    // Maintenant, vous pouvez afficher les messages de l'utilisateur cible, que l'utilisateur soit abonné ou non.
                    // ...
                } else {
                    echo "ID de l'utilisateur cible non spécifié dans l'URL.";
                }
            } else {
                echo "Vous devez être connecté pour effectuer cette action.";
            }
            ?>

            <?php
            // Fermez la première requête ici
            $lesInformations->close();
            ?>

        </aside>

        <main>

            <?php

            // Etape 3: récupérer tous les messages de l'utilisatrice
            $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    users.id as author_id,
                    posts.id as post_id,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

            $lesInformations = $mysqli->query($laQuestionEnSql);

            if (!$lesInformations) {
                echo ("Échec de la requête : " . $mysqli->error);
            }

            ?>

            <?php

            // Etape 4: Parcourir les messages et remplir correctement le HTML avec les bonnes valeurs PHP
            while ($post = $lesInformations->fetch_assoc()) {
                include "post.php";
            }

            // Fermez la deuxième requête ici
            $lesInformations->close();
            ?>

        </main>
    </div>
</body>

</html>
