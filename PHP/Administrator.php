<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;


function checkadmin(){
    $connessione = new DBAccess();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"]))
    {
        header("Location: ../PHP/login.php");
    }

    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $replace=addReplaceFinali();
        $connessione->closeDBConnection();
        $url = "../HTML/Administrator.html";
        echo UtilityFunctions::replacer($url, $replace);
    }
}

function addReplaceFinali()
{
    $aggiungiFill = fillIngredienti("aggiungi");
    $updateFillIngr = fillIngredienti("modifica");
    $deleteFill = fillPizzeDel();
    $updateFill = fillPizzeUpd();

    $add = array("<listaIngredienti/>" => $aggiungiFill,
                    "<listaPizzeDel/>" => $deleteFill,
                    "<listaPizzeUpd/>" => $updateFill,
                    "<listaIngredientiUpdate/>" => $updateFillIngr);
    
    return $add;
}

function fillIngredienti($tipologia) {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getIngredienti();
        $connessione->closeDBConnection();
        if ($result != null) {
            if($tipologia=="aggiungi"){

                return fill($result, "ingrediente");
            }
            else
            {
                if($tipologia=="modifica")
                {
                    return fill($result, "ingredienteModifica");
                }
            }
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillPizzeDel() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getPizze();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "pizzeDel");
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillPizzeUpd() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getPizze();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "pizzeUpd");
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fill($array, $listino) 
{
    $string="";
    switch($listino)
    {
        case "ingrediente": 
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItem(this)\" class=\"itemName\">".$i['nome']."</a><div class=\"idIng\">".$i["id_ingrediente"]."</div></li>";
            }
        break;
        case "ingredienteModifica": 
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemUpd(this)\" class=\"itemNameUpd\">".$i['nome']."</a><div class=\"idIngUpd\">".$i["id_ingrediente"]."</div></li>";
            }
        break;
        case "pizzeDel":
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemToDel(this)\" class=\"itemNamePizDel\">".$i['nome']."---".$i["categoria"]."</a></li>";
            }
        break;
        case "pizzeUpd":
            foreach ($array as $i) {
                $string = $string."
                <li>
                    <form id=\"upd-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <input type=\"submit\" class=\"pizza-link\" name =\"itemNamePizUpd\" id=\"itemNamePizUpd\" value='".$i['nome']."'></button>
                    </form>
                </li>";
            }
        break;
    }
    return $string;
}
?>