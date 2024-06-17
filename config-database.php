<?php
/*
 * file di connessione al database, per l'accesso alla tabella utente per effettuare l'accesso
 */
session_start();
$db_host = 'localhost'; // Nome del server
$db_user = 'root';      // Nome utente amministratore database
$db_password = 'root';  // Password database
$db_nomedb = 'ESQL';   // Nome database

// Effettua la connessione al database
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_nomedb) or die ('Errore nella stringa di connessione al database: '.mysqli_error());

//Lettura Tabella utente
$query1 = $mysqli->query("SELECT * FROM utente");
$riga2 = mysqli_fetch_array($query1);
?>
