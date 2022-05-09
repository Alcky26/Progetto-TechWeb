<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();
if(!isset($_POST["registrati"])){
    $replace=array("<registrazione/>" => 
    "<form id=\"signup-form\" class=\"subcontainer\" action=\"../PHP/signupHandler.php\" method=\"post\">
    <fieldset>
    <legend>
        <h2>Registrati</h2>
    </legend>
    <msgErrore/>
    <label for=\"email\" lang=\"en\">Email:</label>
    <input type=\"email\" name=\"email\" id=\"email\" autocomplete=\"email\" pattern=\"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$\" placeholder=\"Inserisci la tua email:\" required />
    <label for=\"username\" lang=\"en\">Username:</label>
    <input type=\"text\" name=\"username\" id=\"username\" autocomplete=\"username\" placeholder=\"Inserisci il tuo username:\" required />
    <label for=\"pwd\" lang=\"en\">password: </label>
    <input type=\"password\" name=\"pwd\" id=\"pwd\" autocomplete=\"current-password\" pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" title=\"Deve contentenere almeno un numero, una lettera maiuscola, una lettera minuscola, minimo 8 caratteri\" placeholder=\"Inserisci la tua password:\" required />
    <div id=\"post\">
        <input type=\"submit\" id=\"registrati\" class=\"text-button\" name=\"registrati\" value=\"Registrati\" />
    </div>
    <div id=\"post\">
          <a href=\"../HTML/login.html\"><input type=\"button\" class=\"text-button\" value=\"Vai a Login\"/></a>
    </div>
    </fieldset>
    </form>");
}
$url = "../HTML/signup.html";
echo UtilityFunctions::replacer($url, $replace);
?>