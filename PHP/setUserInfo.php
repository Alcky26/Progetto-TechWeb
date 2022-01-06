<?php

$_SESSION['user'] = 'mmasetto@unipd.it';
$_SESSION['password'] = 'password';

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK) {
    if($GLOBALS['connessione']->setUserInfo($_SESSION['user'], $_POST['email'], $_POST['pwd'])) {
        $_SESSION['user'] = $_POST['email'];
        $_SESSION['password'] = $_POST['pwd'];
    }
}

?>
