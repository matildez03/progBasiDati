<?php
//accesso al db ESQL-ESERCIZI
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db_host = 'localhost'; // Nome del server
$db_user = 'root';      // Nome utente amministratore database
$db_password = 'root';  // Password database
$db_nomedb = 'ESQL - ESERCIZI';   // Nome database

// Effettua la connessione al database
$esdb = new mysqli($db_host, $db_user, $db_password, $db_nomedb);

if ($esdb->connect_error) {
    die('Errore di connessione (' . $esdb->connect_errno . ') ' . $esdb->connect_error);
}
echo 'connessione a ESDB esercizi effettuata';
?>
