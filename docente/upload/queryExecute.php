<?php
require('../read/validate.php');
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$query = $_POST['query'];
$res = $mydb->prepare($query);
if($res->execute()){
    echo ('query eseguita con successo.');
}
?>
