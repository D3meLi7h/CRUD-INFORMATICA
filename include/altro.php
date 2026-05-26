<?php
session_start();

// Controllo login
if (!isset($_SESSION['utente'])) {
    header("Location: login.php");
    exit();
}

$nickname = $_SESSION['utente'];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria</title>

    <link rel="stylesheet" href="/asset/css/altro.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>

<body>

    <div class="riquadro">

        <h1 class="titolo">Altro</h1>

        <!-- LOGOUT -->
        <button class="btnLogout" id="logout">
            <ion-icon name="exit-outline"></ion-icon>

            <!-- Nickname preso dal PHP -->
            <span class="nickname">
                <?php echo htmlspecialchars($nickname); ?>
            </span>
        </button>

        <!-- BOTTONE PAGINA PRECEDENTE -->
        <button class="btnIndietro" id="indietro">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </button>

        <h2 class="sottotitolo">My Personal Library</h2>

        <!-- AUDIO -->
        <audio id="audio" src="/asset/audio/altro.mp3" autoplay loop></audio>

        <button class="btnAudio" id="btnAudio">
            <ion-icon id="audioIcon" name="volume-high-outline"></ion-icon>
        </button>

    </div>

    <!-- SCRIPT -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="/asset/js/altro.js"></script>

</body>

</html>