<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

session_start();

$messaggiof = isset($_GET["msgf"]) ? "<p id=\"erroreDati\">" . $_GET["msgf"] . "</p>" : "";
/*$messaggiot = isset($_GET["msgt"]) ? "<p id=\"validSignUp\">" . $_GET["msgt"] . "</p></br><input type=\"submit\" id=\"Accesso\" class=\"text-button\" name=\"Accesso\" value=\"Accesso\" />" : "";
if(isset($_GET["msgt"]))
{
    $testohtml = '<legend>';
    $testohtml .= '<h2>Registrati</h2>';
    $testohtml = '</legend>';
    $testohtml = '<msgErrore/>';
    $testohtml = '<label for="email" lang="en">Email:</label>';
    $testohtml = '<input type="text" name="email" id="email" autocomplete="email" placeholder="Inserisci la tua email:" required />';
    $testohtml = '<label for="username" lang="en">Username:</label>';
    $testohtml = '<input type="text" name="username" id="username" autocomplete="username" placeholder="Inserisci il tuo username:" required />';
    $testohtml = '<label for="pwd" lang="en">password: </label>';
    $testohtml = '<input type="password" name="pwd" id="pwd" autocomplete="current-password" placeholder="Inserisci la tua password:" required />';
    $testohtml = '<div id="post">';
    $testohtml .= '<input type="submit" id="registrazione" class="text-button" name="registrazione" value="Registrati" />';
    $testohtml = '</div>';
    $nuovo = array( $testohtml => $messaggiot);

    echo UtilityFunctions::replacer("../HTML/signup.html", $nuovo);
}*/
if(isset($_GET["msgf"]))
{
    $nuovo = array(
        "<msgErrore/>" => $messaggiof
    );
    echo UtilityFunctions::replacer("../HTML/signup.html", $nuovo);
}
?>