<?php

    require_once "connectionDB.php";
    use DB\DBAccess;
    if(!isset($_POST["username"], $_POST["pwd"]) && !isset($_POST["registrazione"])) {
        header("Location: ../PHP/login.php");
    }
    else
    {
        $username = $_POST["username"];
        $password = $_POST["pwd"];
        
        $dbAccess = new DBAccess();
        $connessioneRiuscita = $dbAccess->openDBConnection();
        /*//CONNESSIONE FALLITA
        if(!$connessioneRiuscita) {
            header("Location: ../PHP/error_500.php");
            die;
        }*/
        
        if(isset($_POST["registrazione"]))
        {
            header("Location: ../HTML/signup.html");
        }
        else
        {
            session_start();
            //ACCEDI
            $result = $dbAccess->checkLogin($username, $password);
            $dbAccess->closeDBConnection();
            $_SESSION["isValid"] = $result["isValid"];
            $_SESSION["isAdmin"] = $result["isAdmin"];
            if($_SESSION["isValid"]) 
            {
                if(!$_SESSION["isAdmin"])
                {
                    $_SESSION["username"] = $result["username"];
                    header("Location: ../HTML/area_utente.html");//poi indirizzare ad un area riservata o simile
                }
                else
                {
                    header("Location: ../HTML/Administrator.html");//Area di gestione
                }
            } 
            else 
            {
                $messaggio = "Dati non corretti";
                header("Location: ../PHP/login.php?msg=$messaggio");
            }
        }
    }
?>