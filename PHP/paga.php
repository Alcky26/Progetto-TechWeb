<?PHP
  session_start();
  require_once "connectionDB.php";
  use DB\DBAccess;

  if (isset($_SESSION["email"])) {
    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();
    $messaggio = '';
    if($connessioneOK){
      $dataora = date('y-m-d h:i:s');
      $quantita = $_POST["quantitaP"];
      $nome = $_POST["nomeP"];
      $bonus = $_POST["bonus"];
      $codice = $_POST["codiceBonus"];
      $usaBonus = true;


      $ordinazione = $connessione->insertOrdinazioni($dataora,$_SESSION["email"]);
      if(is_array($nome)){
        for($i = 0; $i < sizeOf($nome); $i++) {
          $acquisto = $connessione->insertAcquisto($quantita[$i],$nome[$i],$dataora,$_SESSION["email"]);
        }
      } else {$acquisto = $connessione->insertAcquisto($quantita,$nome,$dataora,$_SESSION["email"]);}

      $connessione->closeDBConnection();
      if ($ordinazione && $acquisto){
        if($bonus != 0) $usaBonus = $connessione->useBonus($codice,$_SESSION['email'],$dataora);
        if($usaBonus) $messaggio = "<div id=\"mainMex\"><h1>Pagamento effettuato</h1>Ora puoi visualizzare il tuo ordine nell'area personale";
      } else {
        $messaggio = "<div id=\"mainMex\"><h1>Errore nell'insermimento</h1>";
      }
    } else {$messaggio = "<div id=\"mainMex\"><h1>Errore nella connessione al server. Per favore riprova più tardi</h1>";}
  }
  $messaggio .= "<div><a href=\"../HTML/index.html\">Torna alla <span lang=\"en\">home</span></div></div>";

  require_once "UtilityFunctions.php";
  use UtilityFunctions\UtilityFunctions;

  $url = "../HTML/response.html";

  echo UtilityFunctions::replacer($url, array("<messaggio />" => $messaggio));
?>
