<?php
//Affichage des informations utilisateurs
//Démarrer la session
session_start();

//Variable d'affichage
$title = "Mon Compte";

//Accessible uniquement si connecté
if(!isset($_SESSION["id"])){
    //non connecté -> redirection vers accueil
    header('Location:index.php');
    exit;
}

include './header.php';
?>

    