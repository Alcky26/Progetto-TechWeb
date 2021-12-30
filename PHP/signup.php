<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();

$messaggiof = isset($_GET["msgf"]) ? "<p id=\"erroreDati\">" . $_GET["msgf"] . "</p>" : "";
$messaggiot = isset($_GET["msgt"]) ? "<p id=\"validSignUp\">" . $_GET["msgt"] . "</p></br>
                                        <input type="submit" id="accesso" class="text-button" name="accesso" value="Accesso" />" : "";

if(isset($_GET["msgt"]))
{
    $nuovo = array(
        "<h2>Registrati</h2>
        <msgErrore/>
        <label for="email" lang="en">Email:</label>
        <input type="text" name="email" id="email" autocomplete="email" placeholder="Inserisci la tua email:" required />
        <label for="username" lang="en">Username:</label>
        <input type="text" name="username" id="username" autocomplete="username" placeholder="Inserisci il tuo username:" required />
        <label for="pwd" lang="en">password: </label>
        <input type="password" name="pwd" id="pwd" autocomplete="current-password" placeholder="Inserisci la tua password:" required />
        <div id="post">
          <input type="submit" id="registrazione" class="text-button" name="registrazione" value="Registrati" />
        </div>" => $messaggiot
    );

    echo UtilityFunctions::replacer("../HTML/signup.html", $nuovo);
}
if(isset($_GET["msgf"]))
{
    $nuovo = array(
        "<msgErrore/>" => $messaggiof
    );
    echo UtilityFunctions::replacer("../HTML/signup.html", $nuovo);
}
?>