<?php

require "../php/db.php";

// Modalità modifica o creazione
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$libro = null;
$genere_attuale = '';
$autore_attuale = null;

if ($id) {
    $res = $conn->query("SELECT * FROM Libri WHERE ID_Libro = $id");
    if (!$res || $res->num_rows === 0) die("Libro non trovato.");
    $libro = $res->fetch_assoc();

    $resCat = $conn->query("SELECT Genere_Libro FROM Categorie WHERE Cod_Categoria = " . $libro['Cod_Categoria']);
    $genere_attuale = $resCat->fetch_assoc()['Genere_Libro'];

    $resA = $conn->query("SELECT ID_Autore FROM Libri_Autori WHERE ID_Libro = $id LIMIT 1");
    $autore_attuale = $resA ? $resA->fetch_assoc()['ID_Autore'] : null;
}

// Query autori
$sql = "SELECT ID_Autore, CONCAT(Nome, ' ', Cognome) AS nome_completo 
        FROM Autori 
        ORDER BY Cognome";

$result = $conn->query($sql);
$autori = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $autori[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">
    <title>Libreria - <?php echo $id ? 'Modifica Libro' : 'Aggiungi Libro'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/crea.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">

</head>

<body>

    <div class="riquadro">

        <h1 class="titolo"><?php echo $id ? 'Modifica libro' : 'Aggiungi libro'; ?></h1>

        <button type="button" class="btnIndietro" id="indietro">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </button>

        <form action="../php/elabora_inserimento.php" method="POST" id="form-libro">

            <?php if ($id): ?>
                <input type="hidden" name="id_libro" value="<?php echo $id; ?>">
            <?php endif; ?>

            <!-- Titolo -->
            <div class="input-box">
                <label for="titolo">Titolo*</label>
                <input type="text" id="titolo" name="titolo" maxlength="100"
                       value="<?php echo $libro ? htmlspecialchars($libro['Titolo']) : ''; ?>" required>
            </div>

            <!-- Autore -->
            <div class="input-box">
                <label for="id_autore">Autore*</label>

                <select id="id_autore" name="id_autore" required>

                    <option value="" disabled <?php echo !$autore_attuale ? 'selected' : ''; ?>>Seleziona un autore</option>

                    <?php if (count($autori) === 0): ?>
                        <option value="" disabled>Nessun autore disponibile</option>
                    <?php else: ?>
                        <?php foreach($autori as $a): ?>
                            <option value="<?php echo $a['ID_Autore']; ?>"
                                <?php echo ($a['ID_Autore'] == $autore_attuale) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($a['nome_completo']); ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="0" <?php echo ($autore_attuale === 0) ? 'selected' : ''; ?>>Sconosciuto</option>
                    <?php endif; ?>

                </select>

                <a href="../include/crea_autore.html" class="link-crea-autore">
                    Non trovi l'autore? Crealo qui
                </a>

            </div>

            <!-- Posizione -->
            <div class="input-box">
                <label for="posizione">Posizione*</label>
                <input type="text" id="posizione" name="posizione" maxlength="20" placeholder="es. A1"
                       value="<?php echo $libro ? htmlspecialchars($libro['Posizione']) : ''; ?>" required>
            </div>

            <!-- ISBN -->
            <div class="input-box">
                <label for="isbn">ISBN*</label>
                <input type="text" id="isbn" name="isbn" maxlength="17"
                       value="<?php echo $libro ? htmlspecialchars($libro['ISBN']) : ''; ?>" required>
            </div>

            <!-- Anno -->
            <div class="input-box">
                <label for="anno">Anno di pubblicazione*</label>
                <input type="number" id="anno" name="anno" min="1000" max="2100"
                       value="<?php echo $libro ? $libro['Anno_Pubblicazione'] : ''; ?>" required>
            </div>

            <!-- Pagine -->
            <div class="input-box">
                <label for="pagine">Numero di pagine*</label>
                <input type="number" id="pagine" name="pagine" min="1"
                       value="<?php echo $libro ? $libro['Numero_Pagine'] : ''; ?>" required>
            </div>

            <!-- Lingua -->
            <div class="input-box">
                <label for="lingua">Lingua originale*</label>
                <input type="text" id="lingua" name="lingua" maxlength="30" placeholder="es. Italiano"
                       value="<?php echo $libro ? htmlspecialchars($libro['Lingua_Originale']) : ''; ?>" required>
            </div>

            <!-- Copie -->
            <div class="input-box">
                <label for="copie">Copie disponibili</label>
                <input type="number" id="copie" name="copie" min="0"
                       value="<?php echo $libro ? $libro['Copie_disponibili'] : 1; ?>">
            </div>

            <!-- Genere -->
            <div class="input-box">
                <label for="genere">Genere*</label>

                <select class="genere" id="genere" name="genere" required>

                    <option value="" disabled <?php echo !$genere_attuale ? 'selected' : ''; ?>>Seleziona un genere</option>

                    <?php
                    $generi = ['Narrativa','Saggio','Manuale','Storico','Fantascienza','Horror','Giallo','Altro'];
                    foreach($generi as $g): ?>
                        <option value="<?php echo $g; ?>" <?php echo ($g === $genere_attuale) ? 'selected' : ''; ?>>
                            <?php echo $g; ?>
                        </option>
                    <?php endforeach; ?>

                </select>

            </div>

            <!-- Descrizione -->
            <div class="input-box">
                <label for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" rows="3"
                          placeholder="Breve descrizione del libro..."><?php echo $libro ? htmlspecialchars($libro['Descrizione']) : ''; ?></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="invio" id="invio">
                <ion-icon name="checkmark-outline"></ion-icon>
            </button>

        </form>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../asset/js/crea.js"></script>

</body>
</html>