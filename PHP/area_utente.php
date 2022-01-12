<?php

session_start();

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

if (isset($_SESSION["email"])) {

    $info = $bonus = $prenotazioni = $acquisti = "";

    ob_start();
    $info = include "info.php";
    $bonus = include "bonus.php";
    $prenotazioni = include "prenotazioni.php";
    $acquisti = include "acquisti.php";
    ob_end_clean();
    $url = "../HTML/area_utente.html";

    $replace = array("<info />" => $info,
                     "<bonus />" => $bonus,
                     "<prenotazioni />" => $prenotazioni,
                     "acquisti />" => $acquisti);

    echo UtilityFunctions::replacer($url, $replace);

} else {
    echo file_get_contents("../HTML/login.html");
}

?>
