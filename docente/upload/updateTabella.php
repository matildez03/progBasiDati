<?php
require('../read/validate.php'); //accesso e connessione al db
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
//salvo il nome della tabella in modifica in una variabile di sessione
$_SESSION['tabella'] = $titolo;
//salvo tutti i dati della tabella in un array associativo $records
require ('../read/fetch_records.php');

//ricavo gli attributi della tabella in un array associativo $attributi
require ('../read/fetch_attributi.php');

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
                if($att['isChiave']==1){ //se l'attributo è indicato come chiave primara
                    echo('<th><u>' . $att['nome'] . '</u></th>');
                }else { //la quinta colonna di ATTRIBUTO è isChiave, 0 non è chiave 1 è chiave
                    echo('<th>' . $att['nome'] . '</th>');
                }
            } ?>
        </tr>
        <!-- stampo una riga per ciascuna istanza-->
        <?php foreach ($records as $ist) { //itero tutte le istanze della tabella
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
                echo("<label><input type='checkbox' name='chiave[]' value=$att[nome]>$att[nome]</label>");
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
                    echo("<tr><td>$att[nome]</td><td>$att[tipo]</td><td>");
                    if($att['tipo']=='int'){
                        echo("<input type='number' name='value[]'><input type='hidden' name='types[]' value='$att[tipo]'><input type='hidden' name='attributi[]' value='$att[nome]'>");
                    }
                    if($att['tipo']=='boolean'){
                        echo("<input type='number' max='1' min='0' name='value[]'><label>0: false, 1: true</label><input type='hidden' name='types[]' value='$att[tipo]'><input type='hidden' name='attributi[]' value='$att[nome]'>");
                    }
                    if($att['tipo']=='text' || $att['tipo']=='varchar'){
                        echo("<input type='text' name='value[]'><input type='hidden' name='types[]' value='$att[tipo]'><input type='hidden' name='attributi[]' value='$att[nome]'>");
                    }
                    if($att['tipo']=='date'){
                        echo("<input type='date' name='value[]'><input type='hidden' name='types[]' value='$att[tipo]'><input type='hidden' name='attributi[]' value='$att[nome]'>");
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
</html>


