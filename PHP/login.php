<?php
    session_start();
    if (isset($_GET["redirect"]))
        $_SESSION["redirect"] = $_GET["redirect"];
    echo file_get_contents("../HTML/login.html");
?>

