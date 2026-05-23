<?php
    ini_set('display_errors', 1); // mostra gli errori a schermo
    error_reporting(E_ALL);       // mostra tutti gli errori

    // connessione al db
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $database = "Biblioteca_DB";

    // connessione al database
    $conn = new mysqli($host, $user, $password, $database);

    // prendere dati dal form con post
    $nome = trim($_POST['nome']); // trim per eliminare spazi
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

    // query sql
    $stmt = $conn->prepare
    ("
        INSERT INTO Utenti
        (Nome, Cognome, Genere, Data_Nascita, Tipo_Utente,
        Indirizzo, Citta, N_Telefono, Email, Nickname, Pw)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // collegamento dei valori ai segnaposto ?
    $stmt->bind_param
    (
        "sssssssssss", // tutte stringhe
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

    // ESECUZIONE QUERY
    if ($stmt->execute())
    {
        // se va tutto bene torna alla home
        header("Location: ../index.html");
        exit;
    }
    
    else
    {
        // se c'è un errore lo stampa
        echo "Errore: " . $stmt->error;
    }

    // chiusura statement e connessione
    $stmt->close();
    $conn->close();
?>

