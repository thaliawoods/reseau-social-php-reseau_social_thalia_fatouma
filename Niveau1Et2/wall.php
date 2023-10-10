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
        </nav>
    </header>

    <div id="wrapper">

        <?php


        /**
         * Etape 1: Le mur concerne un utilisateur en particulier
         * La première étape est donc de trouver quel est l'id de l'utilisateur
         * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
         * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
         * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
         */

        $userId =intval($_GET['user_id']);

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


            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();

            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
            
            ?>

            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>
                    <?php  if (intval($_GET['user_id'])==$_SESSION['connected_id']){ 
                    echo "<a href='newpost.php'><button id='newpost'>
                        Nouveau post !
                    </button></a>";}
                            else {
                                echo "<a href='subscriptions.php'><button id='newpost'>
                                S'abonner
                            </button></a>";
                            } ?>
                            <br /><br />
                            <?php if(isset($_SESSION['connected_id']) AND $_SESSION['connected_id'] != $userId ){
                                $isfollowingornot = $mysqli->prepare('SELECT * FROM followers WHERE followed_user_id = ? AND following_user_id = ?');
                                $isfollowingornot->bind_param('ii', $getfollowedid, $_SESSION['connected_id']);
                                $isfollowingornot->execute();
                                ?>
                            <a href="follow.php?followedid=<?php echo $userId;?>">Suivre cette personne</a>
                            <?php } ?>
                </section>
                <form action="subscribe.php" method="post">
    <input type="hidden" name="author_id" value="<?php echo $userId; ?>">
    <input type="submit" value="S'abonner">
</form>
  <!-- ... Affichage des détails de l'utilisateur ... -->

  <?php
    // Affiche le formulaire d'abonnement si l'utilisateur n'est pas lui-même l'auteur du mur
    if ($_SESSION['connected_id'] != $userId) {
        echo '<form action="subscriptions.php" method="post">';
        echo '<input type="hidden" name="author_id" value="' . $userId . '">';
        echo '<input type="submit" value="S\'abonner">';
        echo '</form>';
    }
    ?>

        </aside>


            <main>
            

            <?php

            /**
             * Etape 3: récupérer tous les messages de l'utilisatrice
             */

            $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    users.id as author_id,
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
                echo ("Échec de la requete : " . $mysqli->error);
            }


            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */

            while ($post = $lesInformations->fetch_assoc()) {

                include "post.php";

            } ?>

        </main>
    </div>
</body>

</html>