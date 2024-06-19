<?php
require('config.php');
//recupero i dati mandati in post
$atts = $_POST['att'];
$tit = $_POST['titolo'];
$lens = $_POST['len'];
$types = $_POST['tipo'];

try {
    //creo la tabella
    $crea = "CREATE TABLE $tit (";
        //aggiungo gli attributi
        for ($i = 0; $i < count($atts); $i++) {
            $attributo = $atts[$i] ." ". $types[$i];
            if (($lens[$i])!="") { //se è stata specificata la lunghezza
                $attributo .= "(" . $lens[$i] . ")";
            }
            $crea .= $attributo;
            if($i==(count($atts)-1)){
                $crea .= ");";
            } else{
                $crea .= ",\n";
            }
        }
        echo($crea);
    $res = $mydb->prepare($crea);
    if ($res->execute()) { //riorna true se la tabella è stata creata
        echo "la tabella $tit è stata creata";
    } else {
            echo "Errore nella creazione della tabella $tit.";
    }
} catch (PDOException $e) {
    echo "Errore durante l'esecuzione della query: " . $e->getMessage();
}
?>

