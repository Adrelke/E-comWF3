<?php
session_start(); 

include_once('bdd.php');

if(!empty($_POST)){
    $errors = [];

    if(empty($_POST['nom'])){
        $errors[] = "Merci de renseigner votre nom.";
    }

    if(empty($_POST['email'])){
        $errors[] = "Merci de renseigner votre email.";
    }

    if(empty($_POST['message']) && strlen($_POST['message']) < 20){
        $errors[] = "Votre message doit faire plus de 20 caractères.";
    }

    if(empty($errors)){
        $resultat = $connexion->prepare('INSERT INTO messages(name, email, subject, content) VALUES(:name, :email, :subject, :content)');
        $resultat->bindValue(':name', htmlspecialchars($_POST['nom']));
        $resultat->bindValue(':email', htmlspecialchars($_POST['email']));
        $resultat->bindValue(':subject', htmlspecialchars($_POST['subject']));
        $resultat->bindValue(':content', htmlspecialchars($_POST['message']));
        $resultat->execute();
        header('Location: contact.php?submit');
    } else {
        echo implode('</br>', $errors);
    }

}

if(isset($_GET['submit'])){
    ?>
    <div class="alert alert-success" role="alert">
        Message bien envoyé !
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <title>Contact</title>
</head>
<body>
<?php
include ('header.php');
?>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <h5 class="card-header">Formulaire de Contact</h5>
                <div class="card-body">
                    <form method="post" action="contact.php">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nom</label>
                            <input type="type" name="nom" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                 </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sujet</label>
                            <input type="text" class="form-control" name="subject" id="exampleInputPassword1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Message</label>
                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <h3 class="text-center">Où nous trouver</h3>
            <div id="map" ></div>
        </div>
    </div>
</div>
<br>
<br>
<?php
include ('footer.php');
?>
<script>
    function initMap() {
        var uluru = {lat: 25.728150, lng: -80.242527};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU2lju0zz4JakzKkpX_zMO3KP9hBJb99s&callback=initMap">
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="assets/js/simpleCart.js"></script>
</body>
</html>