<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['login'])){
    header('Location: ../../index.php');
    exit;
}
require ('../../config.php'); //connessione al db di sessione come $mydb
require('../config-esercizi.php'); //connessione al db si esercizio come $esdb

//ottengo le variabili mandate in post
$tab = $_POST['tabella'];
$chiavi = $_POST['chiave'];
$chiave = implode(', ', $chiavi); //creo una stringa con le chiavi separate da virgole

// Verifica se esiste una chiave primaria sulla tabella
$query_check = "SHOW KEYS FROM $tab WHERE Key_name = 'PRIMARY'";
$result_check = $esdb->query($query_check);

if ($result_check->num_rows > 0) {
    // Se esiste una chiave primaria, procede a rimuoverla
    $query_remove = "ALTER TABLE $tab DROP PRIMARY KEY";
    $esdb->query($query_remove);

    if ($mydb->errno) {
        throw new Exception("Errore durante la rimozione della chiave primaria: " . $mydb->error);
    }
} else {
    //echo "Nessuna chiave primaria trovata nella tabella";
}

//creo la query di inserimento della chiave
$query1 = "ALTER TABLE $tab ADD PRIMARY KEY ($chiave)";
$res = $esdb->query($query1);
if($res){
    //echo 'operazione riuscita';
    foreach($chiavi as $k) {
        $query2 = "UPDATE ATTRIBUTO SET isChiave = 1 WHERE nome = '$k'";
        $mydb->query($query2);
    }
}



?>
