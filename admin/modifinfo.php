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
    include('headerA.php');
if(!empty($_SESSION)){
        if ($_SESSION['role'] == "ROLE_ADMIN") {

            if(!empty($_POST)){
                //var_dump($_POST);
                $post = [];


                foreach($_POST as $key => $value){
                    $post[$key] = trim(strip_tags($value));
                }


                $errors = [];
                ?>
                <pre>
                <?php
                print_r($_FILES);
                ?>
                </pre>

                <?php               
               
                
                if($_FILES['photo']['error'] == 0){
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
                }
                if($_FILES['photo2']['error'] == 0){
                    $masSize = 1048576;
                    $fileInfo=pathinfo($_FILES['photo2']['name']);
                    $extension=$fileInfo['extension'];
                    $extensions_autorisees=['jpg','png','jpeg'];
                    $newName1 = md5(uniqid(rand(),true));

                if (empty($_FILES)) {
                    $errors[] = 'Image manquante';
                    } elseif ($_FILES['photo2']['error'] != 0) {
                    $errors[] = 'error de transfert';
                    } elseif ($_FILES['photo2']['size'] > $masSize) {
                    $errors[] = 'Image trop grande';
                    }elseif(!in_array($extension,$extensions_autorisees)){
                    $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                    }else{
                    //tout est bon, donc je peux enregistrer l'image dans mon dossier
                    move_uploaded_file($_FILES['photo2']['tmp_name'],'../assets/img/'.$newName1.'.'.$extension);
                    }
                }
                if($_FILES['photo3']['error'] == 0){
                    $masSize = 1048576;
                    $fileInfo=pathinfo($_FILES['photo3']['name']);
                    $extension=$fileInfo['extension'];
                    $extensions_autorisees=['jpg','png','jpeg'];
                    $newName2 = md5(uniqid(rand(),true));

                if (empty($_FILES)) {
                    $errors[] = 'Image manquante';
                    } elseif ($_FILES['photo3']['error'] != 0) {
                    $errors[] = 'error de transfert';
                    } elseif ($_FILES['photo3']['size'] > $masSize) {
                    $errors[] = 'Image trop grande';
                    }elseif(!in_array($extension,$extensions_autorisees)){
                    $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                    }else{
                    //tout est bon, donc je peux enregistrer l'image dans mon dossier
                    move_uploaded_file($_FILES['photo3']['tmp_name'],'../assets/img/'.$newName2.'.'.$extension);
                    }
                }
                if($_FILES['photo4']['error'] == 0){
                    $masSize = 1048576;
                    $fileInfo=pathinfo($_FILES['photo4']['name']);
                    $extension=$fileInfo['extension'];
                    $extensions_autorisees=['jpg','png','jpeg'];
                    $newName3 = md5(uniqid(rand(),true));

                if (empty($_FILES)) {
                    $errors[] = 'Image manquante';
                    } elseif ($_FILES['photo4']['error'] != 0) {
                    $errors[] = 'error de transfert';
                    } elseif ($_FILES['photo4']['size'] > $masSize) {
                    $errors[] = 'Image trop grande';
                    }elseif(!in_array($extension,$extensions_autorisees)){
                    $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                    }else{
                    //tout est bon, donc je peux enregistrer l'image dans mon dossier
                    move_uploaded_file($_FILES['photo4']['tmp_name'],'../assets/img/'.$newName3.'.'.$extension);
                    }
                }

                var_dump($errors);
                if(empty($errors)){
                    //si le tableau $errors est vide, on peut enregistrer dans la bdd
                    $requete = 'UPDATE shops SET';

                    if($post['name']){
                        $requete .= ' name = :name';
                    }
                    if($post['adress']){
                        $requete .= ' adress = :adress';
                    }
                    if(!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                        $requete .= ' photo = :photo,';
                    }
                    if(!empty($_FILES['photo2']) && $_FILES['photo2']['error'] == 0){
                        $requete .= ' photo2 = :photo2,';
                    }
                    if(!empty($_FILES['photo3']) && $_FILES['photo3']['error'] == 0){
                        $requete .= ' photo3 = :photo3,';
                    }
                    if(!empty($_FILES['photo4']) && $_FILES['photo4']['error'] == 0){
                        $requete .= ' photo4 = :photo4,';
                    }
                    $sql = substr($requete, 0,-1);
                    $resultat = $connexion->prepare($sql);

                    if($post['name']){
                    $resultat->bindValue(':name', $post['name']);
                    }
                    if($post['adress']){
                    $resultat->bindValue(':adress', $post['adress']);
                    }
                    if(!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                    $resultat->bindValue(':photo', $newName.'.'.$extension);
                    }
                    if(!empty($_FILES['photo2']) && $_FILES['photo2']['error'] == 0){
                    $resultat->bindValue(':photo2', $newName1.'.'.$extension);
                    }
                    if(!empty($_FILES['photo3']) && $_FILES['photo3']['error'] == 0 ){
                    $resultat->bindValue(':photo3', $newName2.'.'.$extension);
                    }
                    if(!empty($_FILES['photo4']) && $_FILES['photo4']['error'] == 0){
                    $resultat->bindValue(':photo4', $newName3.'.'.$extension);
                    }
                    if($resultat->execute()){
                        echo '<p class="alert alert-success">Infos modifiées!</p>';
                    }
                    else{
                        echo '<p class="alert alert-danger">problème lors des modifications</p>';
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
        <label >Modifier la photo Slider 1</label>
        <input name="photo" type="file" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label >Modifier la photo Slider 2</label>
        <input name="photo2" type="file" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label >Modifier la photo Slider 3</label>
        <input name="photo3" type="file" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label >Modifier la photo Slider 4</label>
        <input name="photo4" type="file" class="form-control" id="exampleInputPassword1">
      </div>
      <button class="btn btn-primary">Modifier</button>
    </form>
</div>
    <?php

    }
}
    ?>
</body>
</html>