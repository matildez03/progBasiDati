<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('../read/fetch_quesiti.php'); //salva in $quesiti tutti i quesiti del test in sessione
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];


//debug:
echo '<br>test:' .$test;
echo '<br>studente:' .$studente;
foreach ($quesiti as $quesito) {
    $num = $quesito['num'];
    $risposta = trim($_POST[$quesito['num']]);
    //debug:
    echo '<br>risposta:' .$risposta;
    echo '<br>num:' .$num;
    $esito = 0;
    if ($quesito['tipo'] == 'chiuso') {
        require('../read/fetch_opzioni.php'); //salva le opzioni in $opzioni
        foreach ($opzioni as $opzione) {
            if ($opzione['corretta'] == 1) {
                $corretta = $opzione['testo']; //salvo il testo dell'opzione corretta per poi conforntarlo con quello della risposta
                break;
            }
        }
        if ($risposta == $corretta) {
            $esito = 1;
        }
    } else { //il quesito è di codice
        require('../read/fetch_soluzioni.php');
        foreach ($soluzioni as $soluzione) { //TODO: correggi, l'esito va calcolato in base al risultato della query.
            if ($risposta == $soluzione['testo']) {
                $esito = 1;
                break; //esco dal ciclo
            }
        }
    }
    //debug:
    echo '<br>risposta:' .$esito;
    $query = "CALL inserisci_risposta(?,?,?,?,?)";//query per selezionare tuti i test che lo studente non ha ancora iniziato e che sono disponibili
    $stmt = $mydb->prepare($query);
    if ($stmt === false) {
        throw new Exception("Errore nella preparazione della query: " . $mydb->error);
    }
    $stmt->bind_param('ssisi',$test, $studente, $num, $risposta, $esito);
    $stmt->execute();
}

