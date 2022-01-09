<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

if (isset($_SESSION["email"])) {

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
    $connessione->closeDBConnection();
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
    $user = $GLOBALS["connessione"]->getUserInfo($_SESSION["email"]);
    if($user !== null) {
        return "<form id='info-form' class='subcontainer' method='post'>
                   <label for='email'>Email:</label>
                   <input type='email' id='email' name='email' value={$user[0]["email"]} autocomplete='off' disabled />
                   <label for='username'>Username:</label>
                   <input type='text' id='username' name='username' value={$user[0]["username"]} autocomplete='off' disabled />
                   <label for='pwd'>Password:</label>
                   <input type='password' id='pwd' name='pwd' value={$user[0]["password"]} autocomplete='off' disabled />
                   <input type='checkbox' id='show-pwd' checked='false' />
                   <label for='show-pwd'>Mostra password</label>
                   <label for='birthday'>Data di nascita (riceverai un bonus il giorno del tuo compleanno. Vieni a festeggiarlo da noi!):</label>
                   <input type='datetime' id='birthday' name='birthday' value={$user[0]["birthday"]} autocomplete='off' disabled />
                   <div class='alert-box'></div>
                   <div class='submit'>
                     <button type='button' id='set-info' class='text-button'>Modifica</button>
                     <input type='submit' class='text-button' value='Salva' disabled />
                   </div>
                 </form>
                 <div class='subcontainer'>
                   <p>Finora hai totalizzato <strong>{$user[0]["punti"]}</strong> punti.</p>
                 </div>
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
}

function bonus() {

}

function prenotazioni() {
/*
    $html = "";
    $prenotazioni = $GLOBALS['connessione']->getPrenotazioni($_SESSION['user']);
    foreach ($prenotazioni as $i) {
        $html .= "<div class='list-item'>
                   {$i['dataOra']} {$i['persone']}
                 </div>";
    }
    return $html;
*/
}

function acquisti() {
  return "";
}

?>
