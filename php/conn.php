<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "biblioteca_scolastica";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Errore connessione: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>