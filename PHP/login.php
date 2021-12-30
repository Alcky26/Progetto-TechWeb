<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();

$messaggio = isset($_GET["msg"]) ? "<p id=\"datiNonCorretti\">" . $_GET["msg"] . "</p>" : "";

$nuovo = array(
    "<msgErrore/>" => $messaggio
);

echo UtilityFunctions::replacer("../HTML/login.html", $nuovo);
?>