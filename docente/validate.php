<?php
session_start(); // inizia la sessione
// Includo la connessione al database
require('config.php');
// Se il modulo viene inviato...
if (isset($_POST['login'])) {
// Dati inviati dal modulo
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : ''; // Metto nella variabile 'user' il dato inviato dal modulo
    $pass = (isset($_POST['pass'])) ? trim($_POST['pass']) : ''; // Metto nella variabile 'pass' il dato inviato dal modulo
/*Cripto la password e la confronto con quella del campo pass del Database
    $pass = md5($pass);
*/
// Controllo se l'utente esiste
    $query1 = $mydb->query("SELECT * FROM UTENTE, DOCENTE WHERE UTENTE.email = DOCENTE.emailUtente AND emailUtente = '$email' AND password = '$pass' LIMIT 1");
// Se trova un record
    if (mysqli_num_rows($query1) == 1) {
//salvo i dati dell'utente in un array
        $login = mysqli_fetch_array($query1);
// Creo una variabile di sessione contenente i dati dell'utente
        $_SESSION['login'] = array($login['email'], $login['password'],$login['nome'], $login['cognome'] );
        echo $_SESSION['login'][0]; // Recupero l'email dell'utente che ha registrato la sessione
        echo '<h3>Login effettuato con successo!</h3>';
// Rendirizzo l'Utente
       header('Location: amministrazione.php');
    } else {
// Se non esiste visualizzo il messaggio di errore
        echo("<h3 style='text-align:center;background:red;color:#fff;padding:20px;'>Nome utente o password errati!</h3>");
        header("Refresh:4 url=../");
    }
    //salvo i dati dei test del docente
    //preparo la query

}



