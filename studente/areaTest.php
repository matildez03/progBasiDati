<?php
/*
 * mi assicuro che il file sia accesibile solo se è stato eseguito l'accesso
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require('read/fetch_tests.php');

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
        <?php for ($i=0; $i<count($tests); $i++) {
            $test = $tests[$i];
            echo "<li>$test[0]</li><a href='svolgiTest.php?titolo=$test[0]'>Avvia test</a>";
        } ?>
    </ol>
    <h5>Test in completamento:</h5>
    <ol>
        <?php for ($i=0; $i<count($testInCompletamento); $i++) {
            $test = $testInCompletamento[$i];
            echo "<li>$test[0]</li><a href='svolgiTest.php?titolo=$test[0]&stato=inCompletamento'>Riprendi test</a>";
        } ?>
    </ol>
    <h5>Test Completati:</h5>
    <ol>
        <?php foreach ($testConclusi as $test) {
            echo "<li>$test[0]</li>";
        } ?>
    </ol>
</div>

</body>
<script>


</script>
</html>
