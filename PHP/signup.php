<?php
    session_start();
    define('ABSPATH', true);

    include './database.php';
    include './functions.php';

    $_POST = filter_input_array(INPUT_POST,['nom' => FILTER_SANITIZE_SPECIAL_CHARS,
                                            'prenom' => FILTER_SANITIZE_SPECIAL_CHARS,
                                            'login' => FILTER_SANITIZE_EMAIL,
                                            'password' => FILTER_SANITIZE_SPECIAL_CHARS,
                                            'password_confirmation' => FILTER_SANITIZE_SPECIAL_CHARS]);

    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';

 

    if(!estLoginUnique($login)){
        $_SESSION['message1'] = "Login n'est pas unique";
        header('Location: /register.php');
    }
    elseif ($password !== $password_confirmation){
        $_SESSION['message2'] = 'Les mots de passe ne sont pas identiques';
        header('Location: /register.php');
    } 
    else {

        $sql = "INSERT INTO Utilisateur (nom, prenom, login, mot_passe) 
                        VALUES ('$nom', '$prenom', '$login', '$password')"; 

        $conn->query($sql);
        
        header('Location: /login.php');
    }  
?>