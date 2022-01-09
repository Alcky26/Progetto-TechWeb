<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK) {
    if($GLOBALS["connessione"]->deleteAccount($_SESSION["email"])) {
        unset($_SESSION["email"], $_SESSION["username"], $_SESSION["isValid"], $_SESSION["isAdmin"]);
        session_destroy();
    }
    $connessione->closeDBConnection();
}

?>
