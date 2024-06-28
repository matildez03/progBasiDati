<?php
require('../read/validate.php'); //accesso e configurazione db
//recupero i dati mandati in post
$atts = $_POST['att'];
$tit = $_POST['titolo'];
$lens = $_POST['len'];
$types = $_POST['tipo'];
$doc = $_SESSION['login'][0]; //email del docente salvata nella variabile di sessione

for ($i = 0; $i < count($types); $i++) {
    if ($types[$i] === 'varchar') {
        if ($lens[$i] === '') { //non è stata specificata la lunghezza
            echo('specifica la lunghezza dell\'attributo varchar!');
        }
    }
}


try {
    //creo la tabella
    $crea = "CREATE TABLE $tit (";
    //aggiungo gli attributi
    for ($i = 0; $i < count($atts); $i++) {
        $attributo = $atts[$i] . " " . $types[$i];
        if (($lens[$i]) != "") { //se è stata specificata la lunghezza
            if (($types[$i] != "boolean") && ($types[$i] != "date")) { //considera anche la lunghezza specificata
                $attributo .= "(" . $lens[$i] . ")";
            }
        }
        $crea .= $attributo;
        if ($i == (count($atts) - 1)) {
            $crea .= ");";
        } else {
            $crea .= ",\n";
        }
    }
    //echo($crea);
    $res = $mydb->prepare($crea);
    if ($res->execute()) { //riorna true se la tabella è stata creata
        //echo "la tabella $tit è stata creata";
        //inserisco i meta dati della tabella nel db

        //inserimento in TABELLA
        $data = date('Y-m-d'); // Formato 'YYYY-MM-DD'
        $insert1 = "INSERT INTO TABELLA VALUES (?,?,?,?);";
        $res1 = $mydb->prepare($insert1);
        $res1->execute([$tit, $doc, 0, $data]);

        //salvo nella variabile di sessione
        $nuovaTabella = array(
            "nome" => $tit,
            "docente" => $doc,
            "numRighe" => 0,
            "dataCreazione" => $data,
            "attributi" => $atts //salvo anche gli attributi nell'array di sessione per accedervi senza dover fare query
        );
        $_SESSION['tabelle'][] = $nuovaTabella;

        //inserimento in ATTRIBUTO
        for ($i = 0; $i < count($atts); $i++) {
            $att = $atts[$i];
            $tipo = $types[$i];
            $insert2 = "INSERT INTO ATTRIBUTO (nomeTabella,nome,tipo, isChiave) 
                    VALUES (?, ?, ?, ?);";
            // Prepara l'istruzione SQL
            $res2 = $mydb->prepare($insert2);

            // Esegui l'istruzione SQL con i valori appropriati
            $res2->execute([$tit, $att, $tipo, 0]); //0 indica false per 'isChiave', le chiavi saranno specificate dall'utente in un secondo momento
        }

        //aggiungo il trigger che aumenta numRighe per ogni insert

        //concludo reindirizzando l'utente nella pagina aggiornata
        header('Location: ../tabelle.php');
    } else {
        echo "Errore nella creazione della tabella $tit.";
    }

} catch (PDOException $e) {
    echo "Errore durante l'esecuzione della query: " . $e->getMessage();

}
?>

