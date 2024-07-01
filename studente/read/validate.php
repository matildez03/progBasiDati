<?php
session_start(); // inizia la sessione
// Includo la connessione al database
require('/Applications/MAMP/htdocs/progBasi/config.php');

// Se il modulo viene inviato...
if (isset($_POST['login'])) {

// Dati inviati dal modulo
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : ''; // Metto nella variabile 'user' il dato inviato dal modulo
    $pass = (isset($_POST['pass'])) ? trim($_POST['pass']) : ''; // Metto nella variabile 'pass' il dato inviato dal modulo

    //Cripto la password in md5
    $pass = md5($pass);
    // Preparazione della stored procedure
    $query = "CALL Autentica_Studente(?, ?, @validate)";
    $stmt = $mydb->prepare($query);

    if (!$stmt) {
        die("Preparazione della query fallita: " . $mydb->error);
    }

    // Binding dei parametri di input
    $stmt->bind_param("ss", $email, $pass);

    // Esecuzione della stored procedure
    $stmt->execute();

    // Eseguire una query separata per ottenere il valore di @validate
    $result = $mydb->query("SELECT @validate AS validate");

    if (!$result) {
        throw new Exception("Errore nell'ottenere il valore di @validate: " . $mydb->error);
    }

    $row = $result->fetch_assoc();
    $validate = $row['validate'];

    // Verifica se l'autenticazione è riuscita
    if ($validate) {
        // Recupero dei dati dell'utente (se necessario)
        $query_user = "SELECT email, password, nome, cognome FROM UTENTE WHERE email = ?";
        $stmt_user = $mydb->prepare($query_user);
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $res_user = $stmt_user->get_result();

        if ($res_user->num_rows > 0) {
            $login = $res_user->fetch_assoc();
            $_SESSION['login'] = array($login['email'], $login['password'], $login['nome'], $login['cognome']);
            header('Location: ../homepage.php');
        } else {
            throw new Exception("Dati utente non trovati per l'email: " . $email);
        }

        $res_user->close();
        $stmt_user->close();
    } else {
        echo "<h3 style='text-align:center;padding:20px;'>Nome utente o password errati!</h3>";
    }
} else {
    echo("effettua il login");
}