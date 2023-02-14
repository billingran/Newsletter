<?php
//commencer la session
session_start();

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$success = null;
$email = '';
$firstname = '';
$lastname = '';
$id_of_interests = [];

// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    // On récupère l'origine
    $original_id = $_POST['original_id'];

    // On récupère l'intérêt
    $id_of_interests = isset($_POST['interest']) ? $_POST['interest'] : [];

    $errors = validationForm (
        $email,
        $firstname,
        $lastname,
        $id_of_interests
    );
    
    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {
        
        if($_POST['form_token'] == $_SESSION['form_token']) {

            // Ajout de l'email dans le fichier csv et On récupère id d'abonné
            $subcribers_id = addSubscriber($email, $firstname, $lastname, $original_id);
            $subscriber_id = $subcribers_id[0]['id'];
            
            // Ajout des centres d’intérêts et id d'abonné
            addinterest($subscriber_id, $id_of_interests);

            // Ajout d'un message flash en session
            $_SESSION['successMessage'] = 'Merci de votre inscription.';

            // Redirection vers l'index.php mais sans les données du formulaire
            header('Location: index.php');
            exit;
        }

        unset($_SESSION['form_token']);

        header('Location: index.php');
        exit;
    } 
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection des centres d’intérêt
$interests = getAllinterests();

// Sélection de la liste des origines
$origins = getAllOrigins();

if (array_key_exists('successMessage', $_SESSION) && $_SESSION['successMessage']) {
    
    // récupèrer le message success dans une variable 
    $success = $_SESSION['successMessage'];

    // effacer de la session
    $_SESSION['successMessage'] = null;
}

// Inclusion du template
include 'index.phtml';


