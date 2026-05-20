<?php
$conn = new mysqli("localhost", "root", "", "libreria");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$nickname = $_POST['nickname'];
$password = $_POST['password'];

$sql = "SELECT * FROM Utenti WHERE Nome='$nickname' AND Pw='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Login riuscito!";
} else {
    echo "Credenziali errate!";
}

$conn->close();
?>