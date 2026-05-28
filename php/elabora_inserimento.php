<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "Biblioteca_DB";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// DATI FORM
$id_libro    = isset($_POST['id_libro']) ? intval($_POST['id_libro']) : null;
$titolo      = $_POST['titolo'];
$autore      = isset($_POST['id_autore']) ? intval($_POST['id_autore']) : null;
$posizione   = $_POST['posizione'];
$isbn        = $_POST['isbn'];
$anno        = $_POST['anno'];
$pagine      = $_POST['pagine'];
$lingua      = $_POST['lingua'];
$copie       = $_POST['copie'];
$genere      = $_POST['genere'];
$descrizione = $_POST['descrizione'];

// CATEGORIA
$ris = $conn->query("SELECT Cod_Categoria FROM Categorie WHERE Genere_Libro = '$genere'");
if (!$ris || $ris->num_rows === 0) {
    die("Errore: nessuna categoria trovata per il genere '$genere'. Aggiungila prima nella tabella Categorie.");
}
$row = $ris->fetch_assoc();
$cod_categoria = $row['Cod_Categoria'];

// MODIFICA (UPDATE)
if ($id_libro) {
    $sql = "
        UPDATE Libri SET
            Posizione = '$posizione',
            Copie_disponibili = '$copie',
            Titolo = '$titolo',
            Descrizione = '$descrizione',
            Anno_Pubblicazione = '$anno',
            Numero_Pagine = '$pagine',
            Lingua_Originale = '$lingua',
            ISBN = '$isbn',
            Cod_Categoria = '$cod_categoria'
        WHERE ID_Libro = $id_libro
    ";
    if ($conn->query($sql) === TRUE) {
        if ($autore) {
            $conn->query("DELETE FROM Libri_Autori WHERE ID_Libro = $id_libro");
            $conn->query("INSERT INTO Libri_Autori (ID_Libro, ID_Autore) VALUES ($id_libro, $autore)");
        }
        echo "Libro modificato con successo!";
    } else {
        echo "Errore update: " . $conn->error;
    }

// INSERIMENTO (INSERT)
} else {
    $sql = "INSERT INTO Libri 
    (Posizione, Copie_disponibili, Titolo, Descrizione, Anno_Pubblicazione, Numero_Pagine, Lingua_Originale, ISBN, Cod_Categoria)
    VALUES 
    ('$posizione', '$copie', '$titolo', '$descrizione', '$anno', '$pagine', '$lingua', '$isbn', '$cod_categoria')";

    if ($conn->query($sql) === TRUE) {
        $id_libro = $conn->insert_id;
        if ($autore) {
            $conn->query("INSERT INTO Libri_Autori (ID_Libro, ID_Autore) VALUES ($id_libro, $autore)");
        }
        echo "Libro inserito con successo!";
    } else {
        echo "Errore insert: " . $conn->error;
    }
}

$conn->close();
?>