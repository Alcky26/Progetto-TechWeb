<?php

$error= $_SERVER["REDIRECT_STATUS"];

$error_title="";
$error_messagge="";

if($error==404){
	$error_title='404 page not found ';
	$error_message='The document/file requested was not found on this server.';
}

$>