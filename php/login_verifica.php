<?php
session_start();


// DATI INSERITI
$username = $_POST['username'];
$password = $_POST['password'];

//controllo al database
//select su utenti where password. username = a quelli che stiamo passando
require "conn.php";
$sql= "select ID_Utente from utenti where username= '$username' and pw= '$password'";
$result = $conn->query($sql);
if($result->num_rows()>0)
{
    echo("utente esistente login effettuato");
}
else
    {
    echo("login non effettuato");
    }
?>