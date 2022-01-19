<?php

$error = $_SERVER["REDIRECT_STATUS"];

if ($error === 404) {
	echo file_get_contents("error404.html");
}

?>
