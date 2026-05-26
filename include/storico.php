<html>
    <head>
        <title>Libreria</title>
        <link rel="stylesheet" href="../asset/css/generiLibri.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    </head>

<body>

    <!-- Contenitore principale della pagina -->
    <div class="riquadro">

        <!-- Titolo principale della sezione -->
        <h1 class="titolo">Storico</h1>
    
        <!-- Bottone di logout -->
        <button class="btnLogout" id="logout">
            <!-- Icona Ionicons per logout -->
            <ion-icon name="exit-outline"></ion-icon>

            <!-- Inserimento nickname dell'utente nel bottone-->
            <span class="nickname"></span>
        </button>

        <!-- Bottone per tornare alla pagina precedente -->
        <button class="btnIndietro" id="indietro">
            <!-- Icona freccia indietro -->
            <ion-icon name="arrow-back-outline"></ion-icon>
        </button>

        <!-- Sottotitolo della pagina -->
        <h2 class="sottotitolo">My School Library</h2>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../asset/js/bottoniGeneri.js"></script>
</body>

</html>
<?php
$sql = "SELECT * FROM libri join categorie ON libri.Cod_Categoria = categorie.Cod_Categoria WHERE Genere_Libro = 'storico'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Titolo: " . $row["titolo"]. " - Autore: " . $row["autore"]. "<br>";
    }
} else {
    echo "0 risultati";
}
?>