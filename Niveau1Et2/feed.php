<?php
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Flux</title>         
        <meta name="author" content="Jeremie Patot">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/>
            <nav id="menu">
            <a href="news.php">Actualités</a>
                <a href=<?php echo "wall.php?user_id=".$_SESSION['connected_id']?>>Mur</a>
                <a href=<?php echo "feed.php?user_id=".$_SESSION['connected_id']?>>Flux</a>
                <a href=<?php echo "tags.php?tag_id=".$_SESSION['connected_id']?>>Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href=<?php echo "settings.php?user_id=".$_SESSION['connected_id']?>>Paramètres</a></li>
                    <li><a href=<?php echo "followers.php?user_id=".$_SESSION['connected_id']?>>Mes suiveurs</a></li>
                    <li><a href=<?php echo "subscriptions.php?user_id=".$_SESSION['connected_id']?>>Mes abonnements</a></li>
                </ul>
            </nav>
        </header>

        <div id="wrapper">

            <?php

            /**
             * Cette page est TRES similaire à wall.php. 
             * Vous avez sensiblement à y faire la meme chose.
             * Il y a un seul point qui change c'est la requete sql.
             */


            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             */

            $userId = intval($_GET['user_id']);
            ?>
            <?php


            /**
             * Etape 2: se connecter à la base de donnée
             */

            include "./connexion.php";
            ?>

            <aside>

                <?php


                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */

                $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();

                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous

                ?>

                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message des utilisatrices
                        auxquel est abonnée l'utilisatrice <?php echo $user['alias']?>
                        (n° <?php echo $user['id'] ?>)
                    </p>

                </section>
            </aside>
            <main>

                <?php


                /**
                 * Etape 3: récupérer tous les messages des abonnements
                 */

                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    users.id as author_id,
                    posts.id as post_id,
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

                $lesInformations = $mysqli->query($laQuestionEnSql);

                if ( ! $lesInformations)

                {
                    echo("Échec de la requete : " . $mysqli->error);
                }


                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 * A vous de retrouver comment faire la boucle while de parcours...
                 */

                ?>     

                <?php

                $lesInformations = $mysqli->query($laQuestionEnSql);

                while ($post = $lesInformations->fetch_assoc())
                
                {
                    
                    include "post.php";

        } ?>

            </main>
        </div>
    </body>
</html>
