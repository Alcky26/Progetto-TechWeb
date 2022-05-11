<?php

session_start();

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

if (isset($_SESSION["email"])) {

    $result = $bonus = $prenotazioni = $acquisti = "";

    ob_start();
    if (isset($_GET["result"]))
        $result = "<div class=\"subcontainer ".($_GET["result"] ? "success\"><p>Modifiche salvate." : "danger\"><p>Errore nell' inserimento dei dati. Ricordati che non puoi modificare la data del tuo compleanno più di una volta.")."</p></div>";
    $bonus = include "utenteBonus.php";
    $prenotazioni = include "utentePrenotazioni.php";
    $acquisti = include "utenteAcquisti.php";
    ob_end_clean();
    $url = "../HTML/area_utente.html";
    $replace = array("<result />" => $result,
                     "<bonus />" => $bonus,
                     "<prenotazioni />" => $prenotazioni,
                     "<acquisti />" => $acquisti);

    echo UtilityFunctions::replacer($url, $replace);

} else {
    echo file_get_contents("../HTML/login.html");
}

?>
