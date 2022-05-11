<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    if ($connessioneOK) {
        $dataAcquisto = isset($_GET["data-acquisto"]) && $_GET["data-acquisto"] !== "" ? date("Y-n-j", strtotime(str_replace('-', ' ', $_GET["data-acquisto"]))) : NULL;
        $spesa = isset($_GET["spesa"]) && $_GET["spesa"] !== "" ? intval($_GET["spesa"]) : NULL;


        $acquisti = $GLOBALS["connessione"]->getAcquisti($_SESSION["email"], $dataAcquisto, $spesa);
        $connessione->closeDBConnection();
        if ($acquisti !== null) {
            foreach ($acquisti as $i) {
                $html .= "<div class='list-item subcontainer'>
                            <p><strong>Acquisto effettuato il giorno {$i["dataOra"]} - {$i["nome"]} ({$i["prezzo"]}&euro; x {$i["quantita"]} = {$i["spesa"]}&euro;)</strong></p>
                          </div>";
            }
        }
    }
}

echo $html;
return $html;


?>
