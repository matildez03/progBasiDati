<?php
require('../read/validate.php');
//recupero i dati mandati in post
$tipo = $_POST['tipo'];
$test = $_POST['test'];
$num = 1; //numero di quesiti già presenti
$testo = $_POST['testoQuesito'];
$diff = $_POST['diff'];
$soluzione = '';
echo $test;


//recupero il numero di quesiti già presenti nel relativo test
$query1 = "SELECT num FROM QUESITO WHERE test = '$test' ORDER BY num DESC LIMIT 1";
$res = $mydb->query($query1);
if ($res) {
    $row = $res->fetch_assoc();
    if ($row) {
        $num += $row['num'];

    }
} else {
    echo "Errore nella query: " . $mydb->error;
}

/*
 * inserisco l'istanza in QUESITO
 */
$query = "INSERT INTO QUESITO (num, test, numRisposte, difficolta, testo, tipo) VALUES (?,?,0,?,?,?)";
$res = $mydb->prepare($query);
if ($res) {
    $res->bind_param('isiss', $num, $test, $diff, $testo, $tipo);
    if ($res->execute()) {
        echo 'inserimento in QUESITO avvenuto.';
    }
}
$res->close();
if ($tipo == 'codice') {
    $soluzione = $_POST['soluzione'];
    //soluzione potrebbe anche essere un array di più soluzioni
    for ($i = 0; $i < count($soluzione); $i++) {
        $sol = $soluzione[$i];
        $ind = $i+1;
        $query = "INSERT INTO SOLUZIONE(quesito, test, testo, num) VALUES (?,?,?,?)";
        $res = $mydb->prepare($query);
        $res->bind_param('issi', $num, $test, $sol, $ind);
        if ($res->execute()) {
            echo 'inserimento in SOLUZIONE avvenuto.';
        }
        $res->close();
    }
} else if ($tipo == 'chiuso') {
    $opzioni = $_POST['opzioni'];
    $corretta = $_POST['corretta']; //numero da 1 a 4 che indica quale opzione è corretta
    //soluzione potrebbe anche essere un array di più soluzioni
    for ($i = 0; $i < count($opzioni); $i++) {
        $corr = 0; //0: la risposta non è corretta, 1: la risposta è corretta
        $opz = $opzioni[$i];
        $ind = $i+1;
        if ($corretta == $i) {
            $corr = 1;
        }
        $query = "INSERT INTO OPZIONE(quesito, test, numero, corretta, testo) VALUES (?,?,?,?,?)";
        $res = $mydb->prepare($query);

        $res->bind_param('isiis', $num, $test, $ind, $corr, $opz);
        if ($res->execute()) {
            echo 'inserimento in SOLUZIONE avvenuto.';
        }

        $res->close();
    }
}

//infine, inseriamo i riferimenti alle tabelle
if (isset($_POST['tabRif'])) {
    foreach ($_POST['tabRif'] as $tab) {
        $query = "INSERT INTO RIFTABELLE (num, test, tabella) VALUES (?,?,?)";
        $res = $mydb->prepare($query);
        $res->bind_param('iss', $num, $test, $tab);
        if ($res->execute()) {
            echo 'inserimento in RIFTABELLE avvenuto con successo';
        } else{
            echo 'errore:'. $res->error;
        }
    }
}





