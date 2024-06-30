<?php
require('read/validate.php'); //accesso e configurazione db
if (!isset($_SESSION['login'])) { //il file è accessibile solo se è stato eseguito l'accesso
    header('Location: ../index.php');
    exit;
}
/*
 * nella query del path può essere specificato il nome di una tabella per mostrarne le specifiche
 * o è possibile specificare action=create per mostrare il form di creazione di una nuova tabella
 */
$creazione = false;
$tabellaSelezionata = null;
//verifico se è stato passato il parametro di una specifica tabella in input
if (isset($_GET['titolo'])) {
    $titolo = $_GET['titolo'];
    // Cerco la tabella corrispondente nella sessione
    foreach ($_SESSION['tabelle'] as $tabella) {
        if ($tabella['nome'] === $titolo) {
            $tabellaSelezionata = $tabella;
            break;
        }
    }
    // Se la tabella è stata trovata, mostra le informazioni
    if ($tabellaSelezionata != null) {
        //salvo la tabella da visualizzare in una variabile di sessione
        $_SESSION['table'] = $tabellaSelezionata;
        //salvo tutti i dati della tabella in un array associativo
        require ('read/fetch_records.php');

        //ricavo i nomi degli attributi
        require ('read/fetch_attributi.php'); //salvo gli attributi in un array associativo $attributi
        echo '<br>records trovati: '.json_encode($records);
        echo '<br>attributi trovati: '.json_encode($attributi);

    } else {
        echo '<p>Tabella non trovata.</p>';
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'create') {
    $creazione = true;
} else {
    $creazione = false;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>pannello di controllo</title>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<h1>Tabelle</h1>
<div id="account">
    <?php echo "Docente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?>
    <a href="../logout.php">Logout</a>
</div> <!--stampa i dati dell'account-->
<div>
    <ul id="elencoTabelle">
        <li><a href="tabelle.php?action=create">Nuova tabella</a></li>
        <?php
        foreach ($_SESSION['tabelle'] as $tabella) {
            $url = 'tabelle.php?titolo=' . urlencode($tabella['nome']);
            echo '<li><a href="' . $url . '">' . htmlspecialchars($tabella['nome']) . '</a></li>';
        } ?>
    </ul>
</div>
<div id="creazione" <?php if (!$creazione) {
    echo('style= \'display: none\'');
} ?>>
    <form name="newTable" action="upload/createTable.php" method="POST">
        <label for="titolo">Dai un <b>titolo</b> alla tua tabella</label>
        <input name="titolo" type="text" placeholder="titolo della tabella" required>
        <table id="listaAttributi">
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Lunghezza valori</th>
            </tr>
            <br>
            <h4>Inserisci gli attributi:</h4>
            <tr>
                <td>
                    <input name="att[]" type="text" required>
                </td>
                <td>
                    <label>specifica la lunghezza per attributi di tipo varchar!</label>
                    <br>
                    <select id='tipo' name="tipo[]" required> Tipo:
                        <option value="int">INT</option>
                        <option value="boolean">BOOLEAN</option>
                        <option value="varchar">VARCHAR</option>
                        <option value="date">DATE</option>
                    </select>
                </td>
                <td>
                    <input id='len' name="len[]" type="text">
                </td>
            </tr>
        </table>
        <input type="button" value="aggiungi attributo" onclick="newAttributo()">
        <input type="submit" id="submit">
    </form>
</div>
<div id="mostraTabella" <?php if ($tabellaSelezionata != null) echo('style= display: none'); ?>>
    <table>
        <tr>
            <th>Titolo:</th>
            <td><?php echo($tabellaSelezionata['nome']) ?></td>
        </tr>
        <tr>
            <?php for($i=0; $i<count($attributi); $i++) {
                echo('<th>' . $attributi[$i]['nome'] . '</th>');
            } ?>
        </tr>
        <!-- stampo una riga per ciascuna istanza-->
        <?php foreach ($records as $ist) { //itero tutte le istanze della tabella
            echo('<tr>');
            foreach ($ist as $val) {//itero tutti i valori dell'istanza
                echo('<td>' . $val . '</td>');
            }
            echo('</tr>');
        } ?>
    </table>
    <form action="upload/updateTabella.php" method="post"> <!--?titolo=<?php //echo urlencode($titolo); ?>" method="post">-->
        <input type="hidden" name="nome" value=<?php echo $titolo?>>
        <input type="submit" value="modifica">
    </form>
</div>
</body>
</html>
