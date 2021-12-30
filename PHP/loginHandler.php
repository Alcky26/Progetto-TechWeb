<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["eml"], $_POST["pwd"])) {
        header("Location: ../login.php");
        die;
    }

    $email = $_POST["eml"];
    $password = $_POST["pwd"];
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();

    //CONNESSIONE FALLITA
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }

    session_start();

    //ACCEDI
    $result = $dbAccess->checkUserAndPassword($email, $password);
    $dbAccess->closeDBConnection();
    $_SESSION["isValid"] = $result["isValid"];


    if($_SESSION["isValid"]) {
        $_SESSION["email"] = $result["email"];
        header("Location: ../HTML/index.html");
    } else {
        $messaggio = "Dati non corretti";
        header("Location: ../PHP/login.php?messaggio=$messaggio");
    }
   
?>