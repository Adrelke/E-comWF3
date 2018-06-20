<?php require('bdd.php'); 

$select_categories = $connexion->query('SELECT * FROM category');
$categories = $select_categories->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Recherche d'article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/liste.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/app.css" />
</head>
<body>  
    <?php include('header.php'); ?>
    <section class="container search-product d-flex justify-content-center">
        <div class="col-md-5">
            <div class="card my-3">
                <h2 class="card-header">Rechercher un article</h2>
            <!-- Formulaire de recherche -->
                <form method="post" action="liste.php" class="py-4 px-5">
                    <div class="form-group">
                        <label for="product_name">Nom du produit :</label>
                        <input name="product_name" class="form-control" type="text" >
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie :</label>
                        <select class="form-control" name="category">
                        <option value="all">--- Tous les articles ---</option>
                            <?php
                            foreach($categories as $category) {
                                ?>
                                <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="max-price">Prix maximum</label>        
                        <input class="form-control" name="max-price" type="number">
                    </div>
                </form>
            </div>
        </div>
    </section>

<section class="container">

 </section>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>