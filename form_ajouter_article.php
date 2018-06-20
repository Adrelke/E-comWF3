<?php
    include('bdd.php');
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/app.css">

    <title>Contact</title>
</head>
<body>
<?php
include ('header.php');
?>
<br>
<br>

<?php
 if($_SESSION['role'] == 'ROLE_ADMIN' or $_SESSION['role']=='ROLE_VENDOR')
 {
?>
<div class="container">

            <div class="card">
                <h5 class="card-header">Ajouter un Article</h5>
                <div class="card-body">
                    <form method="post" action="form_ajouter_article.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Produit</label>
                            <input type="text" name="name" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Prix</label>
                            <input type="number" min="0" name="price" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Categories</label>
                            <select class="form-control" name="category" id="exampleFormControlSelect1">
                                <option value="">Selectionne une categorie</option>
                                <?php
                                    //requete pour afficher les categories
                                $resultat = $connexion->query('SELECT * FROM category');
                                $resultat->execute();
                                $categories = $resultat->fetchAll();
                                foreach ($categories as $categorie){
                                ?>
                                <option value="<?=$categorie['id']?>"><?=$categorie['category']?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Photo du produit</label>
                            <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1">
                            <smal id="emailHelp" class="form-text text-muted">Taille max: 1Mo</smal>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox"  name="dispo" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label"  for="exampleCheck1">Disponible</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

</div>
<?PHP
    //si on fait ""submit""
            if(!empty($_POST)) {
                //le formulaire été envoyé:
                $errors = [];
                //verifications des données
                if (empty($_POST['name']) OR mb_strlen($_POST['name']) < 3 OR mb_strlen($_POST['name']) > 20) {
                    //le paramètre n'existe pas, est trop long ou est trop court
                    $errors['name'] = 'Nom absent, ou incorrecte';
                }
                if (empty($_POST['price']) or !is_numeric($_POST['price']) or $_POST['price'] > 2000) {
                    $errors['price'] = 'Prix absence ou est incorrecte';
                }

                if (empty($_POST['category']) or !is_numeric($_POST['category'])) {
                    $errors['category'] = 'categorie incorrecte';
                }
                //verification du FILE
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
                    move_uploaded_file($_FILES['photo']['tmp_name'],'assets/img/'.$newName.'.'.$extension);
                }

                //donner le valeur a dispo
                if($_POST['dispo']=='on'){
                    $dispo=1;
                }else{$dispo=0;}


                if(empty($errors)) {
                    //on peut enregistrer dans la bdd

                    $result = $connexion->prepare('INSERT INTO product (name, price, category, dispo, date_crea, photo)
                                                              VALUES (:produit, :prix, :categorie, "'.$dispo.'", "' . date('Y-m-d') . '", "' . $newName . '.' . $extension . '")');

                    //je protège mes variables utilisateur avec strip_tags() ou htmlspecialchars()
                    $result->bindValue(':produit', strip_tags($_POST['name']));
                    $result->bindValue(':prix', strip_tags($_POST['price']));
                    $result->bindValue(':categorie', strip_tags($_POST['category']));
                    $result->execute();
                    //si $resultat->execute() == true , l'article a bien été enregistré
                    if ($result->execute()) {
                        ?>
                        <div class="alert alert-primary" role="alert">
                            Produit bien ajoute
                        </div>
                        <?php
                    }
                }else{
                    echo implode('<br>', $errors);
                }


            }

}else {
     ?>
     <br>
     <br>
     <div class="alert alert-danger" role="alert">
         Page inacessible. <a href="accueil.php" class="alert-link">Retour à l'accueil</a>
     </div>
     <?php
 }
?>
<br>
<br>
<?php

include ('footer.php');
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
