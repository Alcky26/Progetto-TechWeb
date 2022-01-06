<?php

$_SESSION['user'] = 'mmasetto@unipd.it';
$_SESSION['password'] = 'password';

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK) {
    if($GLOBALS['connessione']->deleteAccount($_SESSION['user'])) {
        unset($_SESSION['user'], $_SESSION['password']);
    }
}

?>
