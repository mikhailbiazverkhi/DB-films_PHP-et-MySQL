<?php

        session_start();
        define('ABSPATH', true);


        if(!isset($_SESSION['user'])){
          header('Location: /login.php');
        }

        include 'header.php';
        include 'functions.php';


        $film_id = $_GET['id'];

        $sql = "SELECT f.titre, f.description, g.nom AS genre, f.année_sortie, f.quantité
                FROM film f
                JOIN genre g ON f.genre_id = g.id 
                WHERE f.id = $film_id";

        $films = query($sql);
        $film = $films[0];

        $sql1 = "SELECT r.nom, r.prénom
                FROM Réalisateur r 
                JOIN Film_Réalisateur fr ON r.id = fr.réalisateur_id
                WHERE fr.film_id = $film_id";

        $réalisateurs = query($sql1);

        $sql2 = "SELECT a.nom, a.prénom
                FROM Acteur a 
                JOIN Film_Acteur fa ON a.id = fa.acteur_id
                WHERE fa.film_id = $film_id";

        $acteurs = query($sql2);

        $sql3 = "SELECT count(*)
                FROM Copie_de_film 
                WHERE film_id = $film_id";

        $fimls_en_main = query($sql3);

?>

<main>
        <div class="container mt-5 d-flex align-items-center flex-column">

                <div class="card">
                  <div class="card-header">
                    <h3> Titre: <?=$film['titre']?> </h3>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item fs-4">Description: <span><?=$film['description']?></span></li>
                    <li class="list-group-item fs-4">Genre: <span><b><?=$film['genre']?></b></span></li>
                    <li class="list-group-item fs-4">Année de sortie: <span><b><?=$film['année_sortie']?></b></span></li>
                    <li class="list-group-item fs-4">Nombre d'exemplaires disponibles: 
                        <span><b><?php 
                                if($film['quantité'] - $fimls_en_main[0]['count(*)'] > 0){
                                        echo $film['quantité'] - $fimls_en_main[0]['count(*)'] ." de " .$film['quantité'];
                                } else {
                                        echo "Le film n'est pas disponible !!!";
                                }
                                ?>
                        </b></span></li>
                    <li class="list-group-item fs-4">Réalisateurs: <span><b><?=chaineNomsPersonne($réalisateurs)?></b></span></li>
                    <li class="list-group-item fs-4">Acteurs: <span><b> <?=chaineNomsPersonne($acteurs)?></b></span></li>
                  </ul>
                </div>
        
                <div class="col mt-5">
                    <a class="btn btn-primary mx-3" href="delete_film.php?id=<?=$film_id ?>">Supprimer</a>
                    <a class="btn btn-primary mx-3" href="modifier_film.php?id=<?=$film_id ?>">Modifier</a>
                    <a class="btn btn-secondary mx-3" href="/index.php">Retour à l'accueil</a>
      	        </div>
        

        </div>
</main>

<?php include 'footer.php' ?>