<?php
require('../read/validate.php');
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
} else{ //il login è stato effettuato
    echo $_SESSION['login'][0];
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//ricavo tutti i dati della tabella data in post
$titolo = $_POST['nome'];
//salvo tutti i dati della tabella in un array associativo
$query = 'SELECT * FROM ' . $titolo;
$res = $mydb->query($query);
$valori = mysqli_fetch_all($res);

//ricavo i nomi degli attributi
$query2 = "SELECT * FROM ATTRIBUTO WHERE nomeTabella = '$titolo';";
$res2 = $mydb->query($query2);
$attributi = mysqli_fetch_all($res2);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>aggiorna tabella</title>
</head>
<body>
<h1>Amministrazione di ESQL</h1>
<div id="account">
    <?php echo "Docente: ".$_SESSION['login'][2]." " . $_SESSION['login'][3].""?>
    <a href="logout.php">Logout</a>
</div> <!--stampa i dati dell'account-->
<div id="mostraTabella">
    <h3>Modifica la tabella</h3>
    <table>
        <tr>
            <th>Titolo:</th>
            <td><?php echo($titolo) ?></td>
        </tr>
        <tr>
            <?php foreach ($attributi as $att) {
                if($att[4]==1){ //se l'attributo è indicato come chiave primara
                    echo('<th><u>' . $att[2] . '</u></th>');
                }else { //la quinta colonna di ATTRIBUTO è isChiave, 0 non è chiave 1 è chiave
                    echo('<th>' . $att[2] . '</th>');
                }
            } ?>
        </tr>
        <!-- stampo una riga per ciascuna istanza-->
        <?php foreach ($valori as $ist) { //itero tutte le istanze della tabella
            echo('<tr>');
            foreach ($ist as $val) {//itero tutti i valori dell'istanza
                echo('<td>'.$val.'</td>');
            }
            echo('</tr>');
        } ?>
    </table>
</div>
<div id="modifica" >
    <div>
        <!-- inserimento di chiave primaria -->
        <form action="setChiave.php" method="POST">
            <h4>Chiave primaria</h4>
            <input type="hidden" name="tabella" value=<?php echo $titolo?>>
            <fieldset>
                <legend>Attributi: </legend>
            <?php foreach($attributi as $att) {
                echo("<label><input type='checkbox' name='chiave[]' value=$att[2]>$att[2]</label>");
            }
            ?>
            </fieldset>
            <input type="submit" value="salva">
        </form>
        <!-- inserimento di istanze -->
        <h4>Inserisci un'istanza:</h4>
        <form action="insert.php" method="POST">
            <input type="hidden" name="tabella" value=<?php echo $titolo?>>
            <table>
                <tr><th>Colonna</th><th>Tipo</th><th>Valore</th></tr>
                <?php foreach ($attributi as $att){
                    echo("<tr><td>$att[2]</td><td>$att[3]</td><td>");
                    if($att[3]=='int'){
                        echo("<input type='number' name='value[]'><input type='hidden' name='types[]' value='$att[3]'><input type='hidden' name='attributi[]' value='$att[2]'>");
                    }
                    if($att[3]=='boolean'){
                        echo("<input type='number' max='1' min='0' name='value[]'><label>0: false, 1: true</label><input type='hidden' name='types[]' value='$att[3]'><input type='hidden' name='attributi[]' value='$att[2]'>");
                    }
                    if($att[3]=='text' || $att[3]=='varchar'){
                        echo("<input type='text' name='value[]'><input type='hidden' name='types[]' value='$att[3]'><input type='hidden' name='attributi[]' value='$att[2]'>");
                    }
                    if($att[3]=='date'){
                        echo("<input type='date' name='value[]'><input type='hidden' name='types[]' value='$att[3]'><input type='hidden' name='attributi[]' value='$att[2]'>");
                    }
                    echo("</td></tr>");
                }?>
            </table>
            <input type="submit">
        </form>
        <h4>Inserisci i vincoli:</h4>
        <form id="vinconli" action='addVincolo.php' method="post">
            <input type="hidden" name="tabInterna" value=<?php echo $titolo?>>
            <table id="vincoliTable">
                <tr>
                    <th>azioni</th>
                    <th>proprietà del vincolo</th>
                    <th>colonna interna</th>
                    <th>tabella esterna</th>
                    <th>colonna esterna</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="display: flex; flex-direction: column">
                            <input type="text" name="nomeVincolo" placeholder="nome del vincolo" required>
                            ON DELETE: <select name="onDelete">
                                <option value="CASCADE" selected="selected">
                                    CASCADE
                                </option>
                                <option value="SET_NULL">
                                    SET NULL
                                </option>
                                <option value="NO_ACTION">
                                    NO ACTION
                                </option>
                                <option value="RESTRICT">
                                    RESTRICT
                                </option>
                            </select>
                            ON UPDATE: <select name="onUpdate">
                                <option value="CASCADE" selected="selected">
                                    CASCADE
                                </option>
                                <option value="SET_NULL">
                                    SET NULL
                                </option>
                                <option value="NO_ACTION">
                                    NO ACTION
                                </option>
                                <option value="RESTRICT">
                                    RESTRICT
                                </option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <select name="colInterna" required>
                            <option value="" disabled selected>Seleziona un'opzione</option>
                            <?php foreach ($attributi as $att){echo ("<option value = '$att[2]'>$att[2]</option>"); }?>
                        </select>
                    </td>
                    <td>
                        <select id= 'tabEsterna' name="tabEsterna" required>
                            <option value="" disabled selected>Seleziona un'opzione</option>
                            <?php foreach ($_SESSION['tabelle'] as $tab){if($tab["nome"]!=$titolo){echo ("<option value = '".$tab['nome'] ."'>".$tab["nome"]."</option>");} }?>
                        </select>
                    </td>
                    <td>
                        <select id="colEsterna" name="colEsterna" required>
                            <option value="" disabled selected>Seleziona un'opzione</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" value="salva">
        </form>
    </div>
</div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tabEsterna').addEventListener('change', function() {
            var selectedTable = document.getElementById('tabEsterna').value;
            console.log('tabella selezionata: '+ selectedTable);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_columns.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                    var columns = JSON.parse(xhr.responseText);
                    var colEsterna = document.getElementById('colEsterna');
                    columns.forEach(function(column) {
                        var option = document.createElement('option');
                        option.value = column;
                        option.textContent = column;
                        colEsterna.appendChild(option);
                    });
                    } catch (e) {
                        console.error("Errore nel parsing JSON:", e);
                        console.log("Risposta del server:", xhr.responseText);
                    }
                }
            };
            xhr.send("table=" + encodeURIComponent(selectedTable));
            console.log(encodeURIComponent(selectedTable));
        });
    });
</script>
</html>


