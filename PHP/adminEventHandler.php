<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    $dbAccess = new DBAccess();
    require_once "UtilityFunctions.php";
    use UtilityFunctions\UtilityFunctions;
    session_start();
    if(!isset($_SESSION["username"],$_SESSION["email"],$_SESSION["isValid"]) && !$_SESSION["isValid"])
    {
        header("Location: ../PHP/login.php");
    }
    else
    {
        $url="../HTML/Administrator.html";
        if($_POST["Aggiungi"])
        {
            if(isset($_POST["aggNomepizza"],$_POST["aggCategoriapizza"],$_POST["aggPrezzo"],$_POST["aggDesc"]))
            {
                $npizza = $_POST["aggNomepizza"];
                $catpizza = $_POST["aggCategoriapizza"];
                $prez = $_POST["aggPrezzo"];
                $des = $_POST["aggDesc"];

                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->addPizza($npizza,$catpizza, $prez, $des);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result==true)
                {
                    $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box success\">Pizza Aggiunta con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della pizza!</p>");
                }
                
                echo UtilityFunctions::replacer($url, $replace);
            }
            else
            {
                $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della pizza!</p>");
                echo UtilityFunctions::replacer($url, $replace);
            }
        }
        else
        {
            if($_POST["Modifica"])
            {
                if(isset($_POST["updateNomepizza"],$_POST["updateCategoriapizza"],$_POST["updatePrezzo"],$_POST["updateDesc"])&&$_POST["updateNomepizza"]!=""&&$_POST["updateCategoria"]!=""&&$_POST["updatePrezzo"]!="")
            {
                $npizza = $_POST["updateNomepizza"];
                $catpizza = $_POST["updateCategoriapizza"];
                $prez = $_POST["updatePrezzo"];
                $des = $_POST["updateDesc"];

                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->updatePizza($npizza,$catpizza, $prez, $des);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result)
                {
                    $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box success\">Pizza Modificata con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della pizza!</p>");
                }
                
                echo UtilityFunctions::replacer($url, $replace);
            }
            else
            {
                $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della pizza!</p>");
                echo UtilityFunctions::replacer($url, $replace);
            }
            }
        }
    }
?>