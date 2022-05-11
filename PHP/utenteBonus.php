<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) {
        $dataScadenza = isset($_GET["scadenza"]) && $_GET["scadenza"] !== "" ? date("Y-n-j", strtotime(str_replace('-', ' ', $_GET["scadenza"]))) : NULL;
        $minValore = isset($_GET["valore-min"]) && $_GET["valore-min"] !== "" ? intval($_GET["valore-min"]) : NULL;
        $maxValore = isset($_GET["valore-max"]) && $_GET["valore-max"] !== "" ? intval($_GET["valore-max"]) : NULL;

        $bonus = $GLOBALS["connessione"]->getBonus($_SESSION["email"], $dataScadenza, $minValore, $maxValore);
        $connessione->closeDBConnection();
        foreach ($bonus as $i) {
            $disabled = strtotime($i["dataScadenza"]) < strtotime(date("Y-n-j")) || $i["dataRiscatto"] != "0000-00-00 00:00:00" ? "disabled" : "";
            $html .= "<div class=\"list-item subcontainer\">";
            if (isset($checkable)) {
                $html .= "<input type=\"checkbox\" id=\"bonus[{$i["codiceBonus"]}]\" name=\"bonus[{$i["codiceBonus"]}]\" value=\"{$i["valore"]}\" $disabled />
                          <label for=\"bonus[{$i["codiceBonus"]}]\" class=\"$disabled\"><strong>Bonus dal valore di {$i["valore"]}&euro; - spendibile entro il {$i["dataScadenza"]}</strong></label>";
            } else {
                $html .= "<p class=\"$disabled\"><strong>Bonus dal valore di {$i["valore"]}&euro; - spendibile entro il {$i["dataScadenza"]}</strong></p>";
            }
            $html .= "</div>";
        }
    }
}

echo $html;
return $html;

?>
