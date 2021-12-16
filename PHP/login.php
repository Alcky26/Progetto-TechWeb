<?php

require_once "UtilityFunctions.php";
use UtilityFuntions\UtilityFuntions;

session_start();

$messaggio = isset($_GET["messaggio"]) ? "<p id=\"datiNonCorretti\">" . $_GET["messaggio"] . "</p>" : "";

$content = array(
    "<msgErrore/>" => $messaggio
);

echo UtilityFuntions::replacer("../HTML/login.html", $content);
?>