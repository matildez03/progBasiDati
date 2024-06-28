<?php
require('../validate.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//ricavo i dati mandati in post dal form per l'aggiunta di un vincolo
$nome = $_POST['nomeVincolo'];
$onDel = $_POST['onDelete'];
$onUpd = $_POST['onUpdate'];
$tabInterna = $_POST['tabInterna'];
$colInterna = $_POST['colInterna'];
$tabEsterna = $_POST['tabEsterna'];
$colEsterna = $_POST['colEsterna'];


$alter = "ALTER TABLE $tabInterna ADD CONSTRAINT $nome FOREIGN KEY ($colInterna) REFERENCES $tabEsterna ($colEsterna);";
$res1 = $mydb->prepare($alter);
if($res1->execute()){
    echo('inserimento avvenuto con successo.');
    $query = "INSERT INTO VINCOLO (nome, tabella1, attributo1, tabella2, attributo2, onDeleteAction, onUpdateAction) VALUES (?,?,?,?,?,?,?);";
    $res = $mydb->prepare($query);
    $res->bind_param('sssssss',$nome, $tabInterna, $colInterna, $tabEsterna, $colEsterna, $onDel, $onUpd);
    if($res->execute()) {
        echo('metadati salvati.');
    }
}

?>