<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

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

    // On récupère l'intérêt
    $id_of_interests = isset($_POST['interest']) ? $_POST['interest'] : 0;

    $errors = validationForm (
            $email,
            $firstname,
            $lastname,
            $id_of_interests
    );

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv et On récupère id d'abonné
        $subcribers_id = addSubscriber($email, $firstname, $lastname, $original_id);
        $subscriber_id = $subcribers_id[0]['id'];

        // Ajout des centres d’intérêts et id d'abonné
        addinterest($subscriber_id, $id_of_interests);

        // Message de succès
        $success  = 'Merci de votre inscription';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$interests = getAllinterests();
$origins = getAllOrigins();

// Inclusion du template
include 'index.phtml';


