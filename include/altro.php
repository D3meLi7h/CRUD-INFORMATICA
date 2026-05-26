<?php
require_once __DIR__ . '/../php/db.php';

$sql = "SELECT Libri.Titolo, Libri.Descrizione, Libri.Anno_Pubblicazione, Libri.Lingua_Originale, Libri.ISBN, Categorie.Genere_Libro
        FROM Libri
        JOIN Categorie ON Libri.Cod_Categoria = Categorie.Cod_Categoria
        WHERE Categorie.Genere_Libro = 'Altro'";

$result = $conn->query($sql);
$libriAltro = [];
$errorMessage = null;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $libriAltro[] = $row;
    }
} else {
    $errorMessage = $conn->error;
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Altro</title>
        <link rel="stylesheet" href="../asset/css/generiLibri.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="riquadro">
            <h1 class="titolo">Altro</h1>
            <button class="btnLogout" id="logout">
                <ion-icon name="exit-outline"></ion-icon>
                <span class="nickname"></span>
            </button>
            <button class="btnIndietro" id="indietro">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </button>
            <h2 class="sottotitolo">My School Library</h2>

            <div class="contenuto-libro">
                <?php if ($errorMessage): ?>

                <p>Errore database: <?= htmlspecialchars($errorMessage) ?></p>
            <?php elseif (count($libriAltro) === 0): ?>
                <p>Nessun libro in categoria Altro trovato nel database.</p>
            <?php else: ?>
                <h3>Libri nella categoria Altro</h3>
                <ul>
                    <?php foreach ($libriAltro as $libro): ?>
                        <li>
                            <strong><?= htmlspecialchars($libro['Titolo']) ?></strong><br>
                            <?= htmlspecialchars($libro['Descrizione']) ?><br>
                            Anno: <?= htmlspecialchars($libro['Anno_Pubblicazione']) ?>, Lingua: <?= htmlspecialchars($libro['Lingua_Originale']) ?>, ISBN: <?= htmlspecialchars($libro['ISBN']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="../asset/js/bottoniGeneri.js"></script>
    </body>
</html>