<?php
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require ('/Applications/MAMP/htdocs/progBasi/studente/config-esercizi-studente.php'); //connessione al db di esercizio ad $esdb
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
$quesito = $_SESSION['quesito'];
$risposta = $_SESSION['risposta'];
$esito = 0;
//funzione richiamata da salva_risposte, dove sono definite le variabili del quesito
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
} /*else { //il quesito è di codice
    require('../read/fetch_soluzioni.php');
    foreach ($soluzioni as $soluzione) { //TODO: correggi, l'esito va calcolato in base al risultato della query.
        if ($risposta == $soluzione['testo']) {
            $esito = 1;
            break; //esco dal ciclo
        }
    }
}*/
if($quesito['tipo'] == 'codice'){
    try {
        //eseguo le query corrette e paragono il risultato
        require('fetch_soluzioni.php'); //salvo le soluzioni su un array associatvo $soluzioni
        if (!isset($soluzioni)) {
            throw new Exception('non sono state definite delle opzioni per il quesito: ' . json_encode($quesito));
        }
        if(isset($soluzioni)){
            echo '<br> soluzioni: '. json_encode($soluzioni);
        }

        $correct_result = [];
        foreach ($soluzioni as $soluzione) { //il quesito può avere più soluzioni corrette
            $correct_query = trim($soluzione['testo']);
            echo '<br> testo soluzione corretta: '. $correct_query;
            $stmt = $esdb->prepare($correct_query);
            $stmt->execute();
            $correct_result[] = $stmt->get_result(); // salvo tutte le soluzioni in un array
            $stmt->close();
        }
        // Eseguo la query dello studente
        $student_query = trim($risposta);
        $stmt = $esdb->prepare($student_query);
        $stmt->execute();
        $student_result = $stmt->get_result();
        $stmt->close();

        //confronto il risultato prodotto dallo studente con tutti i risultati corretti
        foreach ($correct_result as $correct_res) {
            if (compare_results($correct_res, $student_result)) {
                $esito = 1;
                break;
            }
        }

        if ($esito == 1) {
            echo "Le query producono lo stesso risultato.";
        } else {
            echo "Le query producono risultati diversi.";
        }
        // Rollback della transazione per annullare le modifiche
        $esdb->rollback();
    }catch (Exception $e) {
        // Rollback della transazione in caso di errore
        $esdb->rollback();
        echo "Errore durante l'esecuzione della query: " . $e->getMessage();
    }
    // Chiudo la connessione con il db
    $esdb->close();
}
function compare_results($result1, $result2) {
    // Verifica il numero di righe
    if ($result1->num_rows !== $result2->num_rows) {
        return false;
    }

    // Verifica ogni riga
    while ($row1 = $result1->fetch_assoc()) {
        $row2 = $result2->fetch_assoc();
        if ($row1 != $row2) {
            return false;
        }
    }
    return true;
}

