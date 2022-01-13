<?php
  $name = $_POST['nomePr'];
  $quantita = $_POST['quantitaPr'];
  $totale = $_POST['totalPr'];
  $totaleFinale = $_POST['totaleFinale'];
  $DT = $_POST['DT'];
  $indOra = $_POST['indOra'];

  //$replace = "<riepilogo />" => $string;
  $url = "../HTML/pagamento.html";

  require_once "UtilityFunctions.php";
  use UtilityFunctions\UtilityFunctions;


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
                      <div class=\"segnoP\">X</div>
                      <div class=\"productQuantityP\">".$quantita[$i]."</div>
                      <div class=\"productLinePriceP\">".$totale[$i]."</div>
                      </div>";
  }
  $string = $string."</div><div class=\"totaleFinale\"><h2>TOTALE FINALE : ".$totaleFinale."</h2></div>";

  if($DT == "TakeAway"){
    $info = "<div>Hai scelto la modalita ritiro a mano per le ore: ".$indOra."</div>";
  } else {
    $info = "<div><p>Hai scelto la modalita consegna a domicilio all'indirizzo: ".$indOra.". La consegna e' prevista dopo 30 minuti dal completamento dell'ordine</p></div>";
  }

  echo UtilityFunctions::replacer($url, array("<riepilogo />" => $string,
                                              "<Informazioni />" => $info));

?>
