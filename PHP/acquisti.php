<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) {
        $dataAcquisto = NULL;
        $minSpesa = NULL;
        $maxSpesa = NULL;

        if (isset($_GET["data"])) {
            switch($_GET["data"]) {
                case 'tutto':
                    $dataAcquisto = "0000-00-00 00:00:00";
                    break;
                case 'mese':
                    $dataAcquisto = date("Y-n-j", strtotime("1 month ago"));
                    break;
                case 'due-settimane':
                    $dataAcquisto = date("Y-n-j", strtotime("2 weeks ago"));
                    break;
                case 'settimana':
                    $dataAcquisto = date("Y-n-j", strtotime("1 week ago"));
                    break;
            }
        } else {
            $dataAcquisto = date("Y-n-j", strtotime("+1 year"));
        }
        if(isset($_GET["spesa"])) {
            switch($_GET["spesa"]) {
                case 'tutto':
                    $minSpesa = 0;
                    $maxspesa = 1000;
                    break;
                case 'diciannove':
                    $minSpesa = 0;
                    $maxSpesa = 19;
                    break;
                case 'venti':
                    $minSpesa = 20;
                    $maxSpesa = 50;
                    break;
                case 'cinquantuno':
                    $minSpesa = 51;
                    $maxSpesa = 1000;
                    break;
            }
        } else {
            $minSpesa = 0;
            $maxSpesa = 1000;
        }
        $bonus = $GLOBALS["connessione"]->getAcquisti($_SESSION["email"], $dataAcquisto, $minSpesa, $maxSpesa);
        $connessione->closeDBConnection();
        if ($bonus !== null) {
            foreach ($bonus as $i) {
                $html .= "<div class='list-item subcontainer'>
                            <p><strong>Acquisto effettuato il giorno {$i["dataOra"]} - spesa di {$i["spesa"]}</strong></p>
                          </div>";
            }
        }
    }
}

echo $html;
return $html;


?>
