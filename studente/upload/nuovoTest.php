<?php
/*
 * file richiamato da svolgiTest.php, quando il test cliccato viene iniziato per la prima volta.
 * nel fiile svolgiTest è stata dichiarata la variabile di sessione con il test da svolgere.
 */
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
//$query = "INSERT INTO TESTAVVIATO (test, studente, dataInizio, dataUltimaModifica,stato) VALUES(?,?,?,?,?);";
//utilizzo replace per evitare errori nei casi in cui uno studente avesse già svolto tale test.
$query = "CALL avvia_test(?,?);";
$stmt = $mydb->prepare($query);
$stmt->bind_param('ss', $test, $studente);
if($stmt->execute()){
    //echo 'test avviato.';
}

