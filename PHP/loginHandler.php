<?php

    require_once "connectionDB.php";
    use DB\DBAccess;
    
    use UtilityFunctions\UtilityFunctions;
    if(!isset($_POST["username"], $_POST["pwd"]) && !isset($_POST["registrazione"])) {
        header("Location: ../HTML/login.html");
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
            $_SESSION["isValid"] = $result["isValid"];
            $_SESSION["isAdmin"] = $result["isAdmin"];
            if($_SESSION["isValid"])
            {
                $_SESSION["email"] = $result["email"];
                $_SESSION["username"] = $dbAccess->getUserInfo($result["email"])[0]["username"];
                $dbAccess->closeDBConnection();
                if(!$_SESSION["isAdmin"])
                {
                    header("Location: ../PHP/area_utente.php");
                }
                else
                {
                    header("Location: ../HTML/Administrator.html");
                }
            }
            else
            {
                require_once "UtilityFunctions.php";
                $messaggio = "<p class=\"alert-box danger\" id=\"datiNonCorretti\">Dati non corretti</p>";
                $nuovo = array(
                    "<msgErrore/>" => $messaggio
                );

                echo UtilityFunctions::replacer("../HTML/login.html", $nuovo);
            }
        }
    }
?>
