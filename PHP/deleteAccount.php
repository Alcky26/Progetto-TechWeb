<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK) {
    if($GLOBALS["connessione"]->deleteAccount($_SESSION["email"])) {
        session_destroy();
    }
    $connessione->closeDBConnection();
}

header("Location: ../HTML/index.html");

?>
