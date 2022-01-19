<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

  $connessione = new DBAccess();
  $connessioneOK = $connessione->openDBConnection();
  if($connessioneOK) {
        $periodo = NULL;
        $minPersone = NULL;
        $maxPersone = NULL;
        if (isset($_GET["periodo"])) {
            switch ($_GET["periodo"]) {
                case 'tutto':
                    $periodo = "0000-00-00 00:00:00";
                    break;
                case 'mese':
                    $periodo = date("Y-n-j", strtotime("1 month ago"));
                    break;
                case 'due-settimane':
                    $periodo = date("Y-n-j", strtotime("2 weeks ago"));
                    break;
                case 'settimana':
                    $periodo = date("Y-n-j", strtotime("1 week ago"));
                    break;
            }
        } else {
            $periodo = "0000-00-00 00:00:00";
        }
        if (isset($_GET["persone"])) {
            switch ($_GET["persone"]) {
                case 'tutto':
                    $minPersone = 0;
                    $maxPersone = 1000;
                    break;
                case 'tre':
                    $minPersone = 0;
                    $maxPersone = 3;
                    break;
                case 'quattro':
                    $minPersone = 4;
                    $maxPersone = 8;
                    break;
                case '':
                    $minPersone = 9;
                    $maxPersone = 1000;
            }
        } else {
            $minPersone = 0;
            $maxPersone = 1000;
        }
        $prenotazioni = $GLOBALS["connessione"]->getPrenotazioni($_SESSION["email"], $periodo, $minPersone, $maxPersone);
        $connessione->closeDBConnection();
        if ($prenotazioni !== null) {
            foreach ($prenotazioni as $i) {
                $code = base64_encode($i["dataOra"]." - tavolo n. ".$i["numero"]);
                $html .= "<div class='list-item subcontainer'>
                            <p><strong>{$i["dataOra"]} - tavolo n. {$i["numero"]}</strong></p>
                            <button class='link show-code'>Mostra codice QR</button>
                            <img class='qr-code' src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$code' width=150 height=150 alt='$code' />
                          </div>";
            }
        }
    }
}

echo $html;
return $html;

?>
