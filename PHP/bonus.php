<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) {
        $dataScadenza = NULL;
        $minValore = NULL;
        $maxValore = NULL;

        if (isset($_GET["scadenza"])) {
            switch($_GET["scadenza"]) {
                case 'tutto':
                    $dataScadenza = date("Y-n-j", strtotime("+1 year"));
                    break;
                case 'due-settimane':
                    $dataScadenza = date("Y-n-j", strtotime("+2 weeks"));
                    break;
                case 'settimana':
                    $dataScadenza = date("Y-n-j", strtotime("+1 week"));
                    break;
                case 'scaduto':
                    $dataScadenza = date("Y-n-j", strtotime("1 day ago"));
                    break;
            }
        } else {
            $dataScadenza = date("Y-n-j", strtotime("+1 year"));
        }
        if(isset($_GET["valore"])) {
            switch($_GET["valore"]) {
                case 'tutto':
                    $minValore = 0;
                    $maxValore = 1000;
                    break;
                case 'nove':
                    $minValore = 0;
                    $maxValore = 9;
                    break;
                case 'venti':
                    $minValore = 10;
                    $maxValore = 20;
                    break;
                case 'ventuno':
                    $minValore = 21;
                    $maxValore = 1000;
                    break;
            }
        } else {
            $minValore = 0;
            $maxValore = 1000;
        }
        $bonus = $GLOBALS["connessione"]->getBonus($_SESSION["email"], $dataScadenza, $minValore, $maxValore);
        $connessione->closeDBConnection();
        if ($bonus !== null) {
            foreach ($bonus as $i) {
                $html .= "<div class='list-item subcontainer'>
                            <p class=".(strtotime($i["dataScadenza"]) < strtotime(date("Y-n-j")) ? "canceled" : "")."><strong>Bonus dal valore di {$i["valore"]}&euro; - spendibile entro il {$i["dataScadenza"]}</strong></p>
                          </div>";
            }
        }
    }
}

echo $html;
return $html;

?>
