<?php
$host = 'localhost';
$dbname = 'Biblioteca_DB';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "successo" => false,
        "messaggio" => "Connessione al DB fallita: " . $conn->connect_error
    ]));
}
?>