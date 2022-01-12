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
        if(isset($_POST["aggnomepizza"],$_POST["aggcategoriapizza"],$_POST["aggprezzo"],$_POST["aggdesc"]))
        {
            $npizza = $_POST["aggnomepizza"];
            $catpizza = $_POST["aggcategoriapizza"];
            $prez = $_POST["aggprezzo"];
            $des = $_POST["aggdesc"];

            
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $result=false;
            if($connessioneRiuscita)
            {
                $result = $dbAccess->addPizza($npizza,$catpizza, $prez, $des);
            }
            $dbAccess->closeDBConnection();

            $replace="";
            if($result)
            {
                $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Pizza Aggiunta con successo!</p>");
                
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
?>