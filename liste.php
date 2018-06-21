<?php require('bdd.php');
session_start(); 

$select_categories = $connexion->query('SELECT * FROM category');
$categories = $select_categories->fetchAll();

    //Valeurs à entrer dans l'url pour la pagination
    if(!empty($_POST['product_name'])){
        $product_name = htmlspecialchars($_POST['product_name']); 
    }elseif(!empty($_GET['product_name'])){
        $product_name = htmlspecialchars($_GET['product_name']);
    }

    if(!empty($_POST['category'])){
        $search_category = htmlspecialchars($_POST['category']); 
    }elseif(!empty($_GET['category'])){
        $search_category = htmlspecialchars($_GET['category']);
    }

    if(!empty($_POST['max_price'])){
        $max_price = htmlspecialchars($_POST['max_price']); 
    }elseif(!empty($_GET['max_price'])){
        $max_price = htmlspecialchars($_GET['max_price']);
    }

    if(!empty($_POST['order'])){
        $order = htmlspecialchars($_POST['order']); 
    }elseif(!empty($_GET['order'])){
        $order = htmlspecialchars($_GET['order']);
    }

$errors = [];
if(!empty($_POST)){
    if(empty($_POST['nb_per_page']) || !is_numeric($_POST['nb_per_page'])) {
        $errors[] = 'nombre d\'article par page invalide';
    }
}elseif(!empty($_GET)){
    if(empty($_GET['nb_per_page']) || !is_numeric($_GET['nb_per_page'])){
        $errors[] = 'nombre d\'article par page invalide';
    }
}

//Requêtes en fonction des inputs remplies
if(empty($errors)) {
    $first_condition = true;
    $request ='SELECT photo, products.id AS product_id, name, products.category AS products_category, category.category AS category_name, price, dispo FROM products INNER JOIN category ON products.category = category.id ';
    $request_count = 'SELECT COUNT(id) AS nb FROM products ';

    //Concatenation des requetes
    if(isset($product_name)) {
        if(!$first_condition) {
            $request .= ' AND';
            $request_count .= ' AND';
        }else{
            $request .= ' WHERE';
            $request_count .= ' WHERE';
            $first_condition = false;
        }
        $request .= ' name LIKE :product_name';
        $request_count .= ' name LIKE :product_name';
    }
    if(!empty($max_price)) {
        if(!$first_condition) {
            $request .= ' AND';
            $request_count .= ' AND';
        }else{
            $request .= ' WHERE';
            $request_count .= ' WHERE';
            $first_condition = false;
        }
        $request .= ' price <= :price';
        $request_count .= ' price <= :price';
    }
    if(isset($search_category) && $search_category != 'all') {
        if(!$first_condition) {
            $request .= ' AND';
            $request_count .= ' AND';
        }else{
            $request .= ' WHERE';
            $request_count .= ' WHERE';
            $first_condition = false;
        }
        $request .= ' products.category = :category';
        $request_count .= ' products.category = :category';
    }
    if(isset($order)) {
        if($order == 'ascending') {
            $request .= ' ORDER BY price';
        }
        if($order == 'descending') {
            $request .= ' ORDER BY price DESC';
        }
    }


    //Pagination

    $request .= ' LIMIT :offset, :nb_per_page';
    if(!empty($_GET['page'])) {
        $current_page = htmlspecialchars($_GET['page']);
    }else{
        $current_page = 1;
    }
    if(!empty($_POST['nb_per_page'])){
        $nb_per_page = htmlspecialchars($_POST['nb_per_page']);
    }elseif(!empty($_GET['nb_per_page'])) {
        $nb_per_page = htmlspecialchars($_GET['nb_per_page']);
    }else{
        $nb_per_page = 5;
    }
    $offset = ($current_page - 1)*$nb_per_page;

    //bindValue
    $select_products = $connexion->prepare($request);
    $count_products = $connexion->prepare($request_count);
    if(isset($product_name)) {
        $select_products->bindValue(':product_name', '%'.htmlspecialchars($product_name).'%');
        $count_products->bindValue(':product_name', '%'.htmlspecialchars($product_name).'%');
    }
    if(isset($search_category) && $search_category != 'all') {
        $select_products->bindValue(':category', htmlspecialchars($search_category));
        $count_products->bindValue(':category', htmlspecialchars($search_category));
    }
    if(!empty($max_price)) {
        $select_products->bindValue(':price', htmlspecialchars($max_price));
        $count_products->bindValue(':price', htmlspecialchars($max_price));
    }

    $select_products->bindValue(':offset', $offset, PDO::PARAM_INT);
    $select_products->bindValue(':nb_per_page', $nb_per_page, PDO::PARAM_INT);
    $select_products->execute();
    $products = $select_products->fetchAll();

    $count_products->execute();
    $nb_products = $count_products->fetch();

    //Compte du nombre de pages

    $nb_pages = ceil($nb_products['nb'] / $nb_per_page);


}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Recherche d'article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
                    <!-- Nom produit -->
                    <div class="form-group">
                        <label for="product_name">Nom du produit :</label>
                        <input name="product_name" class="form-control" type="text" value="<?php if(!empty($_POST['product_name'])){ echo htmlspecialchars($_POST['product_name']); } ?>" >
                    </div>
                    <!-- Categorie -->
                    <div class="form-group">
                        <label for="category">Catégorie :</label>
                        <select class="form-control" name="category">
                        <option value="all">--- Toutes les catégories ---</option>
                            <?php
                            foreach($categories as $category) {
                                ?>
                                <option <?php if(!empty($_POST['category']) && $_POST['category'] == $category['id']){ echo 'selected'; } ?> value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Prix max -->
                    <div class="d-flex justify-content-between">
                        <div class="col-5 pl-0">
                            <label for="max_price">Prix maximum</label>        
                            <input value="<?php if(!empty($_POST['max_price'])){ echo $_POST['max_price']; } ?>" class="form-control" name="max_price" type="number" min="0">
                        </div>
                        <div class="col-7 pr-0">
                            <label for="order">Trier par</label>
                            <select class="form-control" name="order">
                                <option <?php if(isset($order) && $order == 'ascending'){ echo 'selected'; } ?> value="ascending">Prix Croissant</option>
                                <option <?php if(isset($order) && $order == 'descending'){ echo 'selected'; } ?> value="descending">Prix Décroissant</option>
                                <option <?php if(!isset($order) || ( isset($order) && $order != 'ascending' && $order != 'descending') ){ echo 'selected'; } ?> >Aucun Tri</option>
                            </select>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-primary col-4 height-38">Rechercher</button>
                        <label for="nb_per_page" class="col-5 label-1">Articles par page:</label>
                        <select class="form-control col-3 height-38" name="nb_per_page">
                            <option <?php if($nb_per_page == 5){ echo 'selected'; } ?> value="5">5</option>
                            <option <?php if($nb_per_page == 15){ echo 'selected'; } ?> value="15">15</option>
                            <option <?php if($nb_per_page == 25){ echo 'selected'; } ?> value="25">25</option>
                            <option <?php if($nb_per_page == 50){ echo 'selected'; } ?> value="50">50</option>
                        </select>
                    </div>
                </form>
                <!-- Fin Formulaire de recherche -->
            </div>
        </div>
    </section>

<?php if(empty($errors)){ ?>
    <!-- Afficher les résultats -->
    <section class="container">
        <div class="card">
            <div class="card-header py-3 px-5">
                <h4 class='no-margin'><?php echo $nb_products['nb']; ?> résultat<?php if($nb_products['nb'] > 1){echo 's';} ?></h4>
            </div>
            <div class="card-body p-5 d-flex flex-column">
                <?php
                    foreach ($products as $product) {
                        ?>
                        <div class="d-flex flex-row my-4">
                            <div class="col-4"><img class="img-product" src="assets/img/<?= $product['photo'] ?>" alt="photo du produit"></div>
                            <div class="col-6 p-5">
                                <h3><?php if(isset($product_name)){echo preg_replace('#('.htmlspecialchars($product_name).')#i', '<span style="color: red;">$1</span>', $product['name']);} else { echo $product['name'];} ?></h3>
                                <small><?= $product['category_name'] ?></small><br>
                                <a href="fiche_article.php?id_product=<?= $product['product_id'] ?>"><small>Voir la fiche de l'article</small></a>
                                
                            </div>
                            <div class="col-2 d-flex flex-column justify-content-center">
                                <span class="price"><?= $product['price'] ?> €</span><br>
                                <?php
                                    if($product['dispo']) {
                                        echo '<small class="dispo-true">Disponible en magasin</small>';
                                    }else{
                                        echo '<small class="dispo-false">Indisponible pour le moment</small>';
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <!-- Liste des liens de pagination -->
            <div class="p-2">
                <?php
                    for($i = 1; $i <= $nb_pages; $i++) {
                        $url = 'liste.php?page=' . $i . '&nb_per_page=' . $nb_per_page;
                        if(isset($product_name)){
                            $url .= '&product_name=' . $product_name;
                        }
                        if(isset($search_category)){
                            $url .= '&category=' . $search_category;
                        }
                        if(isset($max_price)){
                            $url .= '&max_price=' . $max_price;
                        }
                        if(isset($order)){
                            $url .= '&order=' .$order;
                        }
                        ?>
                        <a href="<?= $url ?>"><?= $i.' | ' ?></a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </section>
<?php } ?>
<?php include('footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/simpleCart.js"></script>
</body>
</html>