<?php
session_start();
require_once('bdd.php');

if(isset($_GET['deconnexion'])){
    session_destroy();
    header('Location: accueil.php');
}

$resultat = $connexion->query('SELECT * FROM shops');
$info = $resultat->fetch();
//var_dump($info);
//echo $info['photo'];


?>

<!doctype html>
<html lang="en">
  <head>
    <title>Page d'accueil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/accueil.css">
  </head>
  <body>
    <?php include('header.php')?>
    <section class="container-fluid my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="carouselId" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselId" data-slide-to="1"></li>
                            <li data-target="#carouselId" data-slide-to="2"></li>
                            <li data-target="#carouselId" data-slide-to="2"></li>
                        </ol>
                        <?php 
//var_dump($info); ?>
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <img src="./assets/img/<?php echo $info['photo']?>" alt="First slide" name="photo1">
                            </div>
                            <div class="carousel-item">
                                <img src="./assets/img/<?php echo $info['photo2']?>" alt="Second slide" name="photo2">
                            </div>
                            <div class="carousel-item">
                                <img src="./assets/img/<?php echo $info['photo3']?>" alt="Third slide" name="photo3">
                            </div>
                            <div class="carousel-item">
                                <img src="./assets/img/<?php echo $info['photo4']?>" alt="Third slide" name="photo4">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid text-center titre">
        <h1 class="py-4">Présentation</h1>
    </section>
    <section class="container-fluid presentation">
        <div class="container textepresentation">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div>
            <div class="row produits-exemple">
                <!-- image type a remplacer avec image et caption de la bdd -->
                <div class="col-12 col-md-3">
                    <figure>
                        <img src="http://via.placeholder.com/300x300" alt="produit1">
                        <figcaption>Photo d'un voyage à Porto. Ville emplie de graffitis, balcons loufoques et chats profitant des quelques ruines derrière la ville.</figcaption>
                    </figure>
                </div>
                <div class="col-12 col-md-3">
                    <figure>
                        <img src="http://via.placeholder.com/300x300" alt="produit2">
                    </figure>
                </div>
                <div class="col-12 col-md-3">
                    <figure>
                        <img src="http://via.placeholder.com/300x300" alt="produit3">
                    </figure>
                </div>
                <div class="col-12 col-md-3">
                    <figure>
                        <img src="http://via.placeholder.com/300x300" alt="produit4">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>