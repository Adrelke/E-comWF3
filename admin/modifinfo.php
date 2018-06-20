<?php
session_start();



if(isset($_GET['deconnexion'])){
    session_destroy();
    header('Location: ../accueil.php');

}



require_once('../bdd.php');



?>





<!DOCTYPE html>
<html>
<head>
<title>Options administrateur</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
</head>
<body>
    <?php
if(!empty($_SESSION)){
        if ($_SESSION['role'] == "ROLE_ADMIN") {

            if(!empty($_POST)){
                
                $post = [];


                foreach($_POST as $key => $value){
                    $post[$key] = trim(strip_tags($value));
                }


                $errors = [];

                if(empty($post['name'])){
                    //le paramètre author n'existe pas ou est vide
                    $errors['name'] = 'Vous devez entrer le nom du magasin';
                }

                if(empty($post['adress'])){
                    //le paramètre content n'existe pas ou est vide
                    $errors['adress'] = 'Vous devez une adresse au magasin';
                }


                $masSize = 1048576;
                $fileInfo=pathinfo($_FILES['photo']['name']);
                $extension=$fileInfo['extension'];
                $extensions_autorisees=['jpg','png','jpeg'];
                $newName = md5(uniqid(rand(),true));

                if (empty($_FILES)) {
                    $errors[] = 'Image manquante';
                } elseif ($_FILES['photo']['error'] != 0) {
                    $errors[] = 'error de transfert';
                } elseif ($_FILES['photo']['size'] > $masSize) {
                    $errors[] = 'Image trop grande';
                }elseif(!in_array($extension,$extensions_autorisees)){
                    $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                }else{
                    //tout est bon, donc je peux enregistrer l'image dans mon dossier
                    move_uploaded_file($_FILES['photo']['tmp_name'],'../assets/img/'.$newName.'.'.$extension);
                }


                if(empty($errors)){
                    //si le tableau $errors est vide, on peut enregistrer dans la bdd

                    $resultat = $connexion->prepare('UPDATE shops SET name = :name, adress = :adress, photo = :photo WHERE id = 1');
                    $resultat->bindValue(':titre', $post['title']);
                    $resultat->bindValue(':contenu', $post['content']);
                    $resultat->bindValue(':auteur', $post['author']);
                    $resultat->bindValue(':idArticle', $post['id']);
                    if($resultat->execute()){
                        echo '<p class="alert alert-success">Article modifié</p>';
                    }
                    else{
                        echo '<p class="alert alert-danger">problème lors de l\'enregistremen</p>';
                    }

                }





            }



    ?>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label >Modifier le nom du magasin</label>
        <input name="name" type="text" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label >Modifier les coordonnées du magasin</label>
        <input name="adress" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label >Modifier la photo de couverture</label>
        <input name="photo" type="file" class="form-control" id="exampleInputPassword1">
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
    </div>
    <?php

    }
}
    ?>
</body>
</html>