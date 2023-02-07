<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';

// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    // On récupère l'origine
    $original_id = $_POST['original_id'];

    // Validation 
    if (!$email) {
        $errors['email'] = "Fill in an email address, please.";
    }

    if (!$firstname) {
        $errors['firstname'] = "Fill in your firstname, please.";
    }

    if (!$lastname) {
        $errors['lastname'] = "Fill in your lastname, please.";
    }

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addSubscriber($email, $firstname, $lastname, $original_id);

        // Message de succès
        $success  = 'Thank you for subscribing';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();

// Inclusion du template
include 'index.phtml';
