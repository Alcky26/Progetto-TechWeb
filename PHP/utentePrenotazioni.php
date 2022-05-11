<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

  $connessione = new DBAccess();
  $connessioneOK = $connessione->openDBConnection();
  if($connessioneOK) {
        $periodo = isset($_GET["periodo"]) && $_GET["periodo"] !== "" ? date("Y-n-j", strtotime(str_replace('-', ' ', $_GET["periodo"]))) : NULL;
        $persone = isset($_GET["persone"]) && $_GET["persone"] !== "" ? intval($_GET["persone"]) : NULL;

        $prenotazioni = $GLOBALS["connessione"]->getPrenotazioni($_SESSION["email"], $periodo, $persone);
        $connessione->closeDBConnection();
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

echo $html;
return $html;

?>
