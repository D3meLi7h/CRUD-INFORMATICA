<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// connessione al db
$host     = "localhost";
$user     = "root";
$password = "";
$database = "Biblioteca_DB";

$conn = new mysqli($host, $user, $password, $database);

// controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// dati POST
$nome = trim($_POST['nome']);
$cognome = trim($_POST['cognome']);
$data_nascita = $_POST['data_nascita'];
$genere = $_POST['genere'];
$tipo_utente = $_POST['tipo_utente'];
$indirizzo = trim($_POST['indirizzo']);
$citta = trim($_POST['citta']);
$telefono = trim($_POST['telefono']);
$email = trim($_POST['email']);
$nickname = trim($_POST['nickname']);
$pw = trim($_POST['password']);


// Controllo email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Email non valida");
}

//Controllo password
$errors = [];

if (strlen($pw) < 8) {
    $errors[] = "La password deve essere lunga almeno 8 caratteri.";
}

if (!empty($errors)) {
    foreach ($errors as $e) {
        echo $e . "<br>";
    }
    exit;
}

// HASH PASSWORD (più sicura)
$pw = password_hash($pw, PASSWORD_BCRYPT);


// QUERY SQL
$stmt = $conn->prepare("
    INSERT INTO Utenti
    (Nome, Cognome, Genere, Data_Nascita, Tipo_Utente,
     Indirizzo, Citta, N_Telefono, Email, Nickname, Pw)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssssss",
    $nome,
    $cognome,
    $genere,
    $data_nascita,
    $tipo_utente,
    $indirizzo,
    $citta,
    $telefono,
    $email,
    $nickname,
    $pw
);



// ESECUZIONE
if ($stmt->execute()) {
    header("Location: ../../index.html");
    exit;
} else {
    echo "Errore: " . $stmt->error;
}


// chiusura
$stmt->close();
$conn->close();
?>