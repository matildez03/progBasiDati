<?php
require('../../config.php');
/*
 * per potersi registrare il docente deve conoscere i dati di accesso al database
 * username = root
 * password = root
 */
//recupero i dati mandati in post

$usdb = $_POST['usdb'];
$pwdb = $_POST['pwdb'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$dip = $_POST['dipartimento'];
$corso = $_POST['corso'];

//controllo che il docente abbia immesso i dati corretti
if($pwdb=='root' && $usdb =='root'){
    //controllo che le password siano uguali
    if($pass==$pass2) {
        //registro il docente
        $password = md5($pass); //hasho la password in md5
        $insert1 = "INSERT INTO UTENTE (email, password, nome, cognome) VALUES (?,?,?,?)";
        $res = $mydb->prepare($insert1);
        $res->bind_param('ssss', $email, $password, $nome, $cognome);

        $insert2 = "INSERT INTO DOCENTE (emailUtente, dipartimento, corso) VALUES (?,?,?)";
        $res2 = $mydb->prepare($insert2);
        $res2->bind_param('sss', $email, $dip, $corso);

        if($res->execute()){
            if($res2->execute()) {
                echo('registrazione avvenuta con successo');
                header('Location: ../../index.php');
            }
        }
    } else{
        echo ('le password non corrispondono');
    }
} else{
    echo "credenziali errate.";
}
