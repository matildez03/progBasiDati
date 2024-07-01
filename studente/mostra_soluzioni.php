<?php
/*
 * file accessibile da studente/areaTest, quando lo studente clicca su mostra soluzioni del test concluso
 * il nome del test è passato nella query del path sotto la voce 'titolo'
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require('../config.php');
$test = trim($_GET['titolo']);
//ricavo visualizzaRisposte
try {
    $query = "SELECT visualizzaRisposte FROM TEST WHERE titolo = ?;";
    $stmt = $mydb->prepare($query);
    $stmt->bind_param('s', $test);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    $show = $row[0]; // 0 se le risposte non sono visibili, 1 se sonon visibili
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage()); // Logga l'errore nel log degli errori del server
    echo 'Si è verificato un errore durante il recupero dei dati. Per favore riprova più tardi.';
}
if($show == 1){
    $_SESSION['test'] = $test;
    require ("read/fetch_quesiti.php");
    require ("read/fetch_opzioni.php");
    require ("read/fetch_soluzioni.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Soluzioni del test</title>
</head>
<body>
<h1>Soluzioni del test: <?php echo $test ?></h1>
<?php if($show == 0) echo "<h4>Soluzioni non disponibili.</h4>"?>
<?php if($show == 1)
    foreach($quesiti as $quesito){
        $_SESSION['quesito'] = $quesito;
        if($quesito['tipo']=='chiuso') {
            require("read/fetch_opzioni.php");
            foreach ($opzioni as $opzione) {
                if ($opzione['corretta'] == 1) {
                    $corretta = $opzione['testo']; //salvo il testo dell'opzione corretta per poi conforntarlo con quello della risposta
                    break;
                }
            }
            echo("<div>");
            echo("<h4>Quesito $quesito[num]:</h4>");
            echo("<p>Tipo: $quesito[tipo]</p>");
            echo("<p>Soluzione: $corretta </p>");
            echo("</div>");
        }
        if($quesito['tipo'] == 'codice'){
            require "read/fetch_soluzioni.php";
            echo("<div>");
            echo("<h4>Quesito $quesito[num]:</h4>");
            echo("<p>Tipo: $quesito[tipo]</p>");
            for($i=0; $i<count($soluzioni); $i++) {
                $count = $i + 1;
                $soluzione = $soluzioni[$i];
                echo("<p> Soluzione $count:</p>");
                echo ("<h5>$soluzione[testo]</h5>");
            }
        }
    }
    ?>

</body>
</html>