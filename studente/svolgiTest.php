<?php
//controlli preliminari
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
//recupero i dati del path
if (!isset($_GET['titolo'])) {
    echo 'nessun test da eseguire.';
    exit;
}
$titolo = $_GET['titolo'];
$_SESSION['test'] = $titolo; //associo il titolo del test  ad una variabile di sessione
$studente = $_SESSION['login'][0];
$stato = 'aperto';
require('read/fetch_quesiti.php'); //salvo i quesiti nella vaiabile $quesiti
//echo json_encode($quesiti); //debug
$risposte = array();
/*creo un array di rislutati in sessione
ogni risultato è un array associativo quesito - risposta*/
$_SESSION['risultati']= array(); //cancello eventuali risultati precendenti
if (isset($_GET['stato'])) {
    $stato = $_GET['stato'];
    require('read/fetch_risposte.php'); //sovrascrivo $risposte un array di testi di risposta
}
//inserisco il nuovo TESTAVVIATO
require 'upload/nuovoTest.php';


//creo l'html per la visualizzazione del test
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>test</title>
</head>
<body>
<!--stampa i dati dell'account-->
<div id="account"><?php echo "Studente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?></div>
<h1>TEST IN ESECUZIONE: <?php echo($titolo) ?></h1>
<div id="quesiti">
    <form id="test" action="upload/salva_risposte.php" method="POST">
    <?php
        for($i=0; $i<count($quesiti); $i++) {
            $quesito = $quesiti[$i];
            $_SESSION['quesito'] = $quesito;
            require('read/fetch_tabelle_quesito.php');
            $risposta = array(//mi assicuro che sia sempre possible accedere ad una variable risposta con valori di default
                'numeroQuesito' => -1,
                'testo' => '',   // Chiave 'testo' con valore vuoto di default
                'esito' => 2   // Chiave 'esito' con valore 2 di default (nè 1 nè 0)
            );//di default associo una stringa vuota alla risposta
            foreach ($risposte as $r) { //ricavo l'eventuale risposta a tale quesito
                if ($r['numeroQuesito'] == $quesito['num']) {
                    $risposta = $r;
                }
            }

            //controllo il tipo di quesito ed in base ad esso mostro il form
            echo '<div>';
            if ($quesito['tipo'] == 'chiuso') {
                require('read/fetch_opzioni.php'); //recupero le opzioni
                echo("
                        <h5>Domanda $quesito[num]:</h5>
                        <p>Difficoltà: $quesito[difficolta]</p>
                        <p>$quesito[testo]</p>
                       ");
                foreach ($opzioni as $opzione) {
                    echo("<input type='radio' value='$opzione[testo]' name='$quesito[num]'");
                    if ($risposta['testo'] == $opzione['testo']) {
                        echo("checked");
                    }
                    echo(">$opzione[testo]</input>
                    ");
                }
            } else { //quesito di codice
                echo("
                        <h5>Domanda $quesito[num]:</h5>
                        <p>Difficoltà: $quesito[difficolta]</p>
                        <p>$quesito[testo]</p>
                        <textarea name='$quesito[num]'>$risposta[testo]</textarea>
                       ");
            }
            if (isset($tabelle)) {
                echo "<p>Tabelle di riferimento:</p>";
                foreach ($tabelle as $tabellaSelezionata) {
                    $_SESSION['table'] = $tabellaSelezionata;
                    require("read/fetch_records.php"); //salvo le istanze della tabella in $records
                    require("read/fetch_attributi.php"); //salvo le colonne della tabella in $attributi
                    echo("<table><tr>
                    <th>Titolo:</th>
                    <td>$tabellaSelezionata</td>
                    </tr>");
                    echo("<tr>");
                    foreach ($attributi as $attributo) {
                        echo('<th>' . $attributo['nome'] . '</th>');
                    }
                    echo("</tr>");
                    foreach ($records as $ist) { //itero tutte le istanze della tabella
                        echo('<tr>');
                        foreach ($ist as $val) {//itero tutti i valori dell'istanza
                            echo('<td>' . $val . '</td>');
                        }
                        echo('</tr>');
                    }
                    echo("</table>");
                }
            }
            echo("</div>");
        }
    ?>
        <input type="submit" value="visualizza risultati">
    </form>

</div>
</body>
</html>
