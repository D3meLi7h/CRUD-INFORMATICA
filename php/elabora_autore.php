<?php
// 1. Connessione al database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "Biblioteca_DB"; // nome del DB

$conn = new mysqli($host, $username, $password, $dbname);

// 2. Recupero diretto dei dati dal form senza filtri
$nome        = $_POST['nome'];
$cognome     = $_POST['cognome'];
$nazionalita = $_POST['nazionalita'];
$data_nascita = $_POST['data_nascita'];

// Gestione dei campi vuoti opzionali per evitare stringhe vuote nel DB (inserisce NULL se non compilati)
if(empty($nazionalita)) { $nazionalita = NULL; }
if(empty($data_nascita)) { $data_nascita = NULL; }

// 3. Query di inserimento diretta
$sql = "INSERT INTO Autori (Nome, Cognome, Nazionalita, Data_Nascita) 
        VALUES ('$nome', '$cognome', " . ($nazionalita ? "'$nazionalita'" : "NULL") . ", " . ($data_nascita ? "'$data_nascita'" : "NULL") . ")";

// 4. Esecuzione e controllo minimale
if ($conn->query($sql) === TRUE) {
    echo "Autore registrato con successo!";
} else {
    echo "Errore durante l'inserimento: " . $conn->error;
}

// Chiude la connessione
$conn->close();
?>