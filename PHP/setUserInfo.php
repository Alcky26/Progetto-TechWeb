<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

header("Content-type: application/json");

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK) {
    $result = $GLOBALS["connessione"]->setUserInfo($_SESSION["email"], $_POST["email"], $_POST["username"], $_POST["pwd"], $_POST["birthday"]);
    $connessione->closeDBConnection();
    if($result) {
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["username"] = $_POST["username"];
    }
    echo json_encode(array("success" => $result));
}

?>
