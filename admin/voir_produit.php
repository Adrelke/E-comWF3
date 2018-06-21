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

    <title>Fiche produit</title>
</head>
<div>
<?php
if($_SESSION['role'] == 'ROLE_ADMIN' or $_SESSION['role']=='ROLE_VENDOR')
{
    include('headerA.php');

    if(!empty($_GET)){
        if(isset($_GET['id_product'])&& is_numeric($_GET['id_product'])){
            //lancer ma requete sql
            $result = $connexion->prepare('SELECT * FROM products INNER JOIN category ON products.category = category.id WHERE products.id = :idCat');
            $result->bindValue(':idCat', strip_tags($_GET['id_product']), PDO::PARAM_INT);
            $result->execute();
            $product= $result->fetch();

            //  AFFICHER LE PRODUIT
            ?>

                <div class="container">
                    <div class="card">
                        <div class="card-header">
                                <div class="d-flex justify-content-center">
                                    <h5 class="no-margin"><?= $product['name'] ?></h5>
                                </div>
                        </div>

                            <div class="card-body d-flex flex-column justify-content-center">
                                <?php
                                if($product['dispo']) {
                                    echo '<small class="line-center dispo-true">Disponible en magasin</small>';
                                }else{
                                    echo '<small class="dispo-false">En rupture de stock</small>';
                                }
                                ?>
                                <div class="row justify-content-center">
                                    <img class="img-product mt-2" src="assets/img/<?= $product['photo'] ?>" alt="photo du produit">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <small class="text-center"><?= $product['category'] ?></small>
                                </div>
                                <div class="d-flex justify-content-around mt-2">
                                    <span class="price height-45 m-0"><?= $product['price'] ?> €</span>
                                </div>
                            </div>

                    </div>
                </div>
            <br>
            <br>
            <div class="alert alert-danger" role="alert">
                <a href="form_ajouter_article.php" class="alert-link">Retour</a>
            </div>

            <?PHP
        }else{
            ?>
            <br>
            <br>
            <div class="alert alert-danger" role="alert">
                Page inacessible. <a href="accueil.php" class="alert-link">Retour à l'accueil</a>
            </div>
            <?php
        }
    }else{
        ?>
        <br>
        <br>
        <div class="alert alert-danger" role="alert">
            Page inacessible. <a href="accueil.php" class="alert-link">Retour à l'accueil</a>
        </div>
        <?php
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