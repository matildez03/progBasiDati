<?php
session_start();
//prova di accesso al db con le credeniziali date in input

$db_host = 'localhost'; // Nome del server
$db_user = 'root';      // Nome utente amministratore database
$db_password = 'root';  // Password database
$db_nomedb = 'ESQL';   // Nome database

// Effettua la connessione al database
$mydb = new mysqli($db_host, $db_user, $db_password, $db_nomedb);

if ($mydb->connect_error) {
    die('Errore di connessione (' . $mydb->connect_errno . ') ' . $mydb->connect_error);
}
?>