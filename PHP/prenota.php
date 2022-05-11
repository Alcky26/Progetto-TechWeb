<?php
    session_start();
    require_once "connectionDB.php";
    use DB\DBAccess;

    if (isset($_SESSION["email"])) {
        $connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

        $messaggio = '';

        if($connessioneOK) {

            $nPersone = $_POST['numPersone'];
            $dataS = $_POST['data'];
            $ora = $_POST['ora'];

            $ora .= ":00";
            $dataora = "$dataS $ora";
            if ($dataora >= date("Y-m-d H:i:s") && strtotime($dataora) <= strtotime("+2 weeks")) {
                $nTavolo = $connessione->getTavoli($dataora, $nPersone);
                if ($nTavolo) {
                    $risultatoQuery = $connessione->insertPrenotazioni($nPersone, $dataora, $nTavolo[0]['numero'], $_SESSION['email']);
                    $connessione->closeDBConnection();
                    if ($risultatoQuery){
                        $messaggio = '<div class="subcontainer success"><p>Prenotato con successo. Puoi visualizzare i dati relativi alla prenotazione nell\'area utente.</p></div>';
                    } else {
                        $messaggio = '<div class="subcontainer danger"><p>Errore nell\'inserimento.</p></div>';
                    }
                } else {
                    $messaggio = '<div class="subcontainer danger"><p>Nessun tavolo disponibile. Prova a scegliere un orario o un giorno diverso.</p></div>';
                }
            } else {
                $messaggio = "<div class=\"subcontainer danger\"><p>La data selezionata non è valida. Scegli un altro giorno.</p></div>";
            }
        } else {
            $messaggio = '<div class="subcontainer danger"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>';
        }
    } else {
        header("Location: login.php?redirect=../HTML/prenotazione.html");
    }

    require_once "UtilityFunctions.php";
    use UtilityFunctions\UtilityFunctions;

    $url = "../HTML/prenotazione.html";

    echo UtilityFunctions::replacer($url, array("<error />" => $messaggio));
?>
