<?php

require_once "connectionDB.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$categories = array("", "", "", "", "", "", "", "");

if ($connessioneOK) {
    $categories[0] = classiche();
    $categories[1] = speciali();
    $categories[2] = bianche();
    $categories[3] = calzoni();
    $categories[4] = bevande();
    $categories[5] = birre();
    $categories[6] = vini();
    $categories[7] = dolci();
} else {
    foreach ($i as $categories) {
        $i = "<div class=\"subcontainer\"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>";
    }
}
$connessione->closeDBConnection();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

$url = "../HTML/menu.html";
//$url = "../HTML/ordinazione.html";

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
        $string = $string."<div class=\"subsubcontainer\"><h3>".$i['nome']." (".$i['prezzo']."&euro;)</h3>";
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
        $string = $string."</div>";
    }
    return $string."</div>";
}

function classiche() {
    $result = $GLOBALS['connessione']->getClassiche();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function speciali() {
    $result = $GLOBALS['connessione']->getSpeciali();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function bianche() {
    $result = $GLOBALS['connessione']->getBianche();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function calzoni() {
    $result = $GLOBALS['connessione']->getCalzoni();
    if ($result != null) {
        return fill($result, "pizza");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function bevande() {
    $result = $GLOBALS['connessione']->getBevande();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function birre() {
    $result = $GLOBALS['connessione']->getBirre();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function vini() {
    $result = $GLOBALS['connessione']->getVini();
    if ($result != null) {
        return fill($result, "bevanda");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

function dolci() {
    $result = $GLOBALS['connessione']->getDolci();
    if ($result != null) {
        return fill($result, "dolce");
    }
    return "<div class=\"subcontainer\"><p>Al momento non è disponibile nessun articolo.</p></div>";
}

?>
