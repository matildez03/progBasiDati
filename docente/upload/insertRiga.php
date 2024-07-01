<?php
/*
 * file per inserire una nuova riga nella tabella di esercizio
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require('../config-esercizi.php'); //connessione al db di esercizio $esdb
require('../../config.php'); //connessione al db principale $mydb

//ricavo i dati da aggingere passati in post

$tab = $_POST['tabella'];
$values = $_POST['value'];
$types = $_POST['types'];  //array di tipi di dati corrispondenti
$attributi = $_POST['attributi'];
$colonne = implode(', ', $attributi);

$processed_values = array();
for($i=0; $i<count($values); $i++){
    $value = $values[$i];
    $type= $types[$i];
    if ($type == 'text' || $type == 'varchar' || $type == 'date') {
        // Aggiungo le virgolette singole per i tipi di dati stringa e data
        $processed_values[] = "'" . $value . "'";
    } else {
        // Per gli altri tipi di dati (int), assicurati che siano numerici
        $processed_values[] = $value;
    }
}
$valori = implode(', ', $processed_values); //creo una stringa con i valori separati da virgole
//echo $valori;

// Prima query con prepared statement
$stmt1 = $esdb->prepare("INSERT INTO $tab ($colonne) VALUES ($valori)");
if (!$stmt1) {
    die("Preparazione della query 1 fallita: " . $esdb->error);
}

if (!$stmt1->execute()) {
    die("Esecuzione della query 1 fallita: " . $stmt1->error);
}

$stmt1->close();

// Seconda query con prepared statement per l'aggiornamento
$stmt2 = $mydb->prepare("UPDATE TABELLA SET numRighe = numRighe + 1 WHERE nome = ?");
if (!$stmt2) {
    die("Preparazione della query 2 fallita: " . $mydb->error);
}

$stmt2->bind_param("s", $tab);

if (!$stmt2->execute()) {
    die("Esecuzione della query 2 fallita: " . $stmt2->error);
}

$stmt2->close();

?>
