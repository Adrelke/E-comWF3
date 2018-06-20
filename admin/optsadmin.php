<?php
session_start();

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Options administrateur</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <style>
        
          .card {
              box-shadow: 0px 0px 25px black;
          }

          .retour{
              color: black;
              margin: 15px 0px 0px 15px;
          }
    </style>
      <?php
      if(!empty($_SESSION)){
        if ($_SESSION['role'] == "ROLE_ADMIN") {
            ?>
            <a  class="retour" href="../accueil.php"><i class="fas fa-arrow-left fa-3x"></i></a>    
          <div class="container">
              <div class="row" style="margin-top: 285px;">
                  <div class="col-12 col-md-4 text-center">
                    <div class="card" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title">Ajouter un utilisateur</h5>
                        <p class="card-text"><i class="fas fa-users-cog fa-7x"></i></p>
                        <a href="adminadduser.php" class="card-link"><i class="fas fa-arrow-right fa-2x"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4 text-center">
                    <div class="card" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title">Ajout/Modif articles</h5>
                        <p class="card-text"><i class="fas fa-edit fa-7x"></i></p>
                        <a href="#" class="card-link"><i class="fas fa-arrow-right fa-2x"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4 text-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title">Modif informations</h5>
                          <p class="card-text"><i class="fas fa-globe fa-7x"></i></p>
                          <a href="#" class="card-link"><i class="fas fa-arrow-right fa-2x"></i></a>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
          <?php
        }
      }
    ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>