<?php

session_start();

require_once "connectionDB.php";
use DB\DBAccess;

$html = "";

if (isset($_SESSION["email"])) {

    $connessione = new DBAccess();
    $connessioneOK = $connessione->openDBConnection();

    if ($connessioneOK) {
        $user = $GLOBALS["connessione"]->getUserInfo($_SESSION["email"]);
        $connessione->closeDBConnection();
        if($user !== null) {
            $birthday = substr($user[0]["birthday"], 0, 10);
            $html =  "<form id='info-form' class='subcontainer' method='post'>
                        <div id='email-div'>
                          <label for='email'>Email:</label>
                          <input type='email' id='email' name='email' value='{$user[0]["email"]}' disabled />
                        </div>
                        <div id='username-div'>
                          <label for='username'>Username:</label>
                          <input type='text' id='username' name='username' value='{$user[0]["username"]}' disabled />
                        </div>
                        <label for='pwd'>Password:</label>
                        <input type='password' id='pwd' name='pwd' value='{$user[0]["password"]}' disabled />
                        <input type='checkbox' id='spwd' class='show-pwd' /
                        ><label for='spwd'>Mostra password</label>
                        <label for='birthday'>Data di nascita (riceverai un bonus il giorno del tuo compleanno. Vieni a festeggiarlo da noi!):</label
                        ><input type='date' id='birthday' name='birthday' value='$birthday' disabled />
                        <p class='alert-box'></p>
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
     echo $html;
     return $html;
}

 ?>
