<?php 
session_start();
require_once('../bdd.php');

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if(!empty($_POST)){
    $resultat = $connexion->prepare('SELECT * FROM users WHERE email = :email');
    $resultat->bindValue(':email', htmlspecialchars($_POST['email_reset']));
    $resultat->execute();
    $utilisateur = $resultat->fetchAll();
    if(count($utilisateur) === 1){
        $userId = $utilisateur[0]['id'];
        $tokenG = generateRandomString();
        resetMdp($_POST['email_reset'], $tokenG);
        $requeteReset = $connexion->query('INSERT INTO tokenreset(token, user_id) VALUES ("'.$tokenG.'" , "'.$userId.'")');
    } else {
        echo "identifiant incorrect";
    }
}

function resetMdp($mailUtilisateur,$token){
    $mail = new PHPMailer();

    // débug
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    // utilisation du SMTP

    $mail->isSMTP();
    $mail->Host = 'mail.gmx.com';

    $mail->SMTPAuth = true;
    $mail->Username = 'leomagnac@gmx.fr';
    $mail->Password = 'Yoloswag33';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // expediteur et destinataire
    $mail->SetFrom('leomagnac@gmx.fr', 'Simon');
    $mail->addAddress($mailUtilisateur, 'S.Amade');
    // on peut ajouter des cc
    // $mail->addCC('mail@bidon.fr');

    // affichage du format html
    $mail->isHTML(true);

    // sujet
    $mail->Subject = 'Recuperation de mot de passe';
    // contenu
    $mail->Body = 'Cliquez sur le lien pour pouvoir réinitialiser votre mot de passe </br> <a href="http://localhost/E-comWF3/admin/changementmdp.php?token=' . $token .'">Clique</a>';
    if(!$mail->send()){
        // echec de l'envoi
        // affichage des infos debug
        echo 'Erreur : ' . $mail->ErrorInfo;
    } else {
        ?>
        <div class="alert alert-success" role="alert">
            Message envoyé !
        </div>
        <?php
    }

}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Réinitialisation de mot de passe.</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Récupération de mot de passe</h1>
                <form method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control" name="email_reset" placeholder="Email">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
                <a href="../accueil.php" class="btn btn-warning mt-3">Retour</a>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>