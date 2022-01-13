<?php

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
session_start();
if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"]))
{
    header("Location: ../PHP/login.php");
}

$connessioneOK = $connessione->openDBConnection();
if ($connessioneOK) 
{
    
    $updateFill = $connessione->FillTemporaneo();
    $dbAccess->closeDBConnection();
    var_dump($updateFill);
    die;
    require_once "UtilityFunctions.php";
    $url = "../HTML/Administrator.html";

    $replace = array("pizzapholder" => $updateFill[0],
                    "categoriapholder" => $updateFill[1],
                    "prezzopholder" => $updateFill[2],
                    "descrizionepholder" => $updateFill[3]);
    echo UtilityFunctions::replacer($url, $replace);
}

?>