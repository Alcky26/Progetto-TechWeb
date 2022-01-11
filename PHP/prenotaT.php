<?php
  session_start();
  require_once "UtilityFunctions.php";
  use DB/DBAccess;

  $connessione = new DBAccess();
  $connessioneOK = $connessione->openDBConnection();

  if(connessioneOK){
    $risultatoQuery = $connessione->insertPrenotazioni($nPersone,$dataS,$ora,$_SESSION['username']);
    if ($risultatoQuery){
      $messaggio = '<div id="success"><p>Prenotato con successo.</p></div>';
    } else {
      $messaggio = '<div id="error"><p>Errore nell\'insermimento.</p></div>';
    }
  } else {
    $messaggio = '<div id="error"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>';
  }
?>
