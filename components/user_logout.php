<?php
//? Inclure le fichier "connect.php", qui contient le code de connexion à la base de données
include 'connect.php';

//? Démarrer la session
session_start();

//? Effacer toutes les variables de session
session_unset();

//? Détruire la session, en supprimant toutes les données de la session
session_destroy();

//! Rediriger l'utilisateur vers la page 'home.php'
header('location:../home.php');
?>
