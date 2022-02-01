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
        if(self::loginCheck())
        {
            if(isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]){
                $string="<div class=\"dropdown\">
                <button type=\"button\" class=\"text-button dropbtn\">Il mio <span lang=\"en\">account</span></button>
                <ul class=\"dropdown-content\">
                    <li>
                        <a href=\"../PHP/area_utente.php\">Area utente</a>
                    </li>
                    <li>
                        <a href=\"../PHP/logout.php\">Effetua il <span lang=\"en\">logout</span></a>
                    </li>
                    <li>
                        <a href=\"../PHP/Administrator.php?enter=1\">Gestione Pizzeria</a>
                    </li>
                </ul>
            </div>";
            }
            else{
                $string="<div class=\"dropdown\">
                        <button type=\"button\" class=\"text-button dropbtn\">Il mio <span lang=\"en\">account</span></button>
                        <ul class=\"dropdown-content\">
                            <li>
                                <a href=\"../PHP/area_utente.php\">Area utente</a>
                            </li>
                            <li>
                                <a href=\"../PHP/logout.php\">Effetua il <span lang=\"en\">logout</span></a>
                            </li>
                        </ul>
                    </div>";
            }
            
        }
        else
        {
            $string="<a class=\"text-button\" href=\"../HTML/login.html\">Accedi</a>";
        }
        return $string;
    }
}
?>
