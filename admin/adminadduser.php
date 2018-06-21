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
            // header('Location: adminadduser.php');
            echo '<p class="alert alert-success">inscription OK!</p>';
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

<?php
if(!empty($_SESSION)){
    if($_SESSION['role'] == 'ROLE_ADMIN'){
        include('headerA.php');
    ?>


    <div class="container mt-5">
    <form method="POST">
      <div class="form-group">
        <label for="exampleInputPassword1">Pseudo</label>
        <input name="nickname" type="text" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Addresse Email</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
          <label for="">Rôle :</label>
          <select name="role" class="form-control">
              <option value="ROLE_ADMIN">Administrateur</option>
              <option value="ROLE_VENDOR">Vendeur</option>
              <option value="ROLE_USER">Utilisateur</option>
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    </div>

    <?php
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Vous n'avez pas les droits necessaires pour accéder à cette page.
        </div>
        <?php
    }       
}else{
    echo 'Erreur';
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>


