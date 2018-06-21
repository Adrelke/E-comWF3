
    <!-- Footer -->
    <?php
    require_once('bdd.php');

    ?>
    <footer class="page-footer font-small blue-grey lighten-5 mt-4">

        <div style="background-color: #fff;">
            <div class="container">

                <!-- Grid row-->
                <div class="row py-4 d-flex align-items-center">

                    <!-- Grid column -->
                    <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                        <h6 class="mb-0">Nous contacter via les réseaux sociaux</h6>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-6 col-lg-7 text-center text-md-right">

                        <!-- Facebook -->
                        <a class="fb-ic">
                            <i class="fab fa-facebook white-text mr-4"> </i>
                        </a>
                        <!-- Twitter -->
                        <a class="tw-ic">
                            <i class="fab fa-twitter white-text mr-4"> </i>
                        </a>
                        <!-- Google +-->
                        <a class="gplus-ic">
                            <i class="fab fa-google-plus white-text mr-4"> </i>
                        </a>
                        <!--Linkedin -->
                        <a class="li-ic">
                            <i class="fab fa-linkedin white-text mr-4"> </i>
                        </a>
                        <!--Instagram-->
                        <a class="ins-ic">
                            <i class="fab fa-instagram white-text"> </i>
                        </a>

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row-->

            </div>
        </div>

        <!-- Footer Links -->
        <div class="container text-center text-md-left mt-5">

            <!-- Grid row -->
            <div class="row mt-3 dark-grey-text">

                <!-- Grid column -->
                <div class="row justify-content-between">
                        <div class="col-4">

                            <!-- Content -->
                            <h6 class="text-uppercase font-weight-bold">Site Ecom</h6>
                            <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                            <p>Sur Le GROSSITE l’univers de la cool attitude est de rigueur : l’ambiance, les décors et l’énergie de notre équipe de vente sont en totale harmonie avec l’esprit Tendance Store que nous avons voulu donner au magasin.
                             Avec notre large choix de marques, vêtements, chaussures et accessoires de qualité, vous serez toujours en accord avec les tendances d’aujourd’hui.
                             En outre, nous vous sommes totalement dévoués pour vous conseiller et vous suggérer les styles les plus « trendy » et « in » du moment.</p>

                        </div>


                        <div class="col-4 blocinfo">

                        <?php
                            
                            $resultat = $connexion->query('SELECT * FROM shops');
                            $infos = $resultat->fetchAll();
                            //var_dump($infos);
                            foreach($infos as $info){

                            
                        ?>
                    




                            <!-- Links -->
                            <h6 class="text-uppercase font-weight-bold">Contact</h6>
                            <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                            <p>
                                <i class="fa fa-home mr-3"></i><?= $info['name']?></p>
                            <p>
                                <i class="fas fa-address-card mr-3"></i><?= $info['adress']?></p>
                            <p>
                                <i class="fa fa-phone mr-3"></i> + 01 234 567 88</p>
                            

                            <?php          
                            }
                            ?>
                        </div>
                </div>

                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <!-- Copyright -->
        <div class="footer-copyright text-center text-black-50 py-3">© 2018 Copyright:
            <a class="dark-grey-text" href="https://mdbootstrap.com/bootstrap-tutorial/"> GROSSITE.com</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->
