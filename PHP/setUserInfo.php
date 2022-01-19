<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$result = NULL;

if (isset($_SESSION["email"], $_POST["email"], $_POST["username"], $_POST["pwd"], $_POST["birthday"])) {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();

    if($connessioneOK) {
        $GLOBALS["result"] = $GLOBALS["connessione"]->setUserInfo($_SESSION["email"], $_POST["email"], $_POST["username"], $_POST["pwd"], $_POST["birthday"]);
        $connessione->closeDBConnection();
        if($GLOBALS["result"]) {
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["username"] = $_POST["username"];
        }
    }
}

if ($GLOBALS["result"] === NULL)
    header("Location: area_utente.php");
else
    header("Location: area_utente.php?result=$result");

?>
