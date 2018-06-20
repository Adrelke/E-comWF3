<?php
session_start();

require_once('../bdd.php');

if(!empty($_POST)){

    $resultat = $connexion->prepare('SELECT * FROM users WHERE email = :email');
    $resultat->bindValue(':email', htmlspecialchars($_POST['email']));
    $resultat->execute();
    $utilisateur = $resultat->fetchAll();

    if(count($utilisateur) === 1){
        $mdpCrypt = $utilisateur[0]['password'];
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Merci de remplir les champs.
        </div>
        <?php
    }
    
    if(isset($mdpCrypt) && password_verify($_POST['password'], $mdpCrypt) && $utilisateur[0]['role'] == 'ROLE_ADMIN'){
        header('Location: optsadmin.php');
        $_SESSION['email'] = htmlspecialchars($_POST['email']);
        $_SESSION['pseudo'] = $utilisateur[0]['nickname'];
        $_SESSION['role'] = $utilisateur[0]['role'];;
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Vous n'avez pas les droits necessaires pour vous connecter.
        </div>
        <?php

    }
}



?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administration</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  </head>
  <body>
    <style>
        .retour{
              color: black;
              margin: 15px 0px 0px 15px;
        }
        .card {
            box-shadow: 0px 0px 25px black;
        }
    </style>
    <a  class="retour" href="../accueil.php"><i class="fas fa-arrow-left fa-3x"></i></a>
    <div class="container">
        <div class="row d-flex justify-content-center" style="margin-top: 285px;">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <form method="POST" action="indexA.php">
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email">
                      </div>
                      <div class="form-group">
                        <label for="">Mot de passe</label>
                        <input type="text" class="form-control" name="password">
                      </div>
                      <button class="btn btn-success">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>