<?php

    session_start();
    require_once "connectionDB.php";
    use DB\DBAccess;

    $bonusList = '';
    $url = "../HTML/pagamento.html";
    $checkbonus = false;
    require_once "UtilityFunctions.php";
    use UtilityFunctions\UtilityFunctions;

    if (isset($_SESSION["email"])){
      $connessione = new DBAccess();
      $connessioneOK = $connessione->openDBConnection();
      if ($connessioneOK) {
          $dataScadenza = date("Y-n-j", strtotime("+1 year"));
          $minValore = 0;
          $maxValore = 1000;
          $bonus = $GLOBALS["connessione"]->getBonus($_SESSION["email"], $dataScadenza, $minValore, $maxValore);
          $connessione->closeDBConnection();
          if ($bonus !== null) {
            $bonusList = "<div class=\"bonus\"><h3>Bonus disponibili</h3>
                          <div class=\"nonVisibile\" aria-hidden=\"true\"><input type=\"number\" id=\"codicecBonus\" name=\"codiceBonus\" value=\"0\"></div>
                          <input onchange=\"applicaBonus(this)\" type=\"radio\" id=\"bonus\" name=\"bonus\" value=\"0\" checked>
                          <label for=\"0\"><p><strong>Non voglio utilizzare i Bonus</strong></p>";
              foreach ($bonus as $i) {
                if (strtotime($i["dataScadenza"]) >= strtotime(date("Y-n-j")) && $i["dataRiscatto"] == "0000-00-00 00:00:00") {
                  $bonusList .= "<div>
                              <p class=\"nonVisibile\" aria-hidden=\"true\">".$i["codiceBonus"]."</p>
                              <input onchange=\"applicaBonus(this)\" type=\"radio\" id=\"bonus\" name=\"bonus\" value=".$i["valore"].">
                              <label for=".$i["valore"]."><p><strong>Bonus dal valore di {$i["valore"]}&euro; - spendibile entro il {$i["dataScadenza"]}</strong></p>
                            </div>";
                  $checkbonus = true;
                }
              }
          }
          if(!$checkbonus) {
            $bonusList =  "<div><p>Non hai bonus applicabili.</p></div>";
          }
      }
      $name = $_POST['nomePr'];
      $quantita = $_POST['quantitaPr'];
      $totale = $_POST['totalPr'];
      $totaleFinale = $_POST['totaleFinale'];
      $DT = $_POST['DT'];
      $indOra = $_POST['indOra'];




      $string = "<div id=\"riepilogoP\"><h2> IL TUO ORDINE</h2>
                  <div class=\"headerP\">
                  <div class=\"productNameP\">Prodotto</div>
                  <div class=\"segnoP\"></div>
                  <div class=\"productQuantityP\">Quantita'</div>
                  <div class=\"productLinePriceP\">Totale</div>
                  </div>";
      for($i = 0; $i < sizeOf($name); $i++){
        $string = $string."<div class=\"product\">
                          <div class=\"productNameP\">".$name[$i]."</div>
                          <input type=\"text\" name=\"nomeP[]\" value=".$name[$i]." class=\"nonVisibile\" aria-hidden=\"true\">
                          <div class=\"segnoP\">X</div>
                          <div class=\"productQuantityP\">".$quantita[$i]."</div>
                          <input type=\"text\" name=\"quantitaP[]\" value=".$quantita[$i]." class=\"nonVisibile\" aria-hidden=\"true\">
                          <div class=\"productLinePriceP\">".$totale[$i]."</div>
                          </div>";
      }
      $string = $string."</div><div><h2 id=\"totaleFinale\">TOTALE FINALE : <span id=\"senzaBonus\">".' '.$totaleFinale.' '."</span></h2></div>";

      if($DT == "TakeAway"){
        $info = "<div>Hai scelto la modalita <strong>ritiro a mano</strong> per le ore:<strong> ".$indOra."</strong></div>";
      } else {
        $info = "<div>
                <p>Hai scelto la modalita <strong>consegna a domicilio</strong> all'indirizzo:<strong> ".$indOra.".</strong> La consegna e' prevista dopo 30 minuti dal completamento dell'ordine</p>
                </div>";
      }

      echo UtilityFunctions::replacer($url, array("<riepilogo />" => $string,
                                                  "<Informazioni />" => $info,
                                                  "<bonus />" => $bonusList));
    } else {echo file_get_contents("../HTML/login.html");}



?>
