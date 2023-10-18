<?php
	session_start();
	define('ABSPATH', true);

	if(!isset($_SESSION['user'])){
		header('Location: /login.php');
	}

	include 'header.php';
	include 'functions.php';


	if(isset($_GET['id'])){

		$film_id = $_GET['id'];
		$_SESSION['id'] = $_GET['id'];

	$sql = "SELECT f.titre, f.description, f.genre_id, g.nom AS genre, f.année_sortie, f.quantité
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


<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <form method="get">
		        	<div class="form-group py-3">
		        		<label for="titre">Titre</label>
		        	    <input type="text" class="form-control" name="titre" id="titre" value="<?=$film['titre']?>" required>
		        	</div>
		        	<div class="form-group py-3">
		        	    <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" cols="50" required><?=$film['description']?></textarea>  
                    </div>

                    <div class="form-group py-3">
		        	    <label for="genre">Genre</label>
		        	    <select class="form-control" id="genre" name="genre_id" required>
		        			<?php
		        				$genres = query("SELECT * FROM Genre");
		        	    	        foreach($genres as $genre){
										if($genre['id'] === $film['genre_id']) {
		        				?>
								<option value="<?=$genre['id']?>" selected><?=$genre['nom']?></option>
								<?php 
									} else {	
								?>
		        	  			<option value="<?=$genre['id']?>"><?=$genre['nom']?></option>
		        			<?php 
							}
									}
		        	    	?>
		        	    </select>
		        	</div>
					<div class="form-group py-3">
		        	    <label for="année_sortie">Année de sortie</label>
		        	    <input type="text" class="form-control" name="année_sortie" id="année_sortie" value="<?=$film['année_sortie']?>" required>
		        	</div>

                    <div class="form-group py-3">
		        	    <label for="quantité">Nombre d'exemplaires</label>
		        	    <input type="text" class="form-control" name="quantité" id="quantité" value="<?=$film['quantité']?>" required>
		        	</div>

                    <div class="form-group py-3">
		        	    <label for="réalisateurs">Réalisateurs</label>
		        	    <input type="text" class="form-control" name="réalisateurs" id="réalisateurs" value="<?=chaineNomsPersonne($réalisateurs)?>" required>
		        	</div>

                    <div class="form-group py-3">
		        	    <label for="acteurs">Acteurs</label>
		        	    <input type="text" class="form-control" name="acteurs" id="acteurs" value="<?=chaineNomsPersonne($acteurs)?>" required>
		        	</div>
     	
                <div class="col mt-5 mb-3 d-flex justify-content-around">
		        	<button name = "btnOk" class="btn btn-primary"> OK </button>
					<a class="btn btn-secondary" href="details_film.php?id=<?=$film_id ?>">Cancel</a>
		        </div>
            </form>
        </div>
    </div>
</div>


<?php
}
	// Si le titre et l'auteur ne sont pas nuls, le formulaire a été envoyé
	if(isset($_GET['btnOk'])){

		$film_id = $_SESSION['id'];
		$titre = $_GET['titre'];
		$description = $_GET['description'];
		$genreId = $_GET['genre_id'];
		$année_sortie = $_GET['année_sortie'];
		$quantité = $_GET['quantité'];
	    $réalisateurs = $_GET['réalisateurs'];
	    $acteurs = $_GET['acteurs'];

		$sql = "UPDATE Film SET titre = '$titre', description = '$description', genre_id = '$genreId', année_sortie = '$année_sortie', quantité='$quantité' WHERE id='$film_id'";
		$conn->query($sql);

	///// Lana Wachowski, Lilly Wachowski, 'nom1' 'prénom1', 'nom2' 'prénom2', 'nom3' 'prénom3'
	///// Entre nom et prénom il doit être ESPACE. Et entre les réalisateurs la virgule sauf la fin de chaine de caractères
		$tab_réalisateurs = faireTableau($réalisateurs);

		$sql_réalisateur = "SELECT r.id, r.nom, r.prénom
		FROM Réalisateur r 
		JOIN Film_Réalisateur fr ON r.id = fr.réalisateur_id
		WHERE fr.film_id = $film_id";

		modifierChamp($film_id, $tab_réalisateurs, $sql_réalisateur, 'Réalisateur');

	///// Keanu Reeves, Laurence Fishburne, 'nom1' 'prénom1', 'nom2' 'prénom2', 'nom3' 'prénom3'
	///// Entre nom et prénom il doit être ESPACE. Et entre les acteurs la virgule sauf la fin de chaine de caractères
		$tab_acteurs = faireTableau($acteurs);

		$sql_acteur = "SELECT a.id, a.nom, a.prénom
		FROM Acteur a 
		JOIN Film_Acteur fa ON a.id = fa.acteur_id
		WHERE fa.film_id = $film_id";

		modifierChamp($film_id, $tab_acteurs, $sql_acteur, 'Acteur');

		header('Location: /details_film.php?id='.$film_id);
	}

include 'footer.php' ?>