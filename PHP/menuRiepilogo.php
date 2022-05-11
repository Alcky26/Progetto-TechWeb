<?php

    session_start();
    require_once "connectionDB.php";
    use DB\DBAccess;

    require_once "UtilityFunctions.php";
    use UtilityFunctions\UtilityFunctions;

    if (empty($_POST) || !empty(array_filter($_POST, fn($quantity) => $quantity > 0))) {
        if (empty($_POST) && !isset($_SESSION["order"]))
            header("Location: menu.php");
        else {
            if (!empty($_POST))
                $_SESSION["order"] = array_filter($_POST, fn($quantity) => $quantity > 0);

            if (isset($_SESSION["email"])) {
                $connessione = new DBAccess();
                $connessioneOK = $connessione->openDBConnection();
                $order = "";
                $bonuses = "";
                $tot = 0;
                if ($connessioneOK) {
                    foreach ($_SESSION["order"] as $id => $quantity) {
                        $name = explode('#', str_replace(['-', ','], [' ', '.'], $id));
                        $tot += $name[1] * $quantity;
                        $order .= "<div class=\"subcontainer\"><p>{$name[0]} ({$name[1]}&euro; x {$quantity})</p></div>";
                    }
                    ob_start();
                    $checkable = true;
                    $bonuses = include "utenteBonus.php";
                    ob_end_clean();
                }
                $replace = array(
                    "<tot />" => "<p>Importo totale: $tot&euro;</p>",
                    "<order />" => $order,
                    "<bonuses />" => $bonuses
                );

                $url = "../HTML/riepilogo.html";
                echo UtilityFunctions::replacer($url, $replace);
            } else
                 header("Location: login.php?redirect=menuRiepilogo.php");
        }
    } else {
        if (isset($_SESSION["order"]))
            unset($_SESSION["order"]);
        header("Location: menu.php");
    }

?>
