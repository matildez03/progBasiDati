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
$stato = 'aperto';
require('read/fetch_quesiti.php'); //salvo i quesiti nella vaiabile $quesiti
echo json_encode($quesiti); //debug
$risposte = array();
if (isset($_GET['stato'])) {
    $stato = $_GET['stato'];
    echo '<br>'. $stato; //debug
    require('read/fetch_risposte.php'); //sovrascrivo $risposte un array di testi di risposta
}
if ($stato == 'aperto') {
    require 'upload/nuovoTest.php'; //eseguo l'inserimento del nuovo test
    foreach ($quesiti as $quesito) { //inserirsco una stringa vuota per ogni risposta
        $risposte[] = "";
    }
}
echo '<br>Svolgi test - risposte:'. json_encode($risposte); //debug
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
        for($i=0; $i<count($quesiti); $i++){
            $quesito = $quesiti[$i];
            $risposta = $risposte[$i];
            //controllo il tipo di quesito ed in base ad esso mostro il form
            echo '<div>';
            if($quesito['tipo']=='chiuso'){
                require ('read/fetch_opzioni.php'); //recupero le opzioni
                echo("
                        <h5>Domanda $quesito[num]:</h5>
                        <p>Difficoltà: $quesito[difficolta]</p>
                        <p>$quesito[testo]</p>
                       ");
                foreach($opzioni as $opzione){
                    echo("<input type='radio' value='$opzione[testo]' name='$quesito[num]'");
                    if($risposta['testo'] == $opzione['testo']){ echo("checked");}
                    echo(">$opzione[testo]</input>
                    ");
                }
            } else{
                echo("
                        <h5>Domanda $quesito[num]:</h5>
                        <p>Difficoltà: $quesito[difficolta]</p>
                        <p>$quesito[testo]</p>
                        <textarea name='$quesito[num]'>$risposta</textarea>
                       ");
            }
            echo ("</div>");
        }
    ?>
        <input type="submit" value="concludi test">
    </form>

</div>
</body>
</html>
