<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
session_start();
if(!isset($_POST["username"],$_POST["email"], $_POST["pwd"])) {
    header("Location: ../PHP/signup.php");
}
else
{
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["pwd"];
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    $result = $dbAccess->createNewUser($email,$username, $password);
    $dbAccess->closeDBConnection();

    if($result){
        $replace=array("<registrazione/>" => 
        "<form id=\"signup-form\" class=\"subcontainer\" action=\"../PHP/signupHandler.php\" method=\"post\">
        <fieldset>
        <legend>
            <h2>Registrati</h2>
        </legend>
        <p class=\"alert-box success\">Registrazione Effettuata con successo!</p>
        <div id=\"post\">
            <a href=\"../HTML/login.html\"><input type=\"button\"  id=\"Accesso\" class=\"text-button\" name=\"Accesso\" value=\"Accedi\" /></a>
        </div>
        </fieldset>
        </form>
        ");
    }
    else{
        $replace=array("<registrazione/>" => 
        "<form id=\"signup-form\" class=\"subcontainer\" action=\"../PHP/signupHandler.php\" method=\"post\">
        <fieldset>
        <legend>
            <h2>Registrati</h2>
        </legend>
        <p class=\"alert-box danger\">Email o Username già in uso</p>
        <label for=\"email\" lang=\"en\">Email:</label>
        <input type=\"email\" name=\"email\" id=\"email\" autocomplete=\"email\" placeholder=\"Inserisci la tua email:\" required />
        <label for=\"username\" lang=\"en\">Username:</label>
        <input type=\"text\" name=\"username\" id=\"username\" autocomplete=\"username\" placeholder=\"Inserisci il tuo username:\" required />
        <label for=\"pwd\" lang=\"en\">password: </label>
        <input type=\"password\" name=\"pwd\" id=\"pwd\" autocomplete=\"current-password\" placeholder=\"Inserisci la tua password:\" required />
        <div id=\"post\">
            <input type=\"submit\" id=\"registrazione\" class=\"text-button\" name=\"registrazione\" value=\"Registrati\" />
        </div>
        <div id=\"post\">
          <a href=\"../HTML/login.html\"><input type=\"button\" class=\"text-button\" value=\"Vai a Login\"/></a>
        </div>
        </fieldset>
        </form>");
    }
    $url = "../HTML/signup.html";
    echo UtilityFunctions::replacer($url, $replace);
}
?>