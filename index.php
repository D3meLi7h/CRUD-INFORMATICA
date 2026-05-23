<?php
    header('Content-Type: application/json');
    include "asset/php/db.php"; // ← path corretto

    $data = json_decode(file_get_contents("php://input"), true);

    $nickname = $data['nickname'] ?? '';
    $password = $data['password'] ?? '';

    if ($nickname === '' || $password === '') {
        echo json_encode([
            "successo" => false,
            "messaggio" => "Compila tutti i campi"
        ]);
        exit;
    }

    $sql = "SELECT * FROM Utenti WHERE Nickname = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            "successo" => false,
            "messaggio" => "Nome utente errato o non esistente."
        ]);
        exit;
    }

    $utente = $result->fetch_assoc();

    if ($password !== $utente['Pw']) {
        echo json_encode([
            "successo" => false,
            "messaggio" => "Password errata."
        ]);
        exit;
    }

    echo json_encode([
        "successo" => true,
        "nickname" => $utente['Nickname']
    ]);
?>
