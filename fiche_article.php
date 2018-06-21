<?php
session_start();
require_once('bdd.php');

if(!empty($_GET['id_product'])){
  $select_product = $connexion->prepare('SELECT name, price, dispo, date_crea, photo, products.id AS product_id, products.category AS category_id, category.category AS category_name FROM products INNER JOIN category ON products.category = category.id WHERE products.id = :id');
  $select_product->bindValue(':id', htmlspecialchars($_GET['id_product']));
  $select_product->execute();
  $product = $select_product->fetch();
}else{
  header('Location: liste.php');
}


$select_random_products = $connexion->query('SELECT * FROM products ORDER BY  RAND() LIMIT 2');
$random_products = $select_random_products->fetchAll();


?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/fiche-article.css">
  </head>
  <body>
      <?php include('header.php') ?>
      <section class="container mt-5 d-flex justify-content-between">
        <div class="col-5">
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
                  <small class="text-center"><?= $product['category_name'] ?></small>
                </div>
                <div class="d-flex justify-content-around mt-2">
                  <span class="price height-45 m-0"><?= $product['price'] ?> €</span>
                  <button class="btn btn-secondary height-45">Ajouter au panier</button>
                </div>
              </div>
              

          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-body small-card-height">
              <img class="mr-2 min-img float-left" src="assets/img/<?= $random_products[0]['photo'] ?>">
              <div class="d-flex flex-column justify-content-around height-190">
                <span class="price text-center"><?= $random_products[0]['price'] ?> €</span>
                <a class="text-center" href="fiche_article.php?id_product=<?= $random_products[0]['id'] ?>">Voir la fiche</a>
              </div>
            </div>
          </div>

          <div class="card margin-30">
          <div class="card-body small-card-height">
              <img class="mr-2 min-img float-left" src="assets/img/<?= $random_products[1]['photo'] ?>">
              <div class="d-flex flex-column justify-content-around height-190">
                <span class="price text-center"><?= $random_products[1]['price'] ?> €</span>
                <a class="text-center" href="fiche_article.php?id_product=<?= $random_products[1]['id'] ?>">Voir la fiche</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php include('footer.php') ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="assets/js/simpleCart.js"></script>
    <script src="assets/js/cookie.js"></script>
  </body>
</html>