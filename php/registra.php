<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// connessione al db
$host     = "localhost";
$user     = "root";
$db_pass  = "";
$database = "Biblioteca_DB";

$conn = new mysqli($host, $user, $db_pass, $database);

// controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// recupero dati POST
$nome = trim($_POST['nome'] ?? '');
$cognome = trim($_POST['cognome'] ?? '');
$data_nascita = $_POST['data_nascita'] ?? '';
$genere = $_POST['genere'] ?? '';
$tipo_utente = $_POST['tipo_utente'] ?? '';
$indirizzo = trim($_POST['indirizzo'] ?? '');
$citta = trim($_POST['citta'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$nickname = trim($_POST['nickname'] ?? '');
$password = trim($_POST['password'] ?? '');

// controlli base
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Email non valida");
}

if (strlen($password) < 8) {
    exit("La password deve essere lunga almeno 8 caratteri.");
}

// hash password
//$password_hash = password_hash($password, PASSWORD_BCRYPT);

// query SQL
$stmt = $conn->prepare("
    INSERT INTO Utenti
    (Nome, Cognome, Genere, Data_Nascita, Tipo_Utente,
     Indirizzo, Citta, N_Telefono, Email, Nickname, Pw)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Errore prepare: " . $conn->error);
}

// bind parametri
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
    $password
);

// esecuzione
if ($stmt->execute()) {
    header("Location: ../index.html");
    exit;
} else {
    echo "Errore inserimento: " . $stmt->error;
}

// chiusura
$stmt->close();
$conn->close();
?>