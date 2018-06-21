<?php
session_start();
require_once('../bdd.php');

if(!empty($_GET)){
    $resulat = $connexion->prepare('SELECT * FROM tokenreset WHERE token = :token');
    $resulat->bindValue(':token', $_GET['token']);
    $resulat->execute();
    $user = $resulat->fetchAll();
    if(count($user) === 1){
        $userID = $user[0]['user_id'];
        ?>
        <h2>Reinitialisation de mot de passe</h2>
        <form method="POST">
            <input type="password" name="password">
            <input type="password" name="passwordbis">
            <button>Confirmer</button>
        </form>
        <?php
    }else {
        echo "La page n'existe plus";
    }
}

if(!empty($_POST)){
    $errors = [];

    if(empty($_POST['password']) || $_POST['password'] != $_POST['passwordbis']){
        $errors[] = "Mot de passe invalide";
    }

    if(empty($errors)){
        $update = $connexion->prepare('UPDATE users SET password = :password WHERE id = "'.$userID.'"');
        $update->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $update->execute();
        $delete = $connexion->query('DELETE FROM tokenreset WHERE user_id = "'.$userID.'"');
        echo "mdp modifé";
    } else {
        echo implode('</br>', $errors);
    }
}