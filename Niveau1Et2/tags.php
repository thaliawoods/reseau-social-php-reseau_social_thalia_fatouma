<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Les message par mot-clé</title> 
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
             * Cette page est similaire à wall.php ou feed.php 
             * mais elle porte sur les mots-clés (tags)
             */


            /**
             * Etape 1: Le mur concerne un mot-clé en particulier
             */

            $tagId = intval($_GET['tag_id']);
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
                 * Etape 3: récupérer le nom du mot-clé
                 */

                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();

                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
                
                ?>

                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le mot-clé <?php echo $tag['label']?>
                        (n° <?php echo $tagId ?>)
                    </p>

                </section>
            </aside>
            <main>

                <?php


                /**
                 * Etape 3: récupérer tous les messages avec un mot clé donné
                 */

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
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */

                while ($post = $lesInformations->fetch_assoc())
                
                {       

                include "post.php"

                ?>
                    
                <?php } ?>

            </main>
        </div>
    </body>
</html>