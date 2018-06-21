<?php
    include('../bdd.php');

    session_start();

    if(isset($_GET['deconnexion'])){
        session_destroy();
        header('Location: ../accueil.php');
    
    }

$select_categories = $connexion->query('SELECT * FROM category');
$categories = $select_categories->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <title>Formulaire pour ajouter un Article</title>
</head>
<body>



<?PHP


if($_SESSION['role'] == 'ROLE_ADMIN' or $_SESSION['role']=='ROLE_VENDOR')
{
    include('headerA.php');

    //si on fait ""submit""
            if (!empty($_POST)) {

                    //CODE POUR AJOUTER LES ARTICLES
                if (isset($_POST['form_produit'])) {


                    $errors = [];
                    //verifications des données
                    if (empty($_POST['name']) or mb_strlen($_POST['name']) < 3 or mb_strlen($_POST['name']) > 20) {
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
                    $fileInfo = pathinfo($_FILES['photo']['name']);
                    $extension = $fileInfo['extension'];
                    $extensions_autorisees = ['jpg', 'png', 'jpeg'];
                    $newName = md5(uniqid(rand(), true));

                    if (empty($_FILES)) {
                        $errors[] = 'Image manquante';
                    } elseif ($_FILES['photo']['error'] != 0) {
                        $errors[] = 'error de transfert';
                    } elseif ($_FILES['photo']['size'] > $masSize) {
                        $errors[] = 'Image trop grande';
                    } elseif (!in_array($extension, $extensions_autorisees)) {
                        $errors[] = 'Mauvais extension, Les extensiones autorisees sont: jpg,png et jpeg';
                    } else {
                        //tout est bon, donc je peux enregistrer l'image dans mon dossier
                        move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/img/' . $newName . '.' . $extension);
                    }

                    //donner le valeur a dispo

                    if (isset($_POST['dispo'])) {
                        $dispo = 1;
                    } else {
                        $dispo = 0;
                    }


                    if (empty($errors)) {
                        //on peut enregistrer dans la bdd

                        $result = $connexion->prepare('INSERT INTO products (name, price, category, dispo, date_crea, photo)
                                                                          VALUES (:produit, :prix, :categorie, "' . $dispo . '", "' . date('Y-m-d') . '", "' . $newName . '.' . $extension . '")');

                        //je protège mes variables utilisateur avec strip_tags() ou htmlspecialchars()
                        $result->bindValue(':produit', strip_tags($_POST['name']));
                        $result->bindValue(':prix', strip_tags($_POST['price']));
                        $result->bindValue(':categorie', strip_tags($_POST['category']));

                        //si $resultat->execute() == true , l'article a bien été enregistré
                        $result->execute()
                        ?>
                        <div class="alert alert-success" role="alert">
                            Produit bien ajoute
                        </div>
                        <?php

                    } else {
                        echo implode('<br>', $errors);
                    }
                }
                //CODE POUR AJOUTE UNE CATEGORIE
                if (isset($_POST['form_categorie'])){
                    if (empty($_POST['name_categorie']) or mb_strlen($_POST['name_categorie']) < 3 or mb_strlen($_POST['name_categorie']) > 20) {
                        //le paramètre n'existe pas, est trop long ou est trop court
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Categorie manquante, trop long ou trop court
                        </div>
                        <?php
                    }else{
                        //ajouter la categorie
                        $nouvelle_cat = $connexion->prepare('INSERT INTO category (category) VALUES (:cat)');
                        $nouvelle_cat->bindValue(':cat', strip_tags($_POST['name_categorie']));
                        $nouvelle_cat->execute()
                        ?>
                        <div class="alert alert-success" role="alert">
                            Categorie bien ajoutée
                        </div>
                        <?php
                    }

                }


            }



            //CODE POUR SUPPRIMER
            if(!empty($_GET)){
                if(isset($_GET['id']) && is_numeric($_GET['id'])){   //CODE POUR SUPPRIMER L ARTICLE
                    $supprimer = $connexion -> query('DELETE FROM products WHERE id= '.$_GET['id'].' ');

                }elseif(isset($_GET['id_categorie']) && is_numeric($_GET['id_categorie'])) {
                    //CODE POUR SUPPRIMER UNE CATEGORIE
                    $supprimer = $connexion -> query('DELETE FROM category WHERE id= '.$_GET['id_categorie'].' ');
                }else
                {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        IMPOSSIBLE DE SUPPRIMER
                    </div>
                    <?php
                }
            }


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
                        <button type="submit" name="form_produit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
            <br>
            <br>
            <div class="card mt-4">
                <h5 class="card-header">Gérer les catégories</h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                            <?php
                            foreach($categories as $category) {
                                echo '<li class="list-group-item"><div class="row"><div class="col-md-8">'.$category['category'].'</div> <div class="text-right col-md-4" ><a href="modifier_produit.php?id='.$category['id'].'"> Modifier <i class="fas fa-edit"></i></a>   |  <a href="form_ajouter_article.php?id_categorie='.$category['id'].'"> Supprimer <i class="fas fa-trash-alt"></i></a></div></div></li>';
                            }
                            ?>
                    </ul>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Ajoute une Catégorie</h6>
                            <!-- FORMULAIRE POUR AJOUTER UNE CATEGORIE -->
                            <form method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nom de la nouvelle Catégorie</label>
                                    <input type="text" name="name_categorie" class="form-control" >
                                </div>
                                <button type="submit" name="form_categorie" class="btn btn-primary">Ajouter</button>
                            </form>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <!--  LISTE D'articles  -->
            <div class="card mt-4">
                <h5 class="card-header">Liste de Produits</h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php
                        //requete pour lister les produits
                        //seulement va me montrer les produits disponibles
                        $rsl= $connexion->query('SELECT * FROM products');
                        $productos = $rsl ->fetchAll();
                        foreach ($productos as $product){
                            echo '<li class="list-group-item"><div class="row"><div class="col-md-8"><a href="voir_produit.php">'.$product['name'].'</a></div> <div class="text-right col-md-4" ><a href="modifier_produit.php?id='.$product['id'].'"> Modifier <i class="fas fa-edit"></i></a>   |  <a href="form_ajouter_article.php?id='.$product['id'].'"> Supprimer <i class="fas fa-trash-alt"></i></a></div></div></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
<?php


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
