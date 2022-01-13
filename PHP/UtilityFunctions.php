<?php

namespace UtilityFunctions;

class UtilityFunctions {

    public static function replacer($urlHTML, $array) {//trasforma pagina html in stringa
        $paginaHTML = file_get_contents($urlHTML);
        return UtilityFunctions::replacerFromHTML($paginaHTML, $array);
    }

    public static function replacerFromHTML($HTMLPage, $array) {
        foreach($array as $key => $value) //scorre stringa e rimpiazza le parti da modificare
            $HTMLPage = str_replace($key, $value, $HTMLPage);
        return $HTMLPage;
    }

    public static function loginCheck()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION["username"],$_SESSION["email"],$_SESSION["isValid"]) && $_SESSION["isValid"])
            return true;
        return false;
    }

    public static function changeAccedi() 
    {
        $string = "";
        if(loginCheck())
        {
            $string="<div id=\"hovermenu\">
                        <ul>
                            <li>
                                <a href=\"../PHP/area_utente.php\">Area Utente</a>
                            </li>
                            <li>
                                <a href=\"../PHP/logout.php\">Logout</a>
                            </li>
                        </ul>
                    </div>";
        }
        else
        {
            $string="<a href=\"../HTML/login.html\">ACCEDI</a>";
        }
        return $string;
    }
}
?>