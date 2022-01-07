<?php

namespace UtilityFunctions;

class UtilityFunctions {

    public static function replacer($urlHTML, $array) {//trasforma pagina html in stringa
        $paginaHTML = file_get_contents($urlHTML);
        foreach($array as $key => $value) //scorre stringa e rimpiazza le parti da modificare
            $HTMLPage = str_replace($key, $value, $paginaHTML);
        return $HTMLPage;
    }
}

?>
