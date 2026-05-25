<?php
    // Imposta il tipo di risposta come JSON
    header('Content-Type: application/json');

    // Include il file di connessione al database
    include "php/db.php";

    // Legge i dati inviati dal client in formato JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Recupera nickname e password dai dati ricevuti
    // Se non esistono, assegna una stringa vuota
    $nickname = $data['nickname'] ?? '';
    $password = $data['password'] ?? '';

    // Controlla se nickname o password sono vuoti
    if ($nickname === '' || $password === '')
    {

        // Restituisce un messaggio di errore in formato JSON
        echo json_encode
        ([
            "successo" => false,
            "messaggio" => "Compila tutti i campi"
        ]);

        // Interrompe l'esecuzione dello script
        exit;
    }

    // Query SQL per cercare un utente con il nickname inserito
    $sql = "SELECT * FROM Utenti WHERE Nickname = ? LIMIT 1";

    // Prepara la query per evitare SQL Injection
    $stmt = $conn->prepare($sql);

    // Collega il parametro alla query
    // "s" indica che il parametro è una stringa
    $stmt->bind_param("s", $nickname);

    // Esegue la query
    $stmt->execute();

    // Ottiene il risultato della query
    $result = $stmt->get_result();

    // Controlla se non esiste nessun utente con quel nickname
    if ($result->num_rows === 0)
    {

        // Restituisce errore
        echo json_encode
        ([
            "successo" => false,
            "messaggio" => "Nome utente errato o non esistente."
        ]);

        exit;
    }

    // Recupera i dati dell'utente trovato come array associativo
    $utente = $result->fetch_assoc();

    // Controlla se la password inserita è diversa da quella salvata nel database
    if ($password !== $utente['Pw'])
    {

        // Restituisce errore password
        echo json_encode
        ([
            "successo" => false,
            "messaggio" => "Password errata."
        ]);

        // Interrompe lo script
        exit;
    }

    // Se login corretto, restituisce successo e nickname utente
    echo json_encode
    ([
        "successo" => true,
        "nickname" => $utente['Nickname']
    ]);

?>
