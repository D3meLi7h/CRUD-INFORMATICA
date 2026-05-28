<?php
// Include il file per la connessione al database
require_once __DIR__ . '/../php/db.php';

// Query SQL per prendere i libri della categoria "Manuale"
$sql = "SELECT Libri.Titolo, Libri.Descrizione, Libri.Anno_Pubblicazione, Libri.Lingua_Originale, Libri.ISBN, Categorie.Genere_Libro
        FROM Libri
        JOIN Categorie ON Libri.Cod_Categoria = Categorie.Cod_Categoria
        WHERE Categorie.Genere_Libro = 'Manuale'";

// Esegue la query
$result = $conn->query($sql);

// Array dove salvare i libri trovati
$libriManuale = [];

// Variabile per eventuali errori
$errorMessage = null;

// Controlla se la query è andata a buon fine
if ($result) {

    // Prende ogni riga del risultato
    while ($row = $result->fetch_assoc()) {

        // Salva il libro nell'array
        $libriManuale[] = $row;
    }

} else {

    // Salva il messaggio di errore del database
    $errorMessage = $conn->error;
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">

        <!-- Adatta la pagina ai dispositivi mobili -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Manuale</title>

        <!-- Collegamento al file CSS -->
        <link rel="stylesheet" href="../asset/css/generiLibri.css">

        <!-- Collegamenti ai font Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    </head>

    <body>

        <!-- Contenitore principale -->
        <div class="riquadro">

            <!-- Titolo della pagina -->
            <h1 class="titolo">Manuale</h1>

            <!-- Bottone logout -->
            <button class="btnLogout" id="logout">
                <ion-icon name="exit-outline"></ion-icon>
                <span class="nickname"></span>
            </button>

            <!-- Bottone per tornare indietro -->
            <button class="btnIndietro" id="indietro">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </button>

            <!-- Sezione che mostra i libri -->
            <div class="contenuto-libro">

                <?php if ($errorMessage): ?>

                    <!-- Mostra eventuali errori -->
                    <p>Errore database: <?= htmlspecialchars($errorMessage) ?></p>

                <?php elseif (count($libriManuale) === 0): ?>

                    <!-- Messaggio se non ci sono libri -->
                    <p>Nessun libro in categoria Manuale trovato nel database.</p>

                <?php else: ?>

                    <!-- Lista dei libri trovati -->
                    <ul>

                        <?php foreach ($libriManuale as $libro): ?>

                            <li>

                                <!-- Titolo del libro -->
                                <strong><?= htmlspecialchars($libro['Titolo']) ?></strong><br>

                                <!-- Descrizione del libro -->
                                <?= htmlspecialchars($libro['Descrizione']) ?><br>

                                <!-- Informazioni aggiuntive -->
                                Anno: <?= htmlspecialchars($libro['Anno_Pubblicazione']) ?>,

                                Lingua: <?= htmlspecialchars($libro['Lingua_Originale']) ?>,

                                ISBN: <?= htmlspecialchars($libro['ISBN']) ?>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                <?php endif; ?>

            </div>

            <!-- Sottotitolo -->
            <h2 class="sottotitolo">My School Library</h2>

        </div>

        <!-- Script per le icone -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        <!-- Script JavaScript dei bottoni -->
        <script src="../asset/js/bottoniGeneri.js"></script>

    </body>
</html>