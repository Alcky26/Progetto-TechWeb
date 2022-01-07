<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["username"],$_POST["email"], $_POST["pwd"])) {
        header("Location: ../PHP/signup.php");
    }
    else
    {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["pwd"];
        //$clickAccesso= in_array("Accesso",$_POST);
        
        $dbAccess = new DBAccess();
        $connessioneRiuscita = $dbAccess->openDBConnection();
        /*//CONNESSIONE FALLITA
        if(!$connessioneRiuscita) {
            header("Location: ../PHP/error_500.php");
            die;
        }*/
        //if($clickAccesso)
        //{
        //    header("Location: ../PHP/login.html");
        //}
        //else
        //{
            session_start();

            $result = $dbAccess->createNewUser($email,$username, $password);
            $dbAccess->closeDBConnection();
            $_SESSION["risultato"] = $result;

            if($_SESSION["risultato"])
            {
                $messaggio = "Registrazione effettuata!";
                header("Location: ../PHP/login.php?msg=$messaggio");//???? cosìì???
            }
            else
            {
                $messaggio = "Email o Username già in uso";
                header("Location: ../PHP/signup.php?msgf=$messaggio");
            }
        //}
    }
?>