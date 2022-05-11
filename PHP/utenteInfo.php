<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();

    if ($connessioneOK) {
        $user = $GLOBALS["connessione"]->getUserInfo($_SESSION["email"])[0];
        $connessione->closeDBConnection();
        echo json_encode($user);
    }
}

 ?>
