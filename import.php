<?php 
// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$filename = $argv[1];

if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit; // On arrête l'exécution du script
} else {
    $file = fopen($filename, "r");
    csvHandler ($file);//Insérer csv fichier dans la base de données d’abonnés
    echo $success  = 'Vos données ont été insérées avec succès';
}

?>


