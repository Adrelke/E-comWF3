<?php
session_start();



if(isset($_GET['deconnexion'])){
    session_destroy();
    header('Location: ../accueil.php');

}



require_once('../bdd.php');
                
//traitement de l'inscription
if(!empty($_POST)){
    //si le formulaire a été envoyé
    
    //nettoyage de post
    $post = [];
    
    foreach($_POST as $key=>$value){
        $post[$key] = trim(strip_tags($value));
    }
    
    $errors = [];


    //on doit vérfier que l'email n'est pas déjà présent dans la base
    $resultat = $connexion->prepare('SELECT id FROM users WHERE email = :email');
    $resultat->bindValue(':email', $post['email']);
    $resultat->execute();
    //on envoie toutes les réponses éventuelles dans une variable, qui sera donc un tableau (de tableau(x))
    $users = $resultat->fetchAll(PDO::FETCH_ASSOC);
    //on compte le nombre de "cases" de ce tableau
    if(count($users) > 0){
        $errors['email existe'] = 'l\'email est déjà présent dans la base';
    }

    
    if(!isset($post['nickname']) OR mb_strlen($post['nickname']) < 4 OR mb_strlen($post['nickname']) > 10){
        $errors['nickname'] = 'le nickname doit faire entre 4 et 10 caractères.';
    }
    
    if(!isset($post['password'])){
        $errors['password'] = 'Veuillez saisir un mot de passe.';
    }
    
    if(!isset($post['email']) OR !filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'email invalide';
    }
    
    if(empty($errors)){
        $resultat = $connexion->prepare('INSERT INTO users (nickname, email, password, role) VALUES (:nickname, :email, :password, :role)');
        $resultat->bindValue(':nickname', $post['nickname']);
        $resultat->bindValue(':email', $post['email']);
        $resultat->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
        $resultat->bindValue(':role', $post['role']);
        if($resultat->execute()){
            echo '<p class="alert alert-success">inscription OK!</p>';
            header('Location: adminadduser.php');
        }
        
    }
    else{
        foreach($errors as $error){
            echo '<p class="alert alert-danger">' . $error . '</p>';
        }

        echo '<a href="index.php">Retour au formulaire</a>';
    }
}




?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ajout utilisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/app.css">
    
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../accueil.php">Accueil<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav_item active">
        <a class="nav-link" href="adminadduser.php?deconnexion">deconnexion<span class="sr-only">(current)</a>
      </li>
    </ul>
  </div>
</nav>



<div class="container">
<form method="POST">
  <div class="form-group">
    <label for="exampleInputPassword1">Insérer le nickname utilisateur</label>
    <input name="nickname" type="text" class="form-control" id="exampleInputPassword1" placeholder="nickname">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Insérer l'email utilisateur</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entrer email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Insérer le password utilisateur</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
      <select name="role" class="form-control">
          <option value="ROLE_ADMIN">Rôle Administrateur</option>
          <option value="ROLE_VENDOR">Rôle vendeur</option>
          <option value="ROLE_USER">Rôle utilisateur</option>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Inscrire</button>
</form>
</div>


</body>
</html>