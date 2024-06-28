<?php
require('../read/validate.php'); //accesso e configurazione db

$titoloTest = $_POST['titoloTest'];
$docente = $_SESSION['login'][0];
$mostra = $_POST['mostraSoluz'];
$data = date("Y-m-d");
$query = 'INSERT INTO TEST (titolo, docente, data, visualizzaRisposte) values (?,?,?,?)';
// Prepara la query
if ($res = $mydb->prepare($query)) {
    $res->bind_param('sssi', $titoloTest, $docente, $data, $mostra);
    if ($res->execute()) {
        echo "Inserimento riuscito.";
        //salvo nella variabile di sessione
        $nuovoTest = array(
            "titolo" => $titoloTest,
            "docente" => $docente,
            "data" => $data,
            "visualizzaRisposta" => $mostra
        );
        $_SESSION['tests'][] = $nuovoTest;
    } else {
        echo "Errore nell'inserimento: " . $res->error;
    }
    // Chiudi la dichiarazione
    $res->close();
} else {
    echo "Errore nella preparazione della query: " . $mydb->error;
}



//recupero i dati mandati in post
$titoloTest = $_POST['titoloTest'];
$mostra = $_POST['mostraSoluz'];
$testiQuesito = $_POST['testoQuesito']; //array delle domande
$diff = $_POST['diff'];//array delle difficoltà
$soluzioni = $_POST['soluzione']; //array delle soluzioni aperte
$tipi = $_POST['tipo'];

/*
 * salvo le rispste d tutti i quesiti in array divisi nell'ordine di risposta
 * per accedere alla risosposta n del quesito chiuso m uso l'indice chiuseIndex passato in input, analogamente per le aperte
 */
$risposta1 = $_POST['testoRisposta1'];
$risposta2 = $_POST['testoRisposta2'];
$risposta3 = $_POST['testoRisposta3'];
$risposta4 = $_POST['testoRisposta4'];



