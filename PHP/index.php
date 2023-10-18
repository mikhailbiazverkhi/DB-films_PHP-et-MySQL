<?php

session_start();

    define('ABSPATH', true);

    include 'header.php';
    include 'functions.php';

?>

<!-- <main style="min-height: 1200px;"> -->
<main>
    <div class="container mt-5">

        <?php if(isset($_GET['acteur'])) :?>
            <h2>Recherche par acteur: <?=$_GET['acteur']?></h2>
        <?php elseif(isset($_GET['genre_id'])) :?>
            <h2>Recherche par genre: 
            <?php
                $sql = "SELECT nom 
                FROM Genre
                WHERE id = " . $_GET['genre_id'];
        
                $genres = query($sql);
                $genre = $genres[0];

                echo $genre['nom'];
            ?>

            </h2>
        <?php else : ?>
            <h2>Catalogue complet:</h2>
        <?php endif ?>

        <div class="row mt-5">
            <?php
                

                $sqlDefault = "SELECT f.id, f.titre, f.année_sortie, g.nom as genre FROM Film f
                    JOIN Genre g ON f.genre_id = g.id";

                if(isset($_GET['genre_id'])){
                    $sql = $sqlDefault . " where genre_id=" . $_GET['genre_id'];
                }
                elseif(isset($_GET['acteur']) && !empty($_GET['acteur'])){

                    $tableauIdActeurs = retourneIdActeurs($_GET['acteur']);
                    if(count($tableauIdActeurs) > 0 ){
                        $sql = $sqlDefault . 
                                            " JOIN Film_Acteur af ON af.film_id = f.id 
                                            WHERE acteur_id IN(".implode(',', $tableauIdActeurs).")";
                    } else{
                        $sql = $sqlDefault;
                    }

                }     
                else{
                    $sql = $sqlDefault;
                }    
                
                $films = query($sql);

                foreach ($films as $film) { 
            ?>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border border-danger w-100 my-2">
                    <div class="card-body">
                        <h5 class="card-title">
                            Titre: <?= $film['titre'] ?>
                        </h5>
                        <p class="card-text">
                            Genre: <?= $film['genre'] ?> <br>
                            Année de sortie: <?= $film['année_sortie'] ?>
                        </p>
                        <a href="details_film.php?id=<?= $film['id'] ?>" class="btn btn-primary">
                        Voir plus</a>
                    </div>
                </div>
            </div>

            <?php  }
            ?>
        </div>
    </div>
</main>

<?php include 'footer.php' ?>