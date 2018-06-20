<header class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-8">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="accueil.php">SITE ECOM</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                      <ul class="navbar-nav">
                        <li class="nav-item active">
                          <a class="nav-link" href="accueil.php">Accueil <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="liste.php">Liste produit</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                      </ul>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center">
                <?php
                if(empty($_SESSION)){
                    ?>
                    <a class="btn btn-primary" href="./admin/indexA.php">Connexion</a>
                    <?php
                }
                if(isset($_SESSION['pseudo'])){
                    if($_SESSION['role'] == "ROLE_ADMIN"){
                        ?>
                        <a class="option" href="./admin/optsadmin.php"><i class="fas fa-cogs fa-2x"></i></a>
                        <?php
                    } elseif($_SESSION['role'] == "ROLE_VENDOR"){
                        ?>
                        <a class="option" href="#"><i class="fas fa-cogs fa-2x"></i></a>
                        <?php
                    }
                    ?>
                    
                    <a class="btn btn-danger" href="accueil.php?deconnexion">Deconnexion</a>
                    <?php
                    
                }
                ?>
            </div>
        </div>
</header>