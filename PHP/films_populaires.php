<?php
define('ABSPATH', true);

include 'header.php';
include 'functions.php';

?>

    <main>
    <div class="container mt-5">
        <h2>
            Films populaires:
        </h2>
        <div class="row mt-5">
            <?php               

               $sql = "SELECT f.id, f.titre, f.année_sortie, f.quantité, g.nom as genre  FROM Film f
                        JOIN Genre g ON f.genre_id = g.id
                        JOIN Copie_de_film cf ON cf.film_id = f.id
                        GROUP BY f.titre
                        HAVING f.quantité - count(f.titre) <= 5";
               
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
        <div class="col mt-5 d-flex justify-content-center">
            <a class="btn btn-secondary mx-3" href="/index.php">Retour à l'accueil</a>
      	</div>
    </div>
</main>

<?php include 'footer.php' ?>


