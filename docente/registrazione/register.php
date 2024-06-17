<?php
@include 'config.php'; //connessione al db
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$dip = $_POST['dipartimento'];
$corso = $_POST['corso'];
$pw = $_POST['password'];

$nuovo = "INSERT INTO UTENTE ()";

