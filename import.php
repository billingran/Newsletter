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

    $pdo = getToDb ();

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscribers
            (date_time, email, firstname, lastname) 
            VALUES (Now() ,?,?,?)';

    $query = $pdo->prepare($sql);


    while ($row = fgetcsv($file)) {
        
    $firstname = ucfirst(strtolower($row[0])); 

    $lastname = ucfirst(strtolower($row[1]));

    $email = strtolower($row[2]);
    $email = str_replace(" ", "", $email);

    if (!emailExists($email)) {
            $query->execute([$email, $firstname, $lastname]);
        } else {
            exit;
        }
    }
    echo $success  = 'Vos données ont été insérées avec succès';
}

?>


