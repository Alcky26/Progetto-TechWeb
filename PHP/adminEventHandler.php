<?php
require_once "connectionDB.php";
require_once "Administrator.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"])){
    header("Location: ../PHP/login.php");
}
else{
    $url="../HTML/Administrator.html";
    if(isset($_POST["Annulla"])){
        $cosa=$_POST["qualeSost"];
        $replace=array($cosa => "<p class=\"alert-box success\">Annullato con successo!</p>");
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    if(isset($_POST["AggiungiPiz"])){
        if(isset($_POST["aggNomepizza"],$_POST["aggCategoriapizza"],$_POST["aggPrezzo"],$_POST["aggDesc"],$_POST["aggIngre"],$_POST["aggIngreId"])){
            $npizza = $_POST["aggNomepizza"];
            $catpizza = $_POST["aggCategoriapizza"];
            $prez = $_POST["aggPrezzo"];
            $des = $_POST["aggDesc"];
            $iding = $_POST["aggIngreId"];
            
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $result=false;
            if($connessioneRiuscita)
            {
                $result = $dbAccess->addPizza($npizza,$catpizza, $prez, $des, $iding);
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
        }
        else
        {
            $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della pizza!</p>");
        }
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    else{
        if(isset($_POST["ModificaPiz"])){
            if(isset($_POST["updNomepizza"],$_POST["updCategoriapizza"],$_POST["updPrezzo"],$_POST["updDesc"],$_POST["aggIngreUpd"],$_POST["aggIngreIdUpd"]))
            {
                $npizza = $_POST["updNomepizza"];
                $catpizza = $_POST["updCategoriapizza"];
                $prez = $_POST["updPrezzo"];
                $des = $_POST["updDesc"];
                $idingre = $_POST["aggIngreIdUpd"];

                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->updatePizza($npizza,$catpizza, $prez, $des, $idingre);
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
                
            }
            else
            {
                $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della pizza!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
            echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
        }
        else{
            if(isset($_POST["EliminaPiz"])){
                if(isset($_POST["delPiz"]))
                {
                    $txt = explode("---", $_POST["delPiz"]);
                    $delete = $txt[0]; 

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->delPizza($delete);
                    }
                    $dbAccess->closeDBConnection();

                    
                    if($result==true)
                    {
                        $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box success\">Pizza eliminata con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della pizza!</p>");
                    }
                }
                else
                {
                    $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della pizza!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
                echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
            }
        }
    }
    
    if(isset($_POST["AggiungiBev"])){
        if(isset($_POST["aggNomebevanda"],$_POST["aggCategoriabevanda"],$_POST["aggGradi"],$_POST["aggDescbev"],$_POST["aggPrezzoBev"])){
            $nbevanda = $_POST["aggNomebevanda"];
            $catbevanda = $_POST["aggCategoriabevanda"];
            $gradi = $_POST["aggGradi"];
            $des = $_POST["aggDescbev"];
            $prezzo = $_POST["aggPrezzoBev"];
            
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $result=false;
            if($connessioneRiuscita)
            {
                $result = $dbAccess->addBevanda($nbevanda,$catbevanda, $gradi, $des, $prezzo);
            }
            $dbAccess->closeDBConnection();
            $replace="";
            if($result)
            {
                $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box success\">Bevanda Aggiunta con successo!</p>");
                
            }
            else
            {
                $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della bevanda!</p>");
            }
        }
        else
        {
            $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della bevanda!</p>");
        }
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    else{
        if(isset($_POST["ModificaBev"])){
            if(isset($_POST["aggNomebevandaMod"],$_POST["aggCategoriabevandaMod"],$_POST["aggGradiMod"],$_POST["aggDescbevMod"],$_POST["aggPrezzoBevMod"]))
            {
                $nbevanda = $_POST["aggNomebevandaMod"];
                $catbevanda = $_POST["aggCategoriabevandaMod"];
                $prez = $_POST["aggPrezzoBevMod"];
                $des = $_POST["aggDescbevMod"];
                $gradi = $_POST["aggGradiMod"];

                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->updateBevanda($nbevanda,$catbevanda, $prez, $des, $gradi);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result)
                {
                    $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box success\">Bevanda Modificata con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della bevanda!</p>");
                }
                
            }
            else
            {
                $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della bevanda!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
                
        }
        else{
            if(isset($_POST["EliminaBev"])){
                if(isset($_POST["delBev"]))
                {
                    $txt = $_POST["delBev"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->delBevanda($txt);
                    }
                    $dbAccess->closeDBConnection();

                    
                    if($result==true)
                    {
                        $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box success\">Bevanda eliminata con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della bevanda!</p>");
                    }
                }
                else
                {
                    $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della bevanda!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
                echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
            }
        }
    }
    

    if(isset($_POST["AggiungiDolce"])){
        if(isset($_POST["aggNomedolce"],$_POST["aggPrezzoDolce"],$_POST["aggDescdolce"])){
            $ndolce = $_POST["aggNomedolce"];
            $des = $_POST["aggDescdolce"];
            $prezzo = $_POST["aggPrezzoDolce"];
            
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $result=false;
            if($connessioneRiuscita)
            {
                $result = $dbAccess->addDolce($ndolce, $des, $prezzo);
            }
            $dbAccess->closeDBConnection();

            $replace="";
            if($result==true)
            {
                $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box success\">Dolce Aggiunto con successo!</p>");
                
            }
            else
            {
                $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento del dolce!</p>");
            }
        }
        else
        {
            $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento del dolce!</p>");
        }
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    else{
        if(isset($_POST["ModificaDolce"])){
            if(isset($_POST["aggNomedolceMod"],$_POST["aggPrezzodolceMod"],$_POST["aggDescdolceMod"]))
            {
                $ndolce = $_POST["aggNomedolceMod"];
                $prez = $_POST["aggPrezzodolceMod"];
                $des = $_POST["aggDescdolceMod"];

                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->updateDolce($ndolce, $prez, $des);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result)
                {
                    $replace = array("<messaggioDolceModificata />" => "<p class=\"alert-box success\">Dolce Modificato con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioDolceModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del dolce!</p>");
                }
                
            }
            else
            {
                $replace = array("<messaggioDolceModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del dolce!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
            echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
                
        }
        else{
            if(isset($_POST["EliminaDolce"])){
                if(isset($_POST["delDolce"]))
                {
                    $delete = $_POST["delDolce"]; 

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->delDolce($delete);
                    }
                    $dbAccess->closeDBConnection();

                    
                    if($result==true)
                    {
                        $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box success\">Dolce Eliminato con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione del dolce!</p>");
                    }
                }
                else
                {
                    $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione del dolce!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
                echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
            }
        }
    }
    

    if(isset($_POST["AggiungiIngre"])){
        if(isset($_POST["aggNomeingred"],$_POST["aggCategoriaIngrediente"])){
            $ningrediente = $_POST["aggNomeingred"];
            $categoria = $_POST["aggCategoriaIngrediente"];
            
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $result=false;
            if($connessioneRiuscita)
            {
                $result = $dbAccess->addIngrediente($ningrediente, $categoria);
            }
            $dbAccess->closeDBConnection();

            $replace="";
            if($result==true)
            {
                $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box success\">Ingrediente Aggiunto con successo!</p>");
                
            }
            else
            {
                $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento dell'ingrediente!</p>");
            }
        }
        else
        {
            $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento dell'ingrediente!</p>");
        }
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    else{
        if(isset($_POST["ModificaIngrediente"])){
            if(isset($_POST["aggNomeingredienteMod"],$_POST["aggCategoriaIngredienteMod"],$_POST["oldIdMod"]))
            {
                $ningred = $_POST["aggNomeingredienteMod"];
                $catallerg = $_POST["aggCategoriaIngredienteMod"];
                $idvecchio = $_POST["oldIdMod"];

                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->updateIngrediente($ningred, $catallerg, $idvecchio);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result)
                {
                    $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box success\">Ingrediente Modificato con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box danger\">Errore nella modifica dell'ingrediente!</p>");
                }
                
            }
            else
            {
                $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del'ingrediente!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
            echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
                
        }
        else{
            if(isset($_POST["EliminaIngrediente"])){
                if(isset($_POST["oldIdIngr"]))
                {
                    $delete = $_POST["oldIdIngr"]; 

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->delIngrediente($delete);
                    }
                    $dbAccess->closeDBConnection();

                    
                    if($result==true)
                    {
                        $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box success\">Ingrediente Eliminato con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione dell'ingrediente!</p>");
                    }
                }
                else
                {
                    $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione dell'ingrediente!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
                echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
            }
            
        }
    }
}
?>