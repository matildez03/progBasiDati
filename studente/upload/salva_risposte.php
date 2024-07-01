<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('../read/fetch_quesiti.php'); //salva in $quesiti tutti i quesiti del test in sessione
require ('../config-esercizi-studente.php');
$test = $_SESSION['test'];
$studente = $_SESSION['login'][0];
$riposteCorrette = 0;
$numQuesiti = count($quesiti);

/*debug:
echo '<br>test:' .$test;
echo '<br>studente:' .$studente;
*/
foreach ($quesiti as $quesito) {
    //salvo il quesito in sessione
    $_SESSION['quesito'] = $quesito;
    $num = $quesito['num'];
    $risposta = trim($_POST[$quesito['num']]);
    if($risposta != "") {  //salva la risposta solo se essa non è vuota
        $_SESSION['risposta'] = $risposta;
        //echo ('risposta dello studente: '. $risposta);

        require('../read/calcola_esito.php');
        //debug:
        if($quesito['tipo'] == 'codice' && $esito == 0){
            echo("<h4>Erroe nel quesito di codice ".$num .
                    ".</h4> <p> Messaggio di MYSQL: ". $messaggio. "</p><br>");
        }
        if($esito==1){
            $riposteCorrette++;
        }

        $query = "CALL inserisci_risposta(?,?,?,?,?)";//query per selezionare tuti i test che lo studente non ha ancora iniziato e che sono disponibili
        $stmt = $mydb->prepare($query);
        if ($stmt === false) {
            throw new Exception("Errore nella preparazione della query: " . $mydb->error);
        }
        $stmt->bind_param('ssisi', $test, $studente, $num, $risposta, $esito);
        $stmt->execute();
    }
}
echo("<h3>Punteggio totale: $riposteCorrette / $numQuesiti.");

