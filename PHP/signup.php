<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();
if(!isset($_POST["registrati"])){
    $replace=array("<registrazione/>" => 
    "<form id=\"signup-form\" action=\"../PHP/signupHandler.php\" method=\"post\">
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
    <input type=\"password\" name=\"pwd\" id=\"pwd\" autocomplete=\"current-password\" placeholder=\"Inserisci la tua password:\" required />
    <div class=\"submit\">
        <input type=\"submit\" id=\"registrati\" class=\"text-button\" name=\"registrati\" value=\"Registrati\" />
        <a class=\"text-button\" href=\"../HTML/login.html\">Vai alla login</a>
    </div>
    </fieldset>
    </form>");
}
$url = "../HTML/signup.html";
echo UtilityFunctions::replacer($url, $replace);
?>