<?php
require "../php/db.php";
$sql = "SELECT ID_Autore, CONCAT(Nome, ' ', Cognome) AS nome_completo FROM Autori ORDER BY Cognome";
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
    <title>Libreria - Aggiungi Libro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/crea.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>

<body>

    <div class="riquadro">
        <h1 class="titolo">Aggiungi libro</h1>

        <button type="button" class="btnIndietro" id="indietro">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </button>

        <form action="../php/elabora_inserimento.php" method="POST" id="form-libro">

            <div class="input-box">
                <label for="titolo">Titolo*</label>
                <input type="text" id="titolo" name="titolo" maxlength="100" required>
            </div>

            <div class="input-box">
                <label for="id_autore">Autore*</label>
                <select id="id_autore" name="id_autore" required>
                    <option value="" disabled selected>Seleziona un autore</option>
                    <?php if (count($autori) === 0): ?>
                        <option value="" disabled>Nessun autore disponibile</option>
                    <?php else: ?>
                        <?php foreach($autori as $a): ?>
                            <option value="<?php echo $a['ID_Autore']; ?>"><?php echo htmlspecialchars($a['nome_completo']); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="input-box">
                <label for="posizione">Posizione*</label>
                <input type="text" id="posizione" name="posizione" maxlength="20" placeholder="es. A1" required>
            </div>

            <div class="input-box">
                <label for="isbn">ISBN*</label>
                <input type="text" id="isbn" name="isbn" maxlength="17" required>
            </div>

            <div class="input-box">
                <label for="anno">Anno di pubblicazione*</label>
                <input type="number" id="anno" name="anno" min="1000" max="2100" required>
            </div>

            <div class="input-box">
                <label for="pagine">Numero di pagine*</label>
                <input type="number" id="pagine" name="pagine" min="1" required>
            </div>

            <div class="input-box">
                <label for="lingua">Lingua originale*</label>
                <input type="text" id="lingua" name="lingua" maxlength="30" placeholder="es. Italiano" required>
            </div>

            <div class="input-box">
                <label for="copie">Copie disponibili</label>
                <input type="number" id="copie" name="copie" min="0" value="1">
            </div>

            <div class="input-box">
                <label for="genere">Genere*</label>
                <select class="genere" id="genere" name="genere" required>
                    <option value="" disabled selected>Seleziona un genere</option>
                    <option value="Narrativa">Narrativa</option>
                    <option value="Saggio">Saggio</option>
                    <option value="Manuale">Manuale</option>
                    <option value="Storico">Storico</option>
                    <option value="Fantascienza">Fantascienza</option>
                    <option value="Horror">Horror</option>
                    <option value="Giallo">Giallo</option>
                    <option value="Altro">Altro</option>
                </select>
            </div>

            <div class="input-box">
                <label for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" rows="3" placeholder="Breve descrizione del libro..."></textarea>
            </div>

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