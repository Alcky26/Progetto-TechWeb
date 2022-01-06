<?php

$_SESSION['user'] = "mmasetto@unipd.it";
$_SESSION['password'] = "password";

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

if (isset($_SESSION["user"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();

    $categories = array("", "", "", "");

    if ($connessioneOK) {
        $categories[0] = info();
        $categories[1] = bonus();
        $categories[2] = prenotazioni();
        $categories[3] = acquisti();
    } else {
        foreach ($i as $categories) {
            $i = "<div class=\"subcontainer\"><p>Errore nella connessione al server. Per favore riprova più tardi.</p></div>";
        }
    }

    $url = "../HTML/area_utente.html";

    $replace = array("<info />" => $categories[0],
                     "<bonus />" => $categories[1],
                     "<prenotazioni />" => $categories[2],
                     "acquisti />" => $categories[3]);

    echo UtilityFunctions::replacer($url, $replace);

} else {
    echo file_get_contents("../HTML/login.html");
}

function info() {
    return "<form id='info-form' class='subcontainer' method='post'>
               <label for='email'>Email:</label>
               <input type='text' id='email' name='email' value={$_SESSION['user']} autocomplete='off' disabled />
               <label for='pwd'>Password:</label>
               <input type='password' id='pwd' name='pwd' value={$_SESSION['password']} autocomplete='off' disabled />
               <input type='checkbox' id='show-pwd' checked='false' />
               <label for='show-pwd'>Mostra password</label>
               <div class='submit'>
                 <button type='button' id='set-info' class='text-button'>Modifica</button>
                 <input type='submit' class='text-button' value='Salva' disabled />
               </div>
             </form>
             <form id='delete-account' class='subcontainer'>
               <div class='popup'>
                 <div class='popup-inner'>
                   <p class='message'>
                     Sei sicuro di voler eliminare il tuo account?<br />
                     Tutte le informazioni andranno perse.
                   </p>
                   <div class='submit'>
                     <button type='button' class='cancel text-button'>Annulla</button>
                     <button type='submit' class='confirm text-button'>Conferma</button>
                   </div>
                 </div>
               </div>
               <button type='button' class='open-popup text-button'>Elimina account</button>
             </form>";
}

function bonus() {

}

function prenotazioni() {
    $html = "";
    $prenotazioni = $GLOBALS['connessione']->getPrenotazioni($_SESSION['user']);
    foreach ($prenotazioni as $i) {
        $html .= "<div class='list-item'>
                   {$i['dataOra']} {$i['persone']}
                 </div>";
    }
    return $html;
}

function acquisti() {
  return "";
}

?>
