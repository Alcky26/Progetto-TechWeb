<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();

$messaggio = isset($_GET["msg"]) ? "<span id=\"datiNonCorretti\">" . $_GET["msg"] . "</span>" : "";

$nuovo = array(
    "<msgErrore/>" => $messaggio
);

echo UtilityFunctions::replacer("../HTML/login.html", $nuovo);
?>
