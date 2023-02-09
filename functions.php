<?php
/**
 * Récupère tous les enregistrements de la table origins
 */
function getAllinterests()
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
            (email, firstname, lastname, original_id, date_time) 
            VALUES (?,?,?,?, NOW())';

    $query = $pdo->prepare($sql);
    $query->execute([$email, $firstname, $lastname, $original_Id]);

    // récupère id de l'abonné
    $subscribers_table = "SELECT *
            FROM subscribers WHERE Id=(SELECT LAST_INSERT_ID())";

    $subscribers_query = $pdo->prepare($subscribers_table);
    $subscribers_query->execute();

    return $subscribers_query->fetchAll();
}

/**
 * Ajoute un centres d’intérêts et id d'abonné
 */
function addinterest(int $subscriber_id, array $id_of_interests)
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

    // Insertion de centres d’intérêts et id d'abonné
    foreach ($id_of_interests as $id_of_interest) {

        $sql = 'INSERT INTO subscribers_interests
        (subscribers_id, interests_id) 
        VALUES (?,?)';


        $query = $pdo->prepare($sql);

        $query->execute([$subscriber_id, $id_of_interest]);

    }
}

    