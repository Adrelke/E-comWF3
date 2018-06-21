<?php
session_start();
include_once('../bdd.php');

$resultat = $connexion->query('SELECT * FROM messages');
$messages = $resultat->fetchAll();

if(!empty($_GET)){
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $delete = $connexion->prepare('DELETE FROM messages WHERE id = :id');
        $delete->bindValue(':id', $_GET['id']);
        $delete->execute();
        header('Location: messages.php');
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Messagerie</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php
    if(!empty($_SESSION)){
        if($_SESSION['role'] == 'ROLE_ADMIN'){
            include('headerA.php');
            ?>
            <div class="container">
                <div class="row text-center flex-column title">
                    <h1>Messagerie</h1>
                    <p>Il y a <?= count($messages) ?> message(s).</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        foreach($messages as $message){
                            ?>
                            <h2><?= $message['subject'] ?></h2>
                            <p>envoyé par <?= $message['name'] ?></p>
                            <p><?= $message['content'] ?></p>
                            <a href="#">Répondre</a>
                            <a href="messages.php?id=<?=$message['id']?>">Supprimer</a><hr>
                            <?php
                        }

                        ?>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>