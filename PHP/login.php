<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();

$messaggio = isset($_GET["messaggio"]) ? "<p id=\"datiNonCorretti\">" . $_GET["messaggio"] . "</p>" : "";

$content = array(
    "<msgErrore/>" => $messaggio
);

echo UtilityFunctions::replacer("../HTML/login.html", $content);
?>