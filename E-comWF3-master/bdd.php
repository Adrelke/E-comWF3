<?php
try{//pour éviter de donner nos identifiants de connexion en cas d'erreur
    $connexion = new PDO('mysql:host=localhost;dbname=ecomwf3;charset=utf8', 'root', '',
        array(
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
    );
}
catch(Exception $e)
{
    die('Erreur : ' .$e->getMessage());
}

?>