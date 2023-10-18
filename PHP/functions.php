<?php

//fonction pour définir s'il y a un dublicat de Login dans la Base de Données 
function estLoginUnique($login){

    $sql = "SELECT count(*) FROM Utilisateur WHERE login = '$login'";
    $utilisateurs = query($sql);

    if($utilisateurs[0]['count(*)'] == 0)
        return true;
    return false;

}

//// la fonction met la virgule entre les noms des personnes
function chaineNomsPersonne($tab){
    $chaine = '';
    foreach($tab as $key => $value){
        if($key > 0){
            $chaine = $chaine . ', ';
        }
        $chaine = $chaine . $value['prénom'] . ' ' . $value['nom']; ;
    }
    return $chaine;
}


// La fonction retourne id de l'acteur pendant la recherche
function retourneIdActeurs($chaine){

    $tableu_acteurs_id = [];

    $sqlDefault = "SELECT * FROM Acteur";

    if(substr_count($chaine, " ") > 0){
        list($prénom, $nom) = explode(" ", $chaine);
        $sql =  $sqlDefault . " WHERE prénom = '$prénom' AND nom LIKE '$nom%'";
    }elseif(substr_count($chaine, " ") == 0) {
        $sql = $sqlDefault . " WHERE prénom LIKE '%$chaine%'";

        if(empty(query($sql)))
            $sql = $sqlDefault . " WHERE nom LIKE '%$chaine%'";      
    }else
        $sql = $sqlDefault;

    $acteurs = query($sql);

    foreach($acteurs as $acteur){
        $tableu_acteurs_id[] = $acteur['id'];
    }

    return $tableu_acteurs_id;

}

//// la fonction transforme la chaine de caractères au tableau
function faireTableau($chaine){

    $tableau_morceaux = explode(",",$chaine);

    $tableau_final = [];

    foreach($tableau_morceaux as $morceau){
        $morceau = trim($morceau);
        $tableau_final [] = list($prénom, $nom) = explode(" ", $morceau);
    }

    return $tableau_final;
}



//// La fonction change les acteurs et réalisateurs et enregistre les changements dans la base de données
function modifierChamp($film_id, $tableau, $sql, $nomTable){

    global $conn;

    $réalisateurs = query($sql);

    $existRéalisateurs_id = [];
    $newRéalisateurs_id = [];


    foreach($réalisateurs as $réalisateur){
        foreach($tableau as $key => $element){
            if($réalisateur['prénom'] == $element[0] && $réalisateur['nom'] == $element[1])
            {
                $existRéalisateurs_id[] = $réalisateur['id'];
                unset($tableau[$key]);
            }
        }
    }

    foreach($tableau as $element){
        $prénom = $element[0];
        $nom = $element[1];

        $sql2 = "INSERT INTO ".$nomTable." (prénom, nom) VALUES ('$prénom', '$nom')";
        $conn->query($sql2);

        $sql3 = "SELECT id FROM ".$nomTable." WHERE prénom = '$prénom' AND nom = '$nom'";
    
        $newRéalisateurs_id [] = query($sql3)[0]['id'];
    }

    $réalisateurs = array_merge($existRéalisateurs_id, $newRéalisateurs_id);

    $sql4 = "DELETE FROM Film_".$nomTable." WHERE film_id = $film_id";
    $conn->query($sql4);

    foreach($réalisateurs as $réalisateur){
        $sql5 = "INSERT INTO Film_".$nomTable." (film_id, ".$nomTable."_id) VALUES ('$film_id', '$réalisateur')"; 
        $conn->query($sql5);
    }
}



?>