<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

if (isset($_SESSION["email"])) {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    $messaggio = '';
    if ($connessioneOK) {
        $today = date('Y-m-d H:i:s');
        $bonusApply = true;
        if (isset($_POST["bonus"])) {
            $bonusValue = 0;
            foreach ($_POST["bonus"] as $i)
                $bonusValue += $i;
            $priceTotal = 0;
            foreach ($_SESSION["order"] as $key => $units) {
                $pricePerUnit = floatval(explode('#', $key)[1]);
                $priceTotal += $units * $pricePerUnit;
            }
            $bonuses = join(',', array_keys($_POST["bonus"]));
            $bonusApply = $bonusValue >= $priceTotal && $connessione->useBonus("($bonuses)", $today);
        }
        if ($bonusApply) {
            $ordinazione = $connessione->insertOrdinazioni($today, $_SESSION["email"]);
            foreach ($_SESSION["order"] as $id => $quantity) {
                $name = str_replace(["-", ","], [" ", "."], explode('#', $id)[0]);
                $connessione->insertAcquisto($quantity, $name, $today, $_SESSION["email"]);
            }
            unset($_SESSION["order"]);
            $messaggio = "<p>Pagamento andato a buon fine.</p>";
        } else {
            header("Refresh: 5; URL=menuRiepilogo.php");
            $messaggio = "<p>Pagamento annullato: i bonus selezionati non sono più validi/disponibili, oppure il loro importo non è sufficiente a coprire la spesa. Tra poco verrai reindirizzato alla pagina di riepilogo del tuo ordine.</p>";
        }
    }
    $connessione->closeDBConnection();

    $url = "../HTML/pagamento.html";
    echo UtilityFunctions::replacer($url, array("<messaggio />" => $messaggio));

} else {
    header("Location: login.php?redirect=menuRiepilogo.php");
}

?>
