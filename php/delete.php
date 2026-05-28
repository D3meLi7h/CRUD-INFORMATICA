<?php
require_once __DIR__ . '/../php/db.php';

if (!isset($conn)) {
    die("Errore: connessione DB non disponibile");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo "ID mancante";
        exit;
    }

    // Elimina prima le righe collegate (no CASCADE su Prestiti e Recensioni)
    $conn->query("DELETE FROM Recensioni WHERE ID_Libro = $id");
    $conn->query("DELETE FROM Prestiti WHERE ID_Libro = $id");

    $stmt = $conn->prepare("DELETE FROM Libri WHERE ID_Libro = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Libro eliminato con successo";
    } else {
        http_response_code(500);
        echo "Errore: " . $stmt->error;
    }
}