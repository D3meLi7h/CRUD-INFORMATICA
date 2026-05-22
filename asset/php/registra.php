<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CONNESSIONE AL DATABASE
$host     = "localhost";
$user     = "root";
$password = "";
$database = "Biblioteca_DB";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// PRENDO I DATI DAL FORM
$nome         = trim($_POST['nome']);
$cognome      = trim($_POST['cognome']);
$data_nascita = $_POST['data_nascita'];
$genere       = $_POST['genere'];
$tipo_utente  = $_POST['tipo_utente'];
$indirizzo    = trim($_POST['indirizzo']);
$citta        = trim($_POST['citta']);
$telefono     = trim($_POST['telefono']);
$email        = trim($_POST['email']);
$nickname     = trim($_POST['nickname']);
$pw_raw       = $_POST['password'];

// HASH SICURO DELLA PASSWORD
$pw_hash = password_hash($pw_raw, PASSWORD_DEFAULT);
// PREPARO LA QUERY SQL
$stmt = $conn->prepare("
    INSERT INTO Utenti
        (Nome, Cognome, Genere, Data_Nascita, Tipo_Utente,
         Indirizzo, Citta, N_Telefono, Email, Nickname, Pw)
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssssss", //s=string
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
    $pw_hash
);

// ESECUZIONE
if ($stmt->execute()) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Errore: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>