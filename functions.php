<?php
/**
 * connexion à la base de données
 */
function getToDb () 
{
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

    return $pdo;
}

/**
 * Récupère tous les intérêts de la table "interests"
 */
function getAllinterests()
{
    $pdo = getToDb ();

    $sql = 'SELECT *
            FROM interests
            ORDER BY interest';

    $query = $pdo->prepare($sql);

    $query->execute();

    return $query->fetchAll();
}


/**
 * Récupère tous les enregistrements de la table origins
 */
function getAllOrigins()
{
    $pdo = getToDb ();

    $sql = 'SELECT *
            FROM origins
            ORDER BY original_label';

    $query = $pdo->prepare($sql);

    $query->execute();

    return $query->fetchAll();
}


/**
 * Ajoute un abonné à la liste des emails
 */
function addSubscriber(string $email, string $firstname, string $lastname, int $original_Id)
{
    $pdo = getToDb ();

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscribers
            (email, firstname, lastname, original_id, date_time) 
            VALUES (?,?,?,?, NOW())';

    $query = $pdo->prepare($sql);

    $query->execute([$email, $firstname, $lastname, $original_Id]);

    // récupèrer id de l'abonné
    $subscribers_table = "SELECT *
    FROM subscribers WHERE Id=(SELECT LAST_INSERT_ID())";

    $subscribers_query = $pdo->prepare($subscribers_table);

    $subscribers_query->execute();

    return $subscribers_query->fetchAll();
}

/**
 * Ajoute un centres d’intérêts et id de la base de données "subscribers"
 */
function addinterest(int $subscriber_id, array $id_of_interests)
{
    $pdo = getToDb ();

    // Insertion de centres d’intérêts et id d'abonné
    foreach ($id_of_interests as $id_of_interest) {

        $sql = 'INSERT INTO subscribers_interests
        (subscribers_id, interests_id) 
        VALUES (?,?)';


        $query = $pdo->prepare($sql);

        $query->execute([$subscriber_id, $id_of_interest]);

    }
}

/**
 * Vérifie si l'email existe dans la base de données "subscribers"
 */
function emailExists(string $email): bool
{
    $pdo = getToDb ();

    $sql = 'SELECT * FROM subscribers';

    $query = $pdo->prepare($sql);
    $query->execute();

    $subscribers= $query->fetchAll();

    foreach ($subscribers as $subscriber) {
        if($subscriber['email'] == $email) {
            return true;
        }
    }

    return false;
}

/**
 * Validation de formulaire
 */
function validationForm (
    string $email,
    string $firstname,
    string $lastname,
    array $id_of_interests
):array {

    $errors = [];

    // Validation 
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Veuillez remplir un email valide';
    } elseif (emailExists($email)) {
        $errors['email'] = "Un compte existe déjà avec cet email";
    }

    if (!$firstname) {
        $errors['firstname'] = "Merci d'indiquer un prénom";
    }

    if (!$lastname) {
        $errors['lastname'] = "Merci d'indiquer un nom";
    }

    if (!$id_of_interests) {
        $errors['interest'] = "Merci de choisir au moins un centre d’intérêt";
    }

    return $errors;
}

/**
 * Récupère tous les intérêts de la table "interests"
 */
function getAllsubscribers()
{
    $pdo = getToDb ();

    $sql = 'SELECT *
            FROM subscribers';

    $query = $pdo->prepare($sql);

    $query->execute();

    return $query->fetchAll();
}

/**
 * Insérer csv fichier dans la base de données d’abonnés
 */
function csvHandler ($file) 
{ 
    $pdo = getToDb ();

    // Insertion du fichier CSV dans la table subscribers
    $sql = 'INSERT INTO subscribers
            (date_time, email, firstname, lastname) 
            VALUES (Now() ,?,?,?)';

    $query = $pdo->prepare($sql);

    $savedMail = 0;

    $unsavedMail = 0;

    while ($row = fgetcsv($file)) {
        
    $firstname = ucfirst(strtolower($row[0])); 

    $lastname = ucfirst(strtolower($row[1]));

    $email = strtolower($row[2]);
    $email = str_replace(" ", "", $email);

    // Vérifier si l'email du fichier CSV existe dans la base de données "subscribers"
        
    if (emailExists($email)) {
            $unsavedMail++;
            continue;
        } else {
            $savedMail++;
            $query->execute([$email, $firstname, $lastname]);
        }
    }

    if ($unsavedMail > 0 && $savedMail == 0) {
        echo "Les adresses email sont déjà présentes";
    } elseif ($unsavedMail > 0 && $savedMail > 0) {
        echo $success  = "Les adresses email sont déjà présentes, {$savedMail} emails ont réellement été ajoutés";
    } elseif ($unsavedMail == 0 && $savedMail > 0) {
        echo $success  = 'Vos données ont été insérées avec succès';
    }
}