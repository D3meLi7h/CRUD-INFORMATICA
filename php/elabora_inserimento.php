<?php
// 1. Connessione al database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "Biblioteca_DB"; // nome del DB

$conn = new mysqli($host, $username, $password, $dbname);

// 2. Recupero diretto dei dati dal form senza filtri
$titolo      = $_POST['titolo'];
$autore      = isset($_POST['id_autore']) ? intval($_POST['id_autore']) : null; // ID autore selezionato
$posizione   = $_POST['posizione'];
$isbn        = $_POST['isbn'];
$anno        = $_POST['anno'];
$pagine      = $_POST['pagine'];
$lingua      = $_POST['lingua'];
$copie       = $_POST['copie'];
$genere_testo = $_POST['genere'];
$descrizione = $_POST['descrizione'];

// 3. Recupero immediato del Cod_Categoria tramite il nome del genere
$risultato_cat = $conn->query("SELECT Cod_Categoria FROM Categorie WHERE Genere_Libro = '$genere_testo'");
$riga_cat = $risultato_cat->fetch_assoc();
$cod_categoria = $riga_cat['Cod_Categoria'];

// 4. Query di inserimento diretta
$sql = "INSERT INTO Libri (Posizione, Copie_disponibili, Titolo, Descrizione, Anno_Pubblicazione, Numero_Pagine, Lingua_Originale, ISBN, Cod_Categoria) 
        VALUES ('$posizione', '$copie', '$titolo', '$descrizione', '$anno', '$pagine', '$lingua', '$isbn', '$cod_categoria')";

// 5. Esecuzione e controllo minimale
if ($conn->query($sql) === TRUE) {
    $id_libro = $conn->insert_id;
    if ($autore) {
        $sql_rel = "INSERT INTO Libri_Autori (ID_Libro, ID_Autore) VALUES ($id_libro, $autore)";
        if ($conn->query($sql_rel) !== TRUE) {
            echo "Libro inserito ma errore relazione autore-libro: " . $conn->error;
            $conn->close();
            exit;
        }
    }
    echo "Libro inserito con successo!";
} else {
    echo "Errore durante l'inserimento: " . $conn->error;
}

// Chiude la connessione
$conn->close();
?>