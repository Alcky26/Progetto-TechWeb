<?php

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;

$replace = array("<a href=\"../HTML/login.html\">ACCEDI</a>" => UtilityFunctions::changeAccedi());
$url="../HTML/chisiamo.html";
echo UtilityFunctions::replacer($url, $replace);

?>