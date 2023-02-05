<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$prenom = '';
$nom = '';

// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);

    // On récupère l'origine
    $origineSelectionnee = $_POST['origine'];

    // Validation 
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    }

    if (!$prenom) {
        $errors['prenom'] = "Merci d'indiquer un prénom";
    }

    if (!$nom) {
        $errors['nom'] = "Merci d'indiquer un nom";
    }

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addSubscriber($email, $prenom, $nom, $origineSelectionnee);

        // Message de succès
        $success  = 'Merci de votre inscription';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();

// Inclusion du template
include 'index.phtml';
