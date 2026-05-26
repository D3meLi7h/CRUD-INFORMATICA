<?php
// ==========================================================
// CONNESSIONE DATABASE (PDO)
// ==========================================================

$host = "localhost";
$db = "Biblioteca_DB";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore connessione: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Libreria Online</title>
    <style>
        body { font-family: Arial; margin:0; background:#f4f4f4; }
        header { background:#2c3e50; color:white; padding:20px; text-align:center; }
        nav { background:#34495e; padding:10px; text-align:center; }
        nav a { color:white; margin:0 15px; text-decoration:none; font-weight:bold; }
        section { padding:20px; }
        table { width:100%; border-collapse:collapse; background:white; }
        th, td { border:1px solid #ddd; padding:10px; text-align:left; }
        th { background:#2c3e50; color:white; }
        .box { background:white; padding:15px; margin-bottom:20px; border-radius:8px; }
    </style>
</head>

<body>

<header>
    <h1>📚 Biblioteca Online</h1>
    <p>Benvenuto nel sistema di gestione della libreria</p>
</header>

<nav>
    <a href="#home">Home</a>
    <a href="#libri">Libri</a>
    <a href="#prestiti">Prestiti</a>
    <a href="#recensioni">Recensioni</a>
</nav>

<section id="home">
    <div class="box">
        <h2>🏠 Home</h2>
        <p>Questo è il sito ufficiale della biblioteca. Qui puoi consultare libri, prestiti e recensioni degli utenti.</p>
    </div>
</section>

<!-- ===================================================== -->
<!-- LIBRI -->
<!-- ===================================================== -->
<section id="libri">
    <div class="box">
        <h2>📖 Elenco Libri</h2>

        <?php
        $stmt = $conn->query("SELECT * FROM Libri");

        echo "<table>
                <tr>
                    <th>Titolo</th>
                    <th>Anno</th>
                    <th>Pagine</th>
                    <th>Lingua</th>
                    <th>Copie</th>
                    <th>Collocazione</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['Titolo']}</td>
                    <td>{$row['Anno_Pubblicazione']}</td>
                    <td>{$row['Numero_Pagine']}</td>
                    <td>{$row['Lingua_Originale']}</td>
                    <td>{$row['Copie_disponibili']}</td>
                    <td>{$row['Collocazione']}</td>
                  </tr>";
        }

        echo "</table>";
        ?>
    </div>
</section>

<!-- ===================================================== -->
<!-- PRESTITI -->
<!-- ===================================================== -->
<section id="prestiti">
    <div class="box">
        <h2>📦 Prestiti Attivi</h2>

        <?php
        $sql = "
        SELECT U.Nome, U.Cognome, L.Titolo, P.Data_Prestito
        FROM Prestiti P
        JOIN Utenti U ON P.ID_Utente = U.ID_Utente
        JOIN Libri L ON P.ID_Libro = L.ID_Libro
        WHERE P.Data_Restituzione IS NULL
        ";

        $stmt = $conn->query($sql);

        echo "<table>
                <tr>
                    <th>Utente</th>
                    <th>Libro</th>
                    <th>Data Prestito</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['Nome']} {$row['Cognome']}</td>
                    <td>{$row['Titolo']}</td>
                    <td>{$row['Data_Prestito']}</td>
                  </tr>";
        }

        echo "</table>";
        ?>
    </div>
</section>

<!-- ===================================================== -->
<!-- RECENSIONI -->
<!-- ===================================================== -->
<section id="recensioni">
    <div class="box">
        <h2>⭐ Recensioni</h2>

        <?php
        $sql = "
        SELECT U.Nome, L.Titolo, R.Voto, R.Testo_Recensione
        FROM Recensioni R
        JOIN Utenti U ON R.ID_Utente = U.ID_Utente
        JOIN Libri L ON R.ID_Libro = L.ID_Libro
        ";

        $stmt = $conn->query($sql);

        echo "<table>
                <tr>
                    <th>Utente</th>
                    <th>Libro</th>
                    <th>Voto</th>
                    <th>Testo</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['Nome']}</td>
                    <td>{$row['Titolo']}</td>
                    <td>{$row['Voto']}/5</td>
                    <td>{$row['Testo_Recensione']}</td>
                  </tr>";
        }

        echo "</table>";
        ?>
    </div>
</section>

</body>
</html>