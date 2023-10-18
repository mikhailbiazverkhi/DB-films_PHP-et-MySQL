<?php
    session_start();
    define('ABSPATH', true);

    if(!isset($_SESSION['user'])){
        header('Location: /login.php');
    }

    include './database.php';
    
    $film_id = $_GET['id'];
    
    $has_error = false;
    
    // on doit supprimer les films correspondant dans la table Copie_de_film avant de supprimer les livres
    if ($conn->query("DELETE FROM Copie_de_film where film_id = $film_id") === FALSE) {
        $has_error = true;
    }
    
    if ($conn->query("DELETE FROM Film_Réalisateur where film_id = $film_id") === FALSE) {
        $has_error = true;
    }
    
    if ($conn->query("DELETE FROM Film_Acteur where film_id = $film_id") === FALSE) {
        $has_error = true;
    }
    
    if ($conn->query("DELETE FROM Film where id = $film_id") === FALSE) {
        $has_error = true;
    }
    
    if ($has_error) {
        
        echo '<p class="d-flex justify-content-center" style="color: red;">Une erreur de supprimation!!!</p>';
    
        die;
    }
    
    header('Location: /');

?>