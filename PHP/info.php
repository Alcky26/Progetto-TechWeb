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
            if (isset($_GET["result"])) {
              $class = "danger";
              if ($_GET["result"] === "Modifiche salvate.")
                  $class ="success";
              $html = "<div class='alert-box $class'>
                         {$_GET["result"]}
                       </div>";
            }
            $html .= "<form id='info-form' class='subcontainer' method='post' action='setUserInfo.php'>
                        <div id='email-div'>
                          <label for='email'>Email:</label>
                          <input type='email' id='email' name='email' value='{$user[0]["email"]}' placeholder='Modifica indirizzo email:' pattern='[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$' />
                        </div>
                        <div id='username-div'>
                          <label for='username'>Username:</label>
                          <input type='text' id='username' name='username' value='{$user[0]["username"]}' placeholder='Modifica username:' />
                        </div>
                        <label for='pwd'>Password:</label>
                        <input type='password' id='pwd' name='pwd' value='{$user[0]["password"]}' placeholder='Modifica password:' />
                        <input type='checkbox' id='spwd' class='show-pwd' /
                        ><label for='spwd'>Mostra password</label>
                        <label for='birthday'>Data di nascita (riceverai un bonus il giorno del tuo compleanno. Vieni a festeggiarlo da noi!):</label
                        ><input type='date' id='birthday' name='birthday' value='$birthday' pattern='\d{4}-\d{2}-\d{2}' placeholder='Modifica data di nascita:' />
                        <div class='submit'>
                          <button type='button' id='set-info' class='text-button' disabled >Modifica</button>
                          <input type='submit' id='save-info' class='text-button' value='Salva'></input>
                        </div>
                      </form>
                      <div class='subcontainer'>
                        <p>Finora hai totalizzato <strong>{$user[0]["punti"]}</strong> punti.</p>
                      </div>
                      <form id='delete-account' class='subcontainer' action='deleteAccount.php'>
                        <button type='submit' class='confirm text-button'>Elimina account</button>
                      </form>";
         }
     }
}

echo $html;
return $html;

 ?>
