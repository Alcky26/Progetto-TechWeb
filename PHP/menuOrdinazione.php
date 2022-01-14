<?php

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

session_start();
$categories = array("", "", "", "", "", "", "", "");

if ($connessioneOK) {
    $categories[0] = fillClassiche();
    $categories[1] = fillSpeciali();
    $categories[2] = fillBianche();
    $categories[3] = fillCalzoni();
    $categories[4] = fillBevande();
    $categories[5] = fillBirre();
    $categories[6] = fillVini();
    $categories[7] = fillDolci();
} else {
    foreach ($i as $categories) {
        $i = "<div class=\"subcontainer\"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>";
    }
}

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

//$url = "../HTML/menu.html";
$url = "../HTML/ordinazione.html";

$replace = array("<listaClassiche />" => $categories[0],
                 "<listaSpeciali />" => $categories[1],
                 "<listaBianche />" => $categories[2],
                 "<listaCalzoni />" => $categories[3],
                 "<listaBevande />" => $categories[4],
                 "<listaBirre />" => $categories[5],
                 "<listaVini />" => $categories[6],
                 "<listaDolci />" => $categories[7]);

echo UtilityFunctions::replacer($url, $replace);


function fill($array, $listino) {
    $string = "<div class=\"subcontainer grid-subcontainer\">";
    foreach ($array as $i) {
        $string = $string."<div class=\"subsubcontainer\"><h3><span class=\"itemName\">".$i['nome']."</span> (<span class=\"itemPrice\">".$i['prezzo']."&euro;</span>)</h3>";
        switch ($listino) {
            case "pizza":
                $ingredienti = $GLOBALS['connessione']->getIngredients($i['nome']);
                if ($ingredienti != null) {
                    $string = $string."<p>";
                    foreach ($ingredienti as $j) {
                        if ($j['allergene']) {
                            $string = $string."<span class = \"allergene allergene-".$j['allergene']."\">".$j['nome']."</span>, ";
                        } else {
                            $string = $string.$j['nome'].", ";
                        }
                    }
                    $string = substr($string, 0, -2)."</p>";
                }
                break;
            case "bevanda":
                if ($i['gradiAlcolici'] != 0) {
                    $string = $string."<p>".$i['gradiAlcolici']."%</p>";
                }
                break;
            case "dolce":
                break;
        }
        if ($i['descrizione'] != null) {
            $string = $string."<p>".$i['descrizione']."</p>";
        }
        $string = $string."<button type=\"button\" onclick=\"addItem(this)\" class=\"item_add button\" />Aggiungi</button> </div>";
    }
    return $string."</div>";
}

function fillClassiche() {
    $result = $GLOBALS['connessione']->getClassiche();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillSpeciali() {
    $result = $GLOBALS['connessione']->getSpeciali();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillBianche() {
    $result = $GLOBALS['connessione']->getBianche();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillCalzoni() {
    $result = $GLOBALS['connessione']->getCalzoni();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillBevande() {
    $result = $GLOBALS['connessione']->getBevande();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillBirre() {
    $result = $GLOBALS['connessione']->getBirre();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillVini() {
    $result = $GLOBALS['connessione']->getVini();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function fillDolci() {
    $result = $GLOBALS['connessione']->getDolci();
    if ($result != null) {
        return fill($result, "dolce");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

?>
