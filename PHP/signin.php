<?php
    session_start();

    define('ABSPATH', true);

    require './database.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM Utilisateur WHERE login = '$login' AND mot_passe = '$password'";
    
    $user = query($sql);

    if($user){
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "nom" => $user['nom'],
            "prenom" => $user['prenom'],
            "email" => $user['email']];
        header('Location: /index.php');
    }
    else {
        $_SESSION['message'] = "Mauvais nom d'utilisateur ou mot de passe";
        header('Location: /login.php');
    } 
?>