<article>

<?php 

//Date de création du post 

?>

    <h3>

        <time><?php echo $post['created'] ?></time>

    </h3>

<?php 

//Nom du créateur du post 

?>
    
    <address>par <?php echo $post['author_name'] ?></address>

<?php 

//Contenu du post 

?>
    
    <div>
        <p>
            <?php echo $post['content']?>
        </p>
    </div>
    <footer>
        <small>♥ <?php 
        
        //Nombre de like sur le post

         echo $post['like_number'] ?>
        </small>
        <?php

        //Séparer les tags puis les mettre dans un tableau

        $str = $post['taglist'];
        $delimiter = ",";
        $parts = explode($delimiter, $str);

        //Pour chaque tag il y a un # devant, ils sont séparés d'un espace et ils ont un lien cliquable
        
        for ($i=0; $i<count($parts); $i++) {
        echo "<a href='tags.php?tag_id=$parts[$i]'>#" . $parts[$i] . ' ' . '</a>';
        }
        
        ?>
    </footer>
</article>








