<?PHP
  session_start();
  require_once "connectionDB.php";
  use DB\DBAccess;

  if (isset($_SESSION["email"])) {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();

    if($connessioneOK){
      $dataora = date('y-m-d h:i:s');
      $quantita = $_POST["quantitaP"];
      $nome = $_POST["nomeP"];
      $bonus = $_POST['bonus'];
      //$usaBonus = true;


      $ordinazione = $connessione->insertOrdinazioni($dataora,$_SESSION["email"]);
      if(is_array($nome)){
        for($i = 0; $i < sizeOf($nome); $i++) {
          $acquisto = $connessione->insertAcquisto($quantita[$i],$nome[$i],$dataora,$_SESSION["email"]);
        }
      } else {$acquisto = $connessione->insertAcquisto($quantita,$nome,$dataora,$_SESSION["email"]);}

      $connessione->closeDBConnection();
      if ($ordinazione && $acquisto){
        //if($bonus != 0) $usaBonus = $connessione->useBonus($codice,$_SESSION['email'],$dataora);
        /*if($usaBonus)*/ echo'Pagamento effettuato.';
      } else {
        echo 'Errore nell\'insermimento.';
      }
    } else {echo 'Errore nella connessione al server. Per favore riprova più tardi.';}
  }
?>
