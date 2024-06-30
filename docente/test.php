<?php
/*
 * mi assicuro che il file sia accesibile solo se è sttao eseguito l'accesso
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require ('read/validate.php');
echo json_encode($_SESSION['tests']);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="script.js"></script>
    <title>Test</title>
</head>
<body>
<h1>I tuoi test:</h1>
<div id="account"><?php echo "Docente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?></div>
<!--stampa i dati dell'account-->

<ul id="elencoTest">
    <input type="button" value="Nuovo test" onclick="showCreate()">
    <?php foreach ($_SESSION['tests'] as $test) {
        echo '<li onclick="getTest()"><a href="aggiornaTest.php?titolo='.$test['titolo'].'&show='.urlencode($test['visualizzaRisposte']).'">' . $test['titolo'] . '</a></li>';
    } ?>
</ul>
<form id="nuovoTest" action="upload/createTest.php" method="POST" style="display: none">
    <label>Titolo Test:<input type="text" name="titoloTest" required></label>
    <select name="mostraSoluz">
        <option value="1" selected>Mostra soluzioni</option>
        <option value="0">Nascondi soluzioni</option>
    </select>
    <input type="submit">
</form>

</body>
</html>
<script>
    function getTest(){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload/fetch_.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let show=0;
        if(n==1){show = 0;}
        else if(n==0){show=1;}
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    let out = "<h4 id='showRisp'>Visualizza Risposte:";
                    if(show==1){out += " sì";}
                    else{out += " no";}
                    out += "<button onclick='showRisp(" + show + ")'>";
                    if(show==1){
                        out+= "Nascondi Risposte";
                    }else{
                        out += "Mostra Risopste";
                    }
                    out += "</button></h4>"
                    document.getElementById("showRisp").outerHTML=out;
                    console.log(xhr.responseText);
                } catch (e) {
                    console.error("Errore nel parsing JSON:", e);
                    console.log("Risposta del server:", xhr.responseText);
                }
            }
        };
        xhr.send("test=" + encodeURIComponent(<?php echo "'".$titolo."'"?>) + "&show="+encodeURIComponent(show));
        console.log(encodeURIComponent(<?php echo "'".$titolo."'"?>));
        console.log(xhr.responseText);
    }

</script>