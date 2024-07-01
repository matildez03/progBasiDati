<?php
require ('read/validate.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
$titolo ='';
if(($_GET['titolo']) !== null){
    $titolo = $_GET['titolo'];
    $_SESSION['test'] = $titolo;
    //require ('read/fetch_quesiti.php'); //salva i quesiti in $quesiti
   // echo json_encode($quesiti);
}
if(($_GET['show']) !== null){ //se le risposte sono visualizzabili o meno
    $show = $_GET['show'];
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aggiorna Test</title>
</head>
<body>

<div id="account">Docente: <?php echo($_SESSION['login'][2] .' ' . $_SESSION['login'][3]);?></div> <!--stampa i dati dell'account-->
<h1>Test: <?php echo $titolo ?></h1>
    <h4>Quesiti presenti:</h4>
<ul id="elencoQuesiti">
</ul>

<div id="addQuesiti" >
    <input type="button" value="Aggiungi quesito chiuso" onclick="addQChiuso()">
    <input type="button" value="Aggiungi quesito aperto" onclick="addQAperto()">
</div>
<h4 id="showRisp">Visualizza Risposte: <?php if($show==1){echo 'sì';} else{echo 'no';}?> <button <?php echo ("onclick='showRisp($show)' "); ?>><?php if($show==1){echo "Nascondi Risposte";} else{echo "Mostra Risposte";} ?></button></h4>
<div id="formQuesito">
</div>
</form>
</body>
<script>
    function addSoluzione() {
        let sol = "<br><textarea name='soluzione[]'>";
        document.getElementById('quesitoAperto').innerHTML += sol;
    }
    let p = "<?php foreach ($_SESSION['tabelle'] as $tab){echo ("<input type='checkbox' name='tabRif[]' value= '$tab[nome]'><label>$tab[nome]</label>");}?>";
    function addQAperto(){
        let form = "<form id='quesitoAperto' action='upload/createQuesito.php' method='post'>";
        form += "<h3>Nuovo quesito aperto:</h3>";
        form += "<input type='submit' value='salva'><br>";
        form += "<input type='hidden' name='tipo' value='codice'>";
        form += "<input type='hidden' name='test' value=<?php echo ("'".$titolo)."'" ?>>";
        form += "<label>Testo del quesito:</label>";
        form += "<textarea name='testoQuesito' required></textarea><br>";
        form += "<label>Difficolta': <input type='number' name='diff' min='1' max='5' required></label><br>";
        form += "<label>Tabella/e di riferimento:</label>"
        form += "<?php foreach ($_SESSION['tabelle'] as $tab){echo ("<input type='checkbox' name='tabRif[]' value= '$tab[nome]'><label>$tab[nome]</label>");}?>";
        form += "<br><label>Testo query corretta: </label><br>";
        form += "<textarea name='soluzione[]' required></textarea>";
        form += "<input type='button' value='altra soluzione' onclick='addSoluzione()'>";
        form += "</form>";
        document.getElementById('formQuesito').innerHTML=form;
    }
    function addQChiuso(){
        let form = "<form id='quesitoChiuso' action='upload/createQuesito.php' method='post'>";
        form += "<h3>Nuovo quesito chiuso:</h3>";
        form += "<input type='submit' value='salva'><br>";
        form += "<input type='hidden' name='tipo' value='chiuso'>";
        form += "<input type='hidden' name='test' value=<?php echo ("'".$titolo)."'" ?>>";
        form += "<label>Testo del quesito:</label>";
        form += "<textarea name='testoQuesito' required></textarea><br>";
        form += "<label>Difficolta': <input type='number' name='diff' min='1' max='5' required></label><br>";
        form += "<label>Tabella/e di riferimento:</label>";
        form += "<?php foreach ($_SESSION['tabelle'] as $tab){echo ("<input type='checkbox' name='tabRif[]' value= '$tab[nome]'><label>$tab[nome]</label>");}?>";
        form += "<ul> <li>Opzione 1 <input type='text' name='opzioni[]' required></li> ";
        form += "<li>Opzione 2 <input type='text' name='opzioni[]' required></li> ";
        form += "<li>Opzione 3 <input type='text' name='opzioni[]'required></li> ";
        form += "<li>Opzione 4 <input type='text' name='opzioni[]' required></li></ul>";
        form += "<label>Indica quale opzione è corretta</label>";
        form +=  "<select name='corretta' required><option value='1'>Opzione 1</option><option value='2'>Opzione 2</option><option value='3'>Opzione 3</option><option value='4'>Opzione 4</option></select>";
        form += "</form>";
        document.getElementById('formQuesito').innerHTML=form;
    }
    document.addEventListener('DOMContentLoaded', function (){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'read/fetch_quesiti.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var quesiti = JSON.parse(xhr.responseText);
                    var elenco = document.getElementById('elencoQuesiti');
                    quesiti.forEach(function(quesito) {
                        let li = document.createElement('li');
                        li.innerHTML = quesito['num'] + ': ' + quesito['testo'];
                        elenco.appendChild(li);
                    });
                    console.log(xhr.responseText);
                } catch (e) {
                    console.error("Errore nel parsing JSON:", e);
                    console.log("Risposta del server:", xhr.responseText);
                }
            }
        };
        xhr.send("test=" + encodeURIComponent(<?php echo "'".$titolo."'"?>));
        console.log(encodeURIComponent(<?php echo "'".$titolo."'"?>));
        console.log(xhr.responseText);
    });
    function showRisp(n){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload/mostraRisposte.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let show = (n === 1) ? 0 : 1;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    let out = "<h4 id='showRisp'>Visualizza Risposte:";
                    out += (show === 1) ? " sì" : " no";
                    out += "<button onclick='showRisp(" + show + ")'>";
                    out += (show === 1) ? "Nascondi Risposte" : "Mostra Risposte";
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
</html>
