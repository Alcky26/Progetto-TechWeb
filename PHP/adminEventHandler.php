<?php
require_once "connectionDB.php";
require_once "Administrator.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
session_start();
if(!isset($_SESSION["username"],$_SESSION["email"],$_SESSION["isValid"]) && !$_SESSION["isValid"]){
    header("Location: ../PHP/login.php");
}
else{
    $url="../HTML/Administrator.html";
    if(isset($_POST["itemNamePizUpd"])){
        $pizzaScelta = $_POST["itemNamePizUpd"];
        $connessioneRiuscita = $dbAccess->openDBConnection();
        if($connessioneRiuscita)
        {
            $result = $dbAccess->selectPizza($pizzaScelta);
        }
        $dbAccess->closeDBConnection();

        $nome = $result[1]["nome"];
        $id = $result[1]["id_ingrediente"];
        $stringaIngre = $nome;
        $stringaIdIngre = $id;
        for($i=2;$i<count($result);$i++)
        {
            $nome = $result[$i]["nome"];
            $id = $result[$i]["id_ingrediente"];
            $stringaIngre = $stringaIngre."-".$nome;
            $stringaIdIngre = $stringaIdIngre."-".$id;
        }
        $replace=array("<interfacciaModifica/>" => 
        "<label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
        <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" value='".$result[0]["nome"]."' required/>
        <label for=\"text\" lang=\"ITA\">Categoria:</label>
        <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" value='".$result[0]["categoria"]."' required/>
        <label for=\"number\" lang=\"ITA\">Prezzo:</label>
        <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" value='".$result[0]["prezzo"]."' required/>
        <label for=\"text\" lang=\"ITA\">Descrizione: </label>
        <input type=\"text\" name=\"updDesc\" id=\"updDesc\" maxlenght=\"500\" value='".$result[0]["descrizione"]."'/>
        <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
        <ul>
            <li id=\"ingredient\" class=\"dropdown\">
            <a class=\"text-button dropbtn\">Ingrediente</a>
            <ul class=\"dropdown-content\">
                <listaIngredientiUpdate/>
            </ul>
            </li>
        </ul>
        <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value='".$stringaIngre."'  required/>
        <input type=\"text\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value='".$stringaIdIngre."' required/>
        <input type=\"text\" name=\"oldName\" id=\"oldName\" class=\"invIdIng\" value='".$result[0]["nome"]."' required/>
        <button type=\"button\" class=\"text-button\" onclick=\"removeItemUpd()\">Elimina ultimo ingrediente</button>"
        );
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        
    }
    else{
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
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        }
        else{
            if(isset($_POST["ModificaiPiz"])){
                if(isset($_POST["updNomepizza"],$_POST["updCategoriapizza"],$_POST["updPrezzo"],$_POST["updDesc"],$_POST["aggIngreUpd"],$_POST["aggIngreIdUpd"],$_POST["oldName"]))
                {
                    $npizza = $_POST["updNomepizza"];
                    $catpizza = $_POST["updCategoriapizza"];
                    $prez = $_POST["updPrezzo"];
                    $des = $_POST["updDesc"];
                    $idingre = $_POST["aggIngreIdUpd"];
                    $nomevecchio = $_POST["oldName"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->updatePizza($npizza,$catpizza, $prez, $des, $idingre, $nomevecchio);
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
                $stringHTML = UtilityFunctions::replacer($url, $replace);
                echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
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
                    $stringHTML = UtilityFunctions::replacer($url, $replace);
                    echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                }
            }
        }
    }
}

?>