<?php
  session_start();
  require_once "connectionDB.php";
  use DB\DBAccess;

  if (isset($_SESSION["email"])) {
  $connessione = new DBAccess();
  $connessioneOK = $connessione->openDBConnection();

  $messaggio = '';

  if($connessioneOK){

    $nPersone = $_POST['numPersone'];
    $dataS = $_POST['data'];
    $ora = $_POST['ora'];

    //if($nPersone == "Seleziona") $messaggio .= "seleziona il numero delle persone";
    //if($ora == "Seleziona") $messaggio .= "seleziona l'ora";
    $ora .= ":00";
    $dataora = $dataS." ".$ora;

    $nTavolo = $connessione->getTavoli($dataora)[0]['numero'];
    //$nTavolo = implode("",$array);
    //$messaggio = $nPersone.$dataora.$nTavolo.$_SESSION['email'].is_array($nPersone).is_array($dataora).is_array($nTavolo);
  //echo implode(",",$array);}}
    $risultatoQuery = $connessione->insertPrenotazioni($nPersone,$dataora,$nTavolo,$_SESSION['email']);
    $connessione->closeDBConnection();

    if ($risultatoQuery){
      $messaggio = '<div class="risposta"><p>Prenotato con successo. Puoi visualizzare la tua prenotazione nell\'area utente</p></div>';
    } else {
      $messaggio = '<div class="risposta"><p>Errore nell\'insermimento.</p></div>';
    }
  } else {
    $messaggio = '<div class="risposta"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>';
  }
} else {echo file_get_contents("../HTML/login.html");}

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

$url = "../HTML/prenotazione.html";

echo UtilityFunctions::replacer($url, array("<error />" => $messaggio));
?>
