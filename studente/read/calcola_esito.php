<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
$quesito = $_SESSION['quesito'];
$risposta = $_SESSION['risposta'];
//funzione richiamata da salva_risposte, dove sono definite le variabili del quesito
if($quesito['tipo'] == 'chiuso'){
    require ('fetch_opzioni.php'); //salva le opzioni in $opzioni
    echo ('<br>calcola_esito:' . json_encode($opzioni));
    echo '<br>risposta:' .$risposta;
    foreach ($opzioni as $opzione){
        $num = $quesito['num'];
        $query = "CALL inserisci_risposta(?,?,?,?,?)";//query per selezionare tuti i test che lo studente non ha ancora iniziato e che sono disponibili
        $stmt = $mydb->prepare($query);
        if ($stmt === false) {
            throw new Exception("Errore nella preparazione della query: " . $mydb->error);
        }
        if($risposta == $opzione['testo']){
            $esito = 1;
        }else{
            $esito = 0;
        }
        $stmt->bind_param('ssisi', $test,$studente,$num,$testo,$esito);
        $stmt->execute();
    }
}
