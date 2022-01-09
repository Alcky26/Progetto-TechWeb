<?php

    require_once "connectionDB.php";
    use DB\DBAccess;
    if(!isset($_POST["username"], $_POST["pwd"]) && !isset($_POST["registrazione"])) {
        header("Location: ../PHP/login.php");
    }
    else
    {
        $email = $_POST["email"];
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
            $result = $dbAccess->checkLogin($email, $username, $password);
            $_SESSION["isValid"] = $result["isValid"];
            $_SESSION["isAdmin"] = $result["isAdmin"];
            if($_SESSION["isValid"])
            {
                if(!$_SESSION["isAdmin"])
                {
                    $_SESSION["email"] = $result["email"];
                    $_SESSION["username"] = $dbAccess->getUserInfo($result["email"])[0]["username"];
                    header("Location: ../PHP/area_utente.php");//poi indirizzare ad un area riservata o simile
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
        $dbAccess->closeDBConnection();
    }
?>
