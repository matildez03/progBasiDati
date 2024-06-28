<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require ('fetch_quesiti.php'); //salva in $quesiti tutti i quesiti del test in sessione
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
$quesito = $_SESSION['quesito'];
//funzione richiamata da salva_risposte, dove sono definite le variabili del quesito
if($quesito['tipo'] == 'chiuso'){
    require ('fetch_opzioni.php'); //salva le opzioni in $opzioni
    echo ('<br>calcola_esito:' . json_encode($opzioni));
}
