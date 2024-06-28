<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require ('fetch_quesiti.php'); //salva in $quesiti tutti i quesiti del test in sessione
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
foreach ($quesiti as $quesito){
    $tipo = $quesito['tipo'];
    if ($tipo == 'chiuso'){
        $_SESSION['quesito'] = $quesito;
        require ('../read/calcola_esito.php');


    }
}

require ('fetch_risposte.php');
