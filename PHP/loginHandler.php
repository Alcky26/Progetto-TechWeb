<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["usr"], $_POST["pwd"])) {
        header("Location: ../login.php");
        die;
    }

    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $clickRegistrazione= in_array("REGITRATI",$_POST);
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    //CONNESSIONE FALLITA
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }

    session_start();
    if($clickRegistrazione)
    {
        header("Location: ../PHP/signup.php");
    }

    //ACCEDI
    $result = $dbAccess->checkLogin($username, $password);
    $dbAccess->closeDBConnection();
    $_SESSION["isValid"] = $result["isValid"];


    if($_SESSION["isValid"]) {
        $_SESSION["username"] = $result["username"];
        header("Location: ../HTML/index.html");//poi indirizzare ad un area riservata o simile
    } else {
        $messaggio = "Dati non corretti";
        header("Location: ../PHP/login.php?msg=$messaggio");
    }
   
?>