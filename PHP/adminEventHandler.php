<?php
require_once "connectionDB.php";
require_once "Administrator.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
session_start();
if(!isset($_SESSION["username"],$_SESSION["email"],$_SESSION["isValid"]) && !$_SESSION["isValid"]){
    header("Location: ../PHP/login.php");
}
else{
    $url="../HTML/Administrator.html";
    if(isset($_POST["itemNamePizUpd"])){
        $pizzaScelta = $_POST["itemNamePizUpd"];
        $connessioneRiuscita = $dbAccess->openDBConnection();
        if($connessioneRiuscita)
        {
            $result = $dbAccess->selectPizza($pizzaScelta);
        }
        $dbAccess->closeDBConnection();

        $nome = $result[1]["nome"];
        $id = $result[1]["id_ingrediente"];
        $stringaIngre = $nome;
        $stringaIdIngre = $id;
        for($i=2;$i<count($result);$i++)
        {
            $nome = $result[$i]["nome"];
            $id = $result[$i]["id_ingrediente"];
            $stringaIngre = $stringaIngre."-".$nome;
            $stringaIdIngre = $stringaIdIngre."-".$id;
        }
        $replace=array("<interfacciaModifica/>" => 
        "<label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
        <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" value='".$result[0]["nome"]."' required/>
        <label for=\"text\" lang=\"ITA\">Categoria:</label>
        <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" value='".$result[0]["categoria"]."' required/>
        <label for=\"number\" lang=\"ITA\">Prezzo:</label>
        <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" value='".$result[0]["prezzo"]."' required/>
        <label for=\"text\" lang=\"ITA\">Descrizione: </label>
        <input type=\"text\" name=\"updDesc\" id=\"updDesc\" maxlenght=\"500\" value='".$result[0]["descrizione"]."'/>
        <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
        <ul>
            <li id=\"ingredient\" class=\"dropdown\">
            <a class=\"text-button dropbtn\">Ingrediente</a>
            <ul class=\"dropdown-content\">
                <listaIngredientiUpdate/>
            </ul>
            </li>
        </ul>
        <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value='".$stringaIngre."'  required/>
        <input type=\"text\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value='".$stringaIdIngre."' required/>
        <input type=\"text\" name=\"oldName\" id=\"oldName\" class=\"invIdIng\" value='".$result[0]["nome"]."' required/>
        <button type=\"button\" class=\"text-button\" onclick=\"removeItemUpd()\">Elimina ultimo ingrediente</button>"
        );
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        
    }
    else{
        if(isset($_POST["AggiungiPiz"])){
            if(isset($_POST["aggNomepizza"],$_POST["aggCategoriapizza"],$_POST["aggPrezzo"],$_POST["aggDesc"],$_POST["aggIngre"],$_POST["aggIngreId"])){
                $npizza = $_POST["aggNomepizza"];
                $catpizza = $_POST["aggCategoriapizza"];
                $prez = $_POST["aggPrezzo"];
                $des = $_POST["aggDesc"];
                $iding = $_POST["aggIngreId"];
                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->addPizza($npizza,$catpizza, $prez, $des, $iding);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result==true)
                {
                    $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box success\">Pizza Aggiunta con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della pizza!</p>");
                }
            }
            else
            {
                $replace = array("<messaggioPizzaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della pizza!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        }
        else{
            if(isset($_POST["ModificaPiz"])){
                if(isset($_POST["updNomepizza"],$_POST["updCategoriapizza"],$_POST["updPrezzo"],$_POST["updDesc"],$_POST["aggIngreUpd"],$_POST["aggIngreIdUpd"],$_POST["oldName"]))
                {
                    $npizza = $_POST["updNomepizza"];
                    $catpizza = $_POST["updCategoriapizza"];
                    $prez = $_POST["updPrezzo"];
                    $des = $_POST["updDesc"];
                    $idingre = $_POST["aggIngreIdUpd"];
                    $nomevecchio = $_POST["oldName"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->updatePizza($npizza,$catpizza, $prez, $des, $idingre, $nomevecchio);
                    }
                    $dbAccess->closeDBConnection();

                    $replace="";
                    if($result)
                    {
                        $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box success\">Pizza Modificata con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della pizza!</p>");
                    }
                    
                }
                else
                {
                    $replace = array("<messaggioPizzaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della pizza!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, $replace);
                echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
            }
            else{
                if(isset($_POST["EliminaPiz"])){
                    if(isset($_POST["delPiz"]))
                    {
                        $txt = explode("---", $_POST["delPiz"]);
                        $delete = $txt[0]; 

                        $connessioneRiuscita = $dbAccess->openDBConnection();
                        $result=false;
                        if($connessioneRiuscita)
                        {
                            $result = $dbAccess->delPizza($delete);
                        }
                        $dbAccess->closeDBConnection();

                        
                        if($result==true)
                        {
                            $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box success\">Pizza eliminata con successo!</p>");
                            
                        }
                        else
                        {
                            $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della pizza!</p>");
                        }
                    }
                    else
                    {
                        $replace = array("<messaggioPizzaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della pizza!</p>");
                    }
                    $stringHTML = UtilityFunctions::replacer($url, $replace);
                    echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                }
            }
        }
    }

    if(isset($_POST["itemNameBevUpd"])){
        $bevandaScelta = $_POST["itemNameBevUpd"];
        $connessioneRiuscita = $dbAccess->openDBConnection();
        if($connessioneRiuscita)
        {
            $result = $dbAccess->selectBevanda($bevandaScelta);
        }
        $dbAccess->closeDBConnection();

        $replace=array("<interfacciaModificaBev/>" => 
        "<label for=\"text\" lang=\"ITA\">Nome Bevanda:</label>
        <input type=\"text\" name=\"aggNomebevanda\" id=\"aggNomebevanda\" maxlength=\"30\" value='".$result[0]["nome"]."' required/>
        <label for=\"text\" lang=\"ITA\">Categoria:</label>
        <input type=\"text\" name=\"aggCategoriabevanda\" id=\"aggCategoriabevanda\" maxlength=\"30\" value='".$result[0]["categoria"]."' required/>
        <label for=\"number\" lang=\"ITA\">Gradi Alcolici:</label>
        <input type=\"number\" name=\"aggGradi\" id=\"aggGradi\" min=\"0.0\" step=\"0.1\" value='".$result[0]["gradiAlcolici"]."' required/>
        <label for=\"number\" lang=\"ITA\">Prezzo:</label>
        <input type=\"number\" name=\"aggPrezzoBev\" id=\"aggPrezzoBev\" min=\"0.0\" step=\"0.1\" value='".$result[0]["prezzo"]."' required/>
        <label for=\"text\" lang=\"ITA\">Descrizione: </label>
        <input type=\"text\" name=\"aggDescbev\" id=\"aggDescbev\" maxlenght=\"500\" value='".$result[0]["descrizione"]."'/>
        <input type=\"text\" name=\"oldNameBev\" id=\"oldNameBev\" class=\"invIdIng\" value='".$result[0]["nome"]."' required/>"
        );
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        
    }
    else{
        if(isset($_POST["AggiungiBev"])){
            if(isset($_POST["aggNomebevanda"],$_POST["aggCategoriabevanda"],$_POST["aggGradi"],$_POST["aggDescbev"],$_POST["aggPrezzoBev"])){
                $nbevanda = $_POST["aggNomebevanda"];
                $catbevanda = $_POST["aggCategoriabevanda"];
                $gradi = $_POST["aggGradi"];
                $des = $_POST["aggDescbev"];
                $prezzo = $_POST["aggPrezzoBev"];
                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->addBevanda($nbevanda,$catbevanda, $gradi, $des, $prezzo);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result==true)
                {
                    $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box success\">Bevanda Aggiunta con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della bevanda!</p>");
                }
            }
            else
            {
                $replace = array("<messaggioBevandaAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento della bevanda!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        }
        else{
            if(isset($_POST["ModificaBev"])){
                if(isset($_POST["aggNomebevanda"],$_POST["aggCategoriabevanda"],$_POST["aggGradi"],$_POST["aggDescbev"],$_POST["aggPrezzoBev"],$_POST["oldNameBev"]))
                {
                    $nbevanda = $_POST["aggNomebevanda"];
                    $catbevanda = $_POST["aggCategoriabevanda"];
                    $prez = $_POST["aggPrezzoBev"];
                    $des = $_POST["aggDescbev"];
                    $gradi = $_POST["aggGradi"];
                    $nomevecchio = $_POST["oldNameBev"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->updateBevanda($nbevanda,$catbevanda, $prez, $des, $gradi, $nomevecchio);
                    }
                    $dbAccess->closeDBConnection();

                    $replace="";
                    if($result)
                    {
                        $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box success\">Bevanda Modificata con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della bevanda!</p>");
                    }
                    
                }
                else
                {
                    $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica della bevanda!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, $replace);
                echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                    
            }
            else{
                if(isset($_POST["EliminaBev"])){
                    if(isset($_POST["delBev"]))
                    {
                        $txt = explode("---", $_POST["delBev"]);
                        $delete = $txt[0]; 

                        $connessioneRiuscita = $dbAccess->openDBConnection();
                        $result=false;
                        if($connessioneRiuscita)
                        {
                            $result = $dbAccess->delBevanda($delete);
                        }
                        $dbAccess->closeDBConnection();

                        
                        if($result==true)
                        {
                            $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box success\">Bevanda eliminata con successo!</p>");
                            
                        }
                        else
                        {
                            $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della bevanda!</p>");
                        }
                    }
                    else
                    {
                        $replace = array("<messaggioBevandaEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione della bevanda!</p>");
                    }
                    $stringHTML = UtilityFunctions::replacer($url, $replace);
                    echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                }
            }
        }
    }

    if(isset($_POST["itemNameDolceUpd"])){
        $dolceScelta = $_POST["itemNameDolceUpd"];
        $connessioneRiuscita = $dbAccess->openDBConnection();
        if($connessioneRiuscita)
        {
            $result = $dbAccess->selectDolce($dolceScelta);
        }
        $dbAccess->closeDBConnection();

        $replace=array("<interfacciaModificaDolce/>" => 
        "<label for=\"text\" lang=\"ITA\">Nome Dolce:</label>
        <input type=\"text\" name=\"aggNomedolce\" id=\"aggNomedolce\" maxlength=\"30\" value='".$result[0]["nome"]."' required/>
        <label for=\"number\" lang=\"ITA\">Prezzo:</label>
        <input type=\"number\" name=\"aggPrezzodolce\" id=\"aggPrezzodolce\" min=\"0.0\" step=\"0.1\" value='".$result[0]["prezzo"]."' required/>
        <label for=\"text\" lang=\"ITA\">Descrizione: </label>
        <input type=\"text\" name=\"aggDescdolce\" id=\"aggDescdolce\" maxlenght=\"500\" value='".$result[0]["descrizione"]."'/>
        <input type=\"text\" name=\"oldNamedolce\" id=\"oldNamedolce\" class=\"invIdIng\" value='".$result[0]["nome"]."' required/>"
        );
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        
    }
    else{
        if(isset($_POST["AggiungiDolce"])){
            if(isset($_POST["aggNomedolce"],$_POST["aggPrezzoDolce"],$_POST["aggDescdolce"])){
                $ndolce = $_POST["aggNomedolce"];
                $des = $_POST["aggDescdolce"];
                $prezzo = $_POST["aggPrezzoDolce"];
                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->addDolce($ndolce, $des, $prezzo);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result==true)
                {
                    $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box success\">Dolce Aggiunto con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento del dolce!</p>");
                }
            }
            else
            {
                $replace = array("<messaggioDolceAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento del dolce!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        }
        else{
            if(isset($_POST["ModificaDolce"])){
                if(isset($_POST["aggNomedolce"],$_POST["aggPrezzodolce"],$_POST["aggDescdolce"],$_POST["oldNamedolce"]))
                {
                    $ndolce = $_POST["aggNomedolce"];
                    $prez = $_POST["aggPrezzodolce"];
                    $des = $_POST["aggDescdolce"];
                    $nomevecchio = $_POST["oldNamedolce"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->updateDolce($ndolce, $prez, $des, $nomevecchio);
                    }
                    $dbAccess->closeDBConnection();

                    $replace="";
                    if($result)
                    {
                        $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box success\">Bevanda Modificato con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del dolce!</p>");
                    }
                    
                }
                else
                {
                    $replace = array("<messaggioBevandaModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del dolce!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, $replace);
                echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                    
            }
            else{
                if(isset($_POST["EliminaDolce"])){
                    if(isset($_POST["delDolce"]))
                    {
                        $delete = $_POST["delDolce"]; 

                        $connessioneRiuscita = $dbAccess->openDBConnection();
                        $result=false;
                        if($connessioneRiuscita)
                        {
                            $result = $dbAccess->delDolce($delete);
                        }
                        $dbAccess->closeDBConnection();

                        
                        if($result==true)
                        {
                            $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box success\">Dolce Eliminato con successo!</p>");
                            
                        }
                        else
                        {
                            $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione del dolce!</p>");
                        }
                    }
                    else
                    {
                        $replace = array("<messaggioDolceEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione del dolce!</p>");
                    }
                    $stringHTML = UtilityFunctions::replacer($url, $replace);
                    echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                }
            }
        }
    }


    if(isset($_POST["itemNameIngredienteUpd"])){
        $IDingredienteScelta = $_POST["itemNameIngredienteUpd"];
        $connessioneRiuscita = $dbAccess->openDBConnection();
        if($connessioneRiuscita)
        {
            $result = $dbAccess->selectIngrediente($IDingredienteScelta);
        }
        $dbAccess->closeDBConnection();

        $replace=array("<interfacciaModificaIngrediente/>" => 
        "<label for=\"text\" lang=\"ITA\">Nome Ingrediente:</label>
        <input type=\"text\" name=\"aggNomeingrediente\" id=\"aggNomeingrediente\" maxlength=\"30\" value='".$result[0]["nome"]."' required/>
        <label for=\"number\" lang=\"ITA\">Categoria Allergene:</label>
        <input type=\"number\" name=\"aggCategoriaIngrediente\" id=\"aggCategoriaIngrediente\" min=\"0\" step=\"1\" value='".$result[0]["allergene"]."' required/>
        <input type=\"text\" name=\"oldId\" id=\"oldId\" class=\"invIdIng\" value='".$result[0]["id_ingrediente"]."' required/>"
        );
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        
    }
    else{
        if(isset($_POST["AggiungiIngre"])){
            if(isset($_POST["aggNomeingred"],$_POST["aggCategoriaDolce"])){
                $ningrediente = $_POST["aggNomeingred"];
                $categoria = $_POST["aggCategoriaDolce"];
                
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $result=false;
                if($connessioneRiuscita)
                {
                    $result = $dbAccess->addIngrediente($ningrediente, $categoria);
                }
                $dbAccess->closeDBConnection();

                $replace="";
                if($result==true)
                {
                    $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box success\">Ingrediente Aggiunto con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento dell'ingrediente!</p>");
                }
            }
            else
            {
                $replace = array("<messaggioIngredienteAggiunta />" => "<p class=\"alert-box danger\">Errore nell'inserimento dell'ingrediente!</p>");
            }
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
        }
        else{
            if(isset($_POST["ModificaIngrediente"])){
                if(isset($_POST["aggNomeingrediente"],$_POST["aggCategoriaIngrediente"],$_POST["oldId"]))
                {
                    $ningred = $_POST["aggNaggNomeingredienteomedolce"];
                    $catallerg = $_POST["aggCategoriaIngrediente"];
                    $idvecchio = $_POST["oldId"];

                    $connessioneRiuscita = $dbAccess->openDBConnection();
                    $result=false;
                    if($connessioneRiuscita)
                    {
                        $result = $dbAccess->updateIngrediente($ningred, $catallerg, $idvecchio);
                    }
                    $dbAccess->closeDBConnection();

                    $replace="";
                    if($result)
                    {
                        $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box success\">Ingrediente Modificato con successo!</p>");
                        
                    }
                    else
                    {
                        $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box danger\">Errore nella modifica dell'ingrediente!</p>");
                    }
                    
                }
                else
                {
                    $replace = array("<messaggioIngredienteModificata />" => "<p class=\"alert-box danger\">Errore nella modifica del'ingrediente!</p>");
                }
                $stringHTML = UtilityFunctions::replacer($url, $replace);
                echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                    
            }
            else{
                if(isset($_POST["EliminaIngrediente"])){
                    if(isset($_POST["delIngrediente"]))
                    {
                        $delete = $_POST["delIngrediente"]; 

                        $connessioneRiuscita = $dbAccess->openDBConnection();
                        $result=false;
                        if($connessioneRiuscita)
                        {
                            $result = $dbAccess->delIngrediente($delete);
                        }
                        $dbAccess->closeDBConnection();

                        
                        if($result==true)
                        {
                            $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box success\">Ingrediente Eliminato con successo!</p>");
                            
                        }
                        else
                        {
                            $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione dell'ingrediente!</p>");
                        }
                    }
                    else
                    {
                        $replace = array("<messaggioIngredienteEliminata />" => "<p class=\"alert-box danger\">Errore nell'eliminazione dell'ingrediente!</p>");
                    }
                    $stringHTML = UtilityFunctions::replacer($url, $replace);
                    echo UtilityFunctions::replacerFromHTML($stringHTML,addReplaceFinali());
                }
                }
            }
        }
    }


}
?>