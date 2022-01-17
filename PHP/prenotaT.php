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
    $ora .= ":00";
    $dataora = $dataS." ".$ora;

    $nTavolo = $connessione->getTavoli($dataora);
    $risultatoQuery = $connessione->insertPrenotazioni($nPersone,$dataora,$nTavolo,$_SESSION['email']);
    $connessione->closeDBConnection();

    if ($risultatoQuery){
      $messaggio = '<div id="success"><p>Prenotato con successo.</p></div>';
    } else {
      $messaggio = '<div id="error"><p>Errore nell\'insermimento.</p></div>';
    }
  } else {
    $messaggio = '<div id="error"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>';
  }
} else {echo file_get_contents("../HTML/login.html");}

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

$url = "../HTML/prenotazione.html";

echo UtilityFunctions::replacer($url, array("<error />" => $messaggio));
?>
