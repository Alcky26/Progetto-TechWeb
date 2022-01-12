<?php
  $name = $_POST['nomePr'];
  $quantita = $_POST['quantitaPr'];
  $totale = $_POST['totalPr'];
  $totaleFinale = $_POST['totaleFinale'];

  //$replace = "<riepilogo />" => $string;
  $url = "../HTML/pagamento.html";

  require_once "UtilityFunctions.php";
  use UtilityFunctions\UtilityFunctions;


  $string = "<div id=\"riepilogo\"><h2> IL TUO ORDINE</h2>
              <div class=\"headerP\">
              <div class=\"productNameP\">Prodotto</div>
              <div class=\"segnoP\"></div>
              <div class=\"productQuantityP\">Quantita</div>
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
  $string = $string."</div><div class=\"totaleFinale\">".$totaleFinale."</div>";

  echo UtilityFunctions::replacer($url, array("<riepilogo />" => $string));

?>
