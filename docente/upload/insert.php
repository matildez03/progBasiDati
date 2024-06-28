<?php
require('../read/validate.php');

//ricavo i dati da aggingere passati in post

$tab = $_POST['tabella'];
$values = $_POST['value'];
$types = $_POST['types'];  //array di tipi di dati corrispondenti
$attributi = $_POST['attributi'];
$colonne = implode(', ', $attributi);

$processed_values = array();
for($i=0; $i<count($values); $i++){
    $value = $values[$i];
    $type= $types[$i];
    if ($type == 'text' || $type == 'varchar' || $type == 'date') {
        // Aggiungo le virgolette singole per i tipi di dati stringa e data
        $processed_values[] = "'" . $value . "'";
    } else {
        // Per gli altri tipi di dati (int), assicurati che siano numerici
        $processed_values[] = $value;
    }
}
$valori = implode(', ', $processed_values); //creo una stringa con i valori separati da virgole
echo $valori;

$query = "INSERT INTO $tab ($colonne) VALUES ($valori);";
$mydb->query($query);
?>
