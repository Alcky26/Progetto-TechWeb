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
    $deleteFillIngr = fillIngredienti("elimina");
    $deleteFill = fillPizzeDel();
    $updateFill = fillPizzeUpd();
    $deleteFillBev = fillBevandaDel();
    $updateFillBev = fillBevandaUpd();
    $deleteFillDolce = fillDolceDel();
    $updateFillDolce = fillDolceUpd();
    $updateFillIngrediente = fillIngredienteUpd();

    $add = array("<listaIngredienti/>" => $aggiungiFill,
                    "<listaPizzeDel/>" => $deleteFill,
                    "<listaPizzeUpd/>" => $updateFill,
                    "<istaBevandaDel/>" => $deleteFillBev,
                    "<listaBevandeUpd/>" => $updateFillBev,
                    "<istaDolceDel/>" => $deleteFillDolce,
                    "<listaDolceUpd/>" => $updateFillDolce,
                    "<listaIngredienteUpd/>" => $updateFillIngrediente,
                    "<listaIngredientiUpdate/>" => $updateFillIngr),
                    "<listaIngredientiElimina/>" => $deleteFillIngr);
    
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
                else
                {
                    if($tipologia=="elimina")
                {
                    return fill($result, "ingredienteElimina");
                }
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

function fillBevandaDel() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getListBevande();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "bevandaDel");
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillDolceDel() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getListDolci();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "dolciDel");
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

function fillBevandaUpd() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getListBevande();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "bevandeUpd");
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillDolceUpd() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getListDolci();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "dolciUpd");
        }
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillIngredienteUpd() {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) 
    {
        $result = $connessione->getIngredienti();
        $connessione->closeDBConnection();
        if ($result != null) {
            return fill($result, "ingredientiUpd");
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
        case "ingredienteElimina": 
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemToDelIngre(this)\" class=\"ingredNameUpd\">".$i['nome']."</a><div class=\"idIngdel\">".$i["id_ingrediente"]."</div></li>";
            }
        break;
        case "pizzeDel":
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemToDel(this)\" class=\"itemNamePizDel\">".$i['nome']."---".$i["categoria"]."</a></li>";
            }
        break;
        case "bevandaDel":
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemToDelBev(this)\" class=\"itemNameBevDel\">".$i['nome']."---".$i["categoria"]."</a></li>";
            }
        break;
        case "dolciDel":
            foreach ($array as $i) {
                $string = $string."<li><a onclick=\"addItemToDelDolce(this)\" class=\"itemNameBevDolce\">".$i['nome']."</a></li>";
            }
        break;
        case "pizzeUpd":
            foreach ($array as $i) {
                $string = $string."
                <li>
                    <form id=\"upd-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <input type=\"submit\" class=\"pizza-link\" name =\"itemNamePizUpd\" id=\"itemNamePizUpd\" value='".$i['nome']."'></input>
                    </form>
                </li>";
            }
        break;
        case "bevandeUpd":
            foreach ($array as $i) {
                $string = $string."
                <li>
                    <form id=\"upd-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <input type=\"submit\" class=\"bevanda-link\" name =\"itemNameBevUpd\" id=\"itemNameBevUpd\" value='".$i['nome']."'></input>
                    </form>
                </li>";
            }
        break;
        case "dolciUpd":
            foreach ($array as $i) {
                $string = $string."
                <li>
                    <form id=\"upd-dolci-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <input type=\"submit\" class=\"dolce-link\" name =\"itemNameDolceUpd\" id=\"itemNameDolceUpd\" value='".$i['nome']."'></input>
                    </form>
                </li>";
            }
        break;
        case "ingredientiUpd":
            foreach ($array as $i) {
                $string = $string."
                <li>
                    <form id=\"upd-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <input type=\"text\" class=\"idIngdel\" name =\"itemNameIngredienteUpd\" id=\"itemNameIngredienteUpd\" value='".$i["id_ingrediente"]."'></input>
                        <input type=\"submit\" class=\"ingrediente-link\" name =\"itemNameIngredienteUpd\" id=\"itemNameIngredienteUpd\" value='".$i['nome']."'></input>
                    </form>
                </li>";
            }
        break;
    }
    return $string;
}
?>