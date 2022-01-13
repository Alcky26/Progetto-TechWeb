<?php

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"]))
{
    header("Location: ../PHP/login.php");
}

$categories = array("", "", "", "");

if ($connessioneOK) {
    $categories[0] = pizze();
    $categories[1] = bevande();
    $categories[2] = dolci();
} else {
    foreach ($i as $categories) {
        $i = "<div class=\"subcontainer\"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>";
    }
}

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

$url = "../HTML/Administrator.html";

$replace = array("<listaPizze />" => $categories[0],
                 "<listaBevande />" => $categories[1],
                 "<listaDolci />" => $categories[2],

echo UtilityFunctions::replacer($url, $replace);

function fill($array, $listino) {
    $string = "<div class=\"subcontainer grid-subcontainer\">";
    foreach ($array as $i) {
        $string = $string."<div class=\"subsubcontainer\"><h3></h3>";
        switch ($listino) {
            case "pizza":
                break;
            case "bevanda":
                }
                break;
            case "dolce":
                break;
        }
        $string = $string."</div>";
    }
    return $string."</div>";
}
?>
