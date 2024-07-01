<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require "read/fetch_tests.php"; //salva i test in una variabile $tests
if(isset($_GET['titolo'])) {
//ricerco i messaggi relativi al test
    $titoloTest = $_GET['titolo'];
    $_SESSION['test'] = $titoloTest;
    require('read/fetch_messaggi.php'); //salva tutti i messaggi pubblici sul test in $messaggi
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>test</title>
</head>
<body>
<h1>EFFETTUA UN TEST</h1>
<div id="account"><?php echo "Studente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?></div>
<!--stampa i dati dell'account-->
<div id="elencoTest">
    <h5>Test disponibili:</h5>
    <ol>
        <?php for ($i=0; $i<count($allTests); $i++) {
            $test = $allTests[$i];
            echo "<li>$test[0]</li><a href='messaggi.php?titolo=$test[0]'>Visualizza Messaggi</a>";
        } ?>
    </ol>
</div>
<div class="comment-section" <?php if(!isset($_GET['titolo'])){echo "style= 'display: none'";}?>>
    <h4>Commenti</h4>
    <div id="area-commenti">
        <?php
        foreach ($messaggi as $messaggio): ?>
            <?php if($messaggio['studente']==null){
                $utente = $messaggio['docente'];
            } else{
                if ($messaggio['studente']!=$_SESSION['login']){
                    continue;
                }
                $utente = $messaggio['studente'];
            }
            $titolo = $messaggio['titolo'];
            ?>
            <div>
                <strong><?php echo htmlspecialchars($utente)?>:</strong>
                <?php echo "Titolo: ".htmlspecialchars($messaggio['titolo'])." Messaggio: "?>
                <?php echo htmlspecialchars($messaggio['testo']); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <form id="comment-form flex" action="upload/nuovoMessaggioPrivato.php" method="POST">
        <input type="text" name="titolo" placeholder="Titolo Messaggio">
        <input type="text" name="testo" placeholder="Scrivi un messaggio...">
        <input type="hidden" name="studente" value=" <?php echo $studente?>">
        <input type="hidden" name="test" value=" <?php echo $titoloTest?>">
        <input type="submit" value="Commenta">
    </form>
</div>

</body>
<script>


</script>
</html>
