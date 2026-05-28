<?php
require_once __DIR__ . '/../php/db.php';

$sql = "
    SELECT 
        Libri.ID_Libro,
        Libri.Titolo,
        Libri.Descrizione,
        Libri.Anno_Pubblicazione,
        Libri.Lingua_Originale,
        Libri.ISBN,
        Libri.Posizione,
        Libri.Copie_disponibili,
        Libri.Numero_Pagine,
        Categorie.Genere_Libro,

        GROUP_CONCAT(
            CONCAT(Autori.Nome, ' ', Autori.Cognome)
            SEPARATOR ', '
        ) AS Autori,

        ROUND(AVG(Recensioni.Voto), 1) AS Voto_Medio,
        COUNT(Recensioni.ID_Recensione) AS Num_Recensioni

    FROM Libri
    JOIN Categorie ON Libri.Cod_Categoria = Categorie.Cod_Categoria
    LEFT JOIN Libri_Autori ON Libri.ID_Libro = Libri_Autori.ID_Libro
    LEFT JOIN Autori ON Libri_Autori.ID_Autore = Autori.ID_Autore
    LEFT JOIN Recensioni ON Libri.ID_Libro = Recensioni.ID_Libro
    WHERE Categorie.Genere_Libro = 'Storico'
    GROUP BY Libri.ID_Libro
";

$result = $conn->query($sql);

$libriStorico = [];
$errorMessage = null;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $libriStorico[] = $row;
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
    <title>Storico</title>

    <link rel="stylesheet" href="../asset/css/generiLibri.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>

<body>

<div class="riquadro">

    <h1 class="titolo">Storico</h1>

    <button class="btnLogout" id="logout">
        <ion-icon name="exit-outline"></ion-icon>
        <span class="nickname"></span>
    </button>

    <button class="btnIndietro" id="indietro">
        <ion-icon name="arrow-back-outline"></ion-icon>
    </button>

    <button class="btnAggiungi" id="aggiungi">
        <ion-icon name="add-outline"></ion-icon>
    </button>

    <div class="contenuto-libro">

        <?php if ($errorMessage): ?>
            <p>Errore database: <?= htmlspecialchars($errorMessage) ?></p>

        <?php elseif (count($libriStorico) === 0): ?>
            <p>Nessun libro in categoria Storico trovato nel database.</p>

        <?php else: ?>

            <ul>
                <?php foreach ($libriStorico as $libro): ?>
                    <li>

                        <div class="card-libro"

                            data-id="<?= $libro['ID_Libro'] ?>"

                            data-titolo="<?= htmlspecialchars($libro['Titolo']) ?>"
                            data-autore="<?= htmlspecialchars($libro['Autori'] ) ?>"
                            data-descrizione="<?= htmlspecialchars($libro['Descrizione']) ?>"
                            data-anno="<?= htmlspecialchars($libro['Anno_Pubblicazione']) ?>"
                            data-lingua="<?= htmlspecialchars($libro['Lingua_Originale']) ?>"
                            data-isbn="<?= htmlspecialchars($libro['ISBN']) ?>"
                            data-posizione="<?= htmlspecialchars($libro['Posizione']) ?>"
                            data-copie="<?= $libro['Copie_disponibili'] ?>"
                            data-pagine="<?= $libro['Numero_Pagine'] ?>"
                            data-voto="<?= $libro['Voto_Medio'] ?? 0 ?>"
                            data-numrec="<?= $libro['Num_Recensioni'] ?? 0 ?>"
                        >

                            <div class="titolo-libro">
                                <?= htmlspecialchars($libro['Titolo']) ?>
                            </div>

                            <div class="autore-libro">
                                <ion-icon name="create-outline"></ion-icon>
                                <?= htmlspecialchars($libro['Autori'] ) ?>
                            </div>

                            <div class="anno-libro">
                                <?= htmlspecialchars($libro['Anno_Pubblicazione']) ?>
                            </div>

                            <div class="badge-copie <?= $libro['Copie_disponibili'] == 0 ? 'esaurito' : '' ?>">
                                <ion-icon name="<?= $libro['Copie_disponibili'] > 0 ? 'checkmark-circle-outline' : 'close-circle-outline' ?>"></ion-icon>

                                <?= $libro['Copie_disponibili'] > 0
                                    ? $libro['Copie_disponibili'] . ' cop. disponibili'
                                    : 'Non disponibile' ?>
                            </div>

                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

    </div>

    <h2 class="sottotitolo">My School Library</h2>
</div>

<!-- POPUP -->
<div class="popup" id="popup">

    <button class="btnChiudi" id="btnChiudi">
        <ion-icon name="close-outline"></ion-icon>
    </button>

    <button class="btnDelete" id="btnDelete">
        <ion-icon name="trash-outline"></ion-icon>
    </button>

    <h2 id="det-titolo"></h2>

    <p class="det-autore">
        <span id="autore"></span>
    </p>

    <p class="det-descrizione" id="det-descrizione"></p>

    <div class="griglia-info">

        <div><span>Anno</span><div class="cella"><strong id="det-anno"></strong></div></div>
        <div><span>Lingua</span><div class="cella"><strong id="det-lingua"></strong></div></div>
        <div><span>Pagine</span><div class="cella"><strong id="det-pagine"></strong></div></div>
        <div><span>Posizione</span><div class="cella"><strong id="det-posizione"></strong></div></div>
        <div><span>ISBN</span><div class="cella"><strong id="det-isbn"></strong></div></div>
        <div><span>Copie</span><div class="cella"><strong id="det-copie"></strong></div></div>

    </div>

    <div class="voto-stelle" id="det-stelle"></div>

    <p class="num-recensioni" id="det-numrec"></p>

    <button class="btnImp" id="btnImp">
        <ion-icon name="settings-outline"></ion-icon>
    </button>

</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script src="../asset/js/bottoniGeneri.js"></script>

</body>
</html>