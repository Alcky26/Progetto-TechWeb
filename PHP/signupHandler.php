<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["usr"],$_POST["eml"], $_POST["pwd"])) {
        header("Location: ../signup.php");
        die;
    }
    $email = $_POST["eml"];
    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $clickAccesso= in_array("Accesso",$_POST);
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    //CONNESSIONE FALLITA
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }
    if($clickAccesso)
    {
        header("Location: ../PHP/login.html");
    }

    session_start();

    $result = $dbAccess->createNew($email,$username, $password);
    $dbAccess->closeDBConnection();
    $_SESSION["risultato"] = $result;
    if($_SESSION["risultato"])
    {
        $messaggio = "Registrazione effettuata!";
        header("Location: ../HTML/signup.php?msgt=$messaggio");
    }
    else
    {
        $messaggio = "Email o Username già in uso";
        header("Location: ../PHP/signup.php?msgf=$messaggio");
    }
?>