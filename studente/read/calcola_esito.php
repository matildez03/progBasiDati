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
$messaggio = "";
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
}
if($quesito['tipo'] == 'codice'){
    try {
        //eseguo le query corrette e paragono il risultato
        require('fetch_soluzioni.php'); //salvo le soluzioni su un array associatvo $soluzioni
        if (!isset($soluzioni)) {
            throw new Exception('non sono state definite delle opzioni per il quesito: ' . json_encode($quesito));
        }
        if(isset($soluzioni)){
            //echo '<br> soluzioni: '. json_encode($soluzioni);
        }

        $correct_result = [];
        foreach ($soluzioni as $soluzione) { //il quesito può avere più soluzioni corrette
            $correct_query = trim($soluzione['testo']);
            //echo '<br> testo soluzione corretta: '. $correct_query;
            $stmt = $esdb->prepare($correct_query);
            if (!$stmt){
                $messaggio = "errore nella preparazione della query.";
                break;
            }
            $stmt->execute();
            $correct_result[] = $stmt->get_result(); // salvo tutte le soluzioni in un array
            $stmt->close();
        }
        // Eseguo la query dello studente
        $student_query = trim($risposta);
        $stmt = $esdb->prepare($student_query);
        if (!$stmt){
            $messaggio = "errore nella preparazione della query.";
            exit;
        }
        $stmt->execute();
        $student_result = $stmt->get_result();


        //confronto il risultato prodotto dallo studente con tutti i risultati corretti
        foreach ($correct_result as $correct_res) {

            //verifica il numero di righe
            if ($correct_res->num_rows == $student_result->num_rows) {
                // Verifica ogni riga
                while ($row1 = $correct_res->fetch_assoc()) {
                    $row2 = $student_result->fetch_assoc();
                    if ($row1 != $row2) {
                        $esito = 0;
                        break;
                    } else{
                        $esito=1;
                    }
                }
            }
        }

        if ($esito == 1) {
            //echo "Le query producono lo stesso risultato.";
        } else {
            //echo "Le query producono risultati diversi.";
            $messaggio = "Le query producono risultati diversi.";
        }
        // Rollback della transazione per annullare le modifiche
        $stmt->close();
        $esdb->rollback();
    }catch (Exception $e) {
        // Rollback della transazione in caso di errore
        $esdb->rollback();
        $messaggio= "Errore durante l'esecuzione della query: " . $e->getMessage();
    }
}
$_SESSION['risultati'] = array(
    'quesito' => $quesito['num'],
    'risultato' => $student_result,
    'esito' => $esito,
    'messaggio' => mysqli_error($esdb)
);
// Chiudo la connessione con il db
$esdb->close();


