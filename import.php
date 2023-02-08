<?php 
// Inclusion des dépendances
require 'config.php';

$filename = $argv[1];

if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit; // On arrête l'exécution du script
} else {
    $file = fopen($filename, "r");


    // Construction du Data Source Name
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

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

    $query->execute([$email, $firstname, $lastname]);

}
    echo $success  = 'votre données a été inséré avec succès';
}

?>