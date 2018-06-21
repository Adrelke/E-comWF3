<?php
include('../bdd.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <title>Modifier un Article</title>
</head>
<body>
<?php
if($_SESSION['role'] == 'ROLE_ADMIN' or $_SESSION['role']=='ROLE_VENDOR')
{
include('headerA.php');



//si on fait ""submit""
        if(!empty($_POST)) {
            //le formulaire été envoyé:
            $errors = [];
            //verifications des données
            if (empty($_POST['name']) OR mb_strlen($_POST['name']) < 3 OR mb_strlen($_POST['name']) > 30) {
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
            if($_FILES['photo']['error'] == 0) {


                $masSize = 1048576;
                $fileInfo = pathinfo($_FILES['photo']['name']);
                $extension = $fileInfo['extension'];
                $extensions_autorisees = ['jpg', 'png', 'jpeg'];
                $newName = md5(uniqid(rand(), true));


                 if ($_FILES['photo']['size'] > $masSize) {
                    $errors[] = 'Image trop grande';
                } elseif (!in_array($extension, $extensions_autorisees)) {
                    $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                } else {
                    //tout est bon, donc je peux enregistrer l'image dans mon dossier
                    move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/img/' . $newName . '.' . $extension);
                }
            }

            //donner le valeur a dispo
            if(isset($_POST['dispo'])){
                $dispo=1;
            }else{$dispo=0;}


            if(empty($errors)) {
                //on peut modifier dans la base de donnees
                if($_FILES['photo']['error'] != 0){
                    $result = $connexion->prepare('UPDATE products SET name=:nom, price=:prix, category=:categorie, dispo=:disponibilite  WHERE id = :id');
                }else{
                    $result = $connexion->prepare('UPDATE products SET name=:nom, price=:prix, category=:categorie, dispo=:disponibilite, photo = "' . $newName . '.' . $extension . '"   WHERE id = :id');
                }


                $result->bindValue(':nom', strip_tags($_POST['name']));
                $result->bindValue(':prix', strip_tags($_POST['price']));
                $result->bindValue(':categorie', strip_tags($_POST['category']));
                $result->bindValue(':disponibilite', strip_tags($dispo));
                $result->bindValue(':id', strip_tags($_POST['id']));

                //si $resultat->execute() == true , l'article a bien été enregistré
                if ($result->execute()) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Produit bien modifie
                    </div>
                    <br>
                    <br>
                    <div class="alert alert-success" role="alert">
                        <a href="form_ajouter_article.php" class="alert-link">Retour</a>
                    </div>
                    <?php
                }else{
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Erreur
                        </div>
                        <?php
                    }


            }else{
                foreach ($errors as $error){
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$error?>
                    </div>
                    <?php
                }

            }


        }

                //je vais pre-remplir le champs avec l'id envoyé
                if(!empty($_GET['id']) ){
                    if(is_numeric($_GET['id'])) {

                        //requete pour montrer les doonnes
                        $res = $connexion->prepare('SELECT * FROM products WHERE id= :id');
                        $res->bindValue(':id', strip_tags($_GET['id']));
                        $res->execute();
                        $article = $res->fetch();

                        ?>
                        <br>
                        <br>
                        <div class="container">

                            <div class="card">
                                <h5 class="card-header">Modifier le Produit</h5>
                                <div class="card-body">
                                    <form method="post" action="modifier_produit.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Produit</label>
                                            <input type="text" name="name" value="<?= $article['name'] ?>"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Prix</label>
                                            <input type="number" min="0" name="price" value="<?= $article['price'] ?>"
                                                   class="form-control">
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
                                                foreach ($categories as $categorie) {
                                                    ?>
                                                    <option value="<?= $categorie['id'] ?>" <?php if ($categorie['id'] == $article['category']) {
                                                        echo 'selected';
                                                    } ?>><?= $categorie['category'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1">Photo du produit</label>

                                            <img class="card-img-top" src="../assets/img/<?= $article['photo'] ?>"
                                                 alt="Image">
                                            <input type="file" name="photo" class="form-control-file"
                                                   id="exampleFormControlFile1">
                                            <smal id="emailHelp" class="form-text text-muted">Taille max: 1Mo</smal>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="dispo" <?php if ($article['dispo'] == '1') {
                                                echo 'checked = true';
                                            } ?>class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Disponible</label>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                        <button type="submit" class="btn btn-primary">MODIFIER</button>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <br>


                        </div>


                        <?php
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


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>