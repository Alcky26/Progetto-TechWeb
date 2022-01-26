<?php
require_once "connectionDB.php";
require_once "Administrator.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
session_start();
if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"])){
    header("Location: ../PHP/login.php");
}
else{
    $url="../HTML/adminListShow.html";
    $replace ="";
    if(isset($_POST["AggiungiIngre"])){
        $_SESSION["NomePizza"] = (isset($_POST["aggNomepizza"]) ? $_POST["aggNomepizza"] : "");
        $_SESSION["CategoriaPizza"] = (isset($_POST["aggCategoriapizza"]) ? $_POST["aggCategoriapizza"] : "");
        $_SESSION["PrezzoPizza"] = (isset($_POST["aggPrezzo"]) ? $_POST["aggPrezzo"] : "");
        $_SESSION["DescrizionePizza"] = (isset($_POST["aggDesc"]) ? $_POST["aggDesc"] : "");
        $_SESSION["Ingredienti"] = (isset($_POST["aggIngre"]) ? explode("-",$_POST["aggIngre"]) : "");
        $_SESSION["IdIngredienti"] = (isset($_POST["aggIngreId"]) ? explode("-",$_POST["aggIngreId"]) : "");
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getIngredienti();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                $isModifica="";
                foreach ($result as $i) {
                    if(!in_array($i["nome"], $_SESSION["Ingredienti"])&&!in_array($i["id_ingrediente"], $_SESSION["IdIngredienti"])){
                        $string = $string."<tr><td><input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly /></td>
                        <td><input type=\"hidden\" id=\"itemSelection\" name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"0\" />
                        <input type=\"checkbox\" id=\"itemSelection\" name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"1\" /></td>
                        <td><input type=\"text\" name=\"idIng[]\" class=\"idIng\" value='".$i["id_ingrediente"]."' readonly /></td></tr>";
                    }
                    else{
                        $string = $string."<tr><td><input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly /></td>
                        <td><input type=\"hidden\" id=\"itemSelection\" name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"0\" />
                        <input type=\"checkbox\" id=\"itemSelection\" name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"1\" checked/></td>
                        <td><input type=\"text\" name=\"idIng[]\" class=\"idIng\" value='".$i["id_ingrediente"]."' readonly /></td></tr>";
                        $isModifica="<input type=\"hidden\" id=\"isModifica\" name=\"isModifica\"  value=\"1\"/>";
                    }
                }
                $replace=array("<ingredientiAggiungi/>" => 
                                    "<form id=\"add-ingTopizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Ingredienti</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Ingrediente</th><th>Selezione ( almeno 1 )</th><th></th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        ".$isModifica."
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"AggiungiIngredienti\" class=\"text-button\" name=\"AggiungiIngredienti\" value=\"Aggiungi ingredienti selezionati\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div id=\"post\">
                                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                    </div>
                                    </fieldset>
                                </form>");
            }
        }
    }

    if(isset($_POST["SelezionaDelete"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getPizzeDelete();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaPizzeDelete/>" => 
                                    "<form id=\"delete-pizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Pizze</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Pizza</th><th>Categoria</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaPizza\" class=\"text-button\" name=\"SelezionaPizza\" value=\"Seleziona pizza!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaPizzeDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }

    if(isset($_POST["SelezionaDeleteBev"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getBevandeDelete();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaBevandeDelete/>" => 
                                    "<form id=\"delete-bevanda-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Bevande</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Bevanda</th><th>Categoria</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaBevanda\" class=\"text-button\" name=\"SelezionaBevanda\" value=\"Seleziona Bevanda!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaBevandeDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessuna bevanda disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }
    
    if(isset($_POST["SelezionaDeleteDolce"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getDolciDelete();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaDolciDelete/>" => 
                                    "<form id=\"delete-dolci-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Dolci</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Dolce</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaDolce\" class=\"text-button\" name=\"SelezionaDolce\" value=\"Seleziona Dolce!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaDolciDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessun dolce disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }

    if(isset($_POST["SelezionaModifica"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getPizze();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaPizzeModifica/>" => 
                                    "<form id=\"add-ingTopizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Pizze</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Pizza</th><th>Categoria</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaPizzamodifica\" class=\"text-button\" name=\"SelezionaPizzamodifica\" value=\"Seleziona pizza!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaPizzeModifica/>>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }

    if(isset($_POST["AggiungiIngredienti"])){
        if(isset($_POST["itemName"], $_POST["idIng"], $_POST["itemSelection"])){
            $url="../HTML/Administrator.html";
            $stringaNomi="";
            $stringaId="";
            for($i=0; $i < count($_POST["idIng"]); $i++)
            {
                if($_POST["itemSelection"][$i+1]==1)
                {
                    if($stringaNomi==""){
                        $stringaNomi = $stringaNomi . $_POST["itemName"][$i];
                        $stringaId = $stringaId . $_POST["idIng"][$i];
                    }
                    else{
                        $stringaNomi = $stringaNomi . "-" . $_POST["itemName"][$i];
                        $stringaId = $stringaId . "-" . $_POST["idIng"][$i];
                    }
                }
            }
            if(!isset($_POST["isModifica"])){
                $replace=array("<aggiungipizza/>" => 
                        "<form id=\"add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <messaggioPizzaAggiunta />
                        <label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
                        <input type=\"text\" name=\"aggNomepizza\" id=\"aggNomepizza\" maxlength=\"30\" ".($_SESSION['NomePizza']=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$_SESSION['NomePizza']."\"")." required/>
                        <label for=\"text\" lang=\"ITA\">Categoria:</label>
                        <input type=\"text\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\" maxlength=\"30\" ".($_SESSION['CategoriaPizza']=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$_SESSION['CategoriaPizza']."\"")." required/>
                        <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                        <input type=\"number\" name=\"aggPrezzo\" id=\"aggPrezzo\" min=\"0.0\" step=\"0.1\" ".($_SESSION['PrezzoPizza']=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$_SESSION['PrezzoPizza']."\"")." required/>
                        <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                        <input type=\"text\" name=\"aggDesc\" id=\"aggDesc\" maxlenght=\"500\" ".($_SESSION['DescrizionePizza']=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$_SESSION['DescrizionePizza']."\"")." />
                        <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
                        <input type=\"text\" name=\"aggIngre\" id=\"aggIngre\" value=\"".$stringaNomi."\" readonly/>
                        <input type=\"text\" name=\"aggIngreId\" id=\"aggIngreId\" class=\"invIdIng\" value=\"".$stringaId."\" readonly/>
                        <div id=\"post\">
                            <input type=\"submit\" id=\"AggiungiPiz\" class=\"text-button\" name=\"AggiungiPiz\" value=\"Aggiungi\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div id=\"post\">
                            <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioPizzaAggiunta />\"/>
                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                        </div>
                        </fieldset>
                    </form>");
            }
            else{
                $replace=array("<modificapizza/>" => 
                                "<form id=\"add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <messaggioPizzaAggiunta />
                                <label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
                                <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" ".($_SESSION['NomePizza']=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$_SESSION['NomePizza']."\"")." readonly/>
                                <label for=\"text\" lang=\"ITA\">Categoria:</label>
                                <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" ".($_SESSION['CategoriaPizza']=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$_SESSION['CategoriaPizza']."\"")." required/>
                                <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                                <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" ".($_SESSION['PrezzoPizza']=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$_SESSION['PrezzoPizza']."\"")." required/>
                                <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                                <input type=\"text\" name=\"updDesc\" id=\"aggDesc\" maxlenght=\"500\" ".($_SESSION['DescrizionePizza']=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$_SESSION['DescrizionePizza']."\"")." />
                                <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
                                <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value=\"".$stringaNomi."\" readonly/>
                                <input type=\"text\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value=\"".$stringaId."\" readonly/>
                                <div id=\"post\">
                                  <input type=\"submit\" id=\"ModificaPiz\" class=\"text-button\" name=\"ModificaPiz\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"add-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                            <div id=\"post\">
                                <input type=\"hidden\" name=\"aggNomepizza\" id=\"aggNomepizza\" ".($_SESSION['NomePizza']=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$_SESSION['NomePizza']."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\" ".($_SESSION['CategoriaPizza']=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$_SESSION['CategoriaPizza']."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggPrezzo\" id=\"aggPrezzo\"  ".($_SESSION['PrezzoPizza']=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$_SESSION['PrezzoPizza']."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggDesc\" id=\"aggDesc\"  ".($_SESSION['DescrizionePizza']=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$_SESSION['DescrizionePizza']."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggIngre\" id=\"aggIngre\" value=\"".$stringaNomi."\" readonly/>
                                <input type=\"hidden\" name=\"aggIngreId\" id=\"aggIngreId\" class=\"invIdIng\" value=\"".$stringaId."\" readonly/>
                                <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi o togli ingredienti!\"/>
                            </div>
                            </form>
                            <form id=\"cancella-add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                            <fieldset>
                            <div id=\"post\">
                                <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioPizzaModificata />\"/>
                                <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                            </div>
                            </fieldset>
                        </form>");
            }
                unset($_SESSION['NomePizza']);
                unset($_SESSION['CategoriaPizza']);
                unset($_SESSION['PrezzoPizza']);
                unset($_SESSION['DescrizionePizza']);
                unset($_SESSION['Ingredienti']);
                unset($_SESSION['IdIngredienti']);
        }       
    }
    if(isset($_POST["SelezionaPizza"])){
        $url="../HTML/Administrator.html";
        $replace=array("<eliminapizza/>" => 
                        "<form id=\"delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                        <fieldset>
                        <messaggioPizzaEliminata />
                        <label for=\"text\" lang=\"ITA\">Seleziona pizza da eliminare: </label>
                        <input type=\"text\" name=\"delPiz\" id=\"delPiz\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"EliminaPiz\" class=\"text-button\" name=\"EliminaPiz\" value=\"Elimina\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <div id=\"post\">
                        <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioPizzaEliminata />\"/>
                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                    </div>
                    </fieldset>
                </form>");
    }
    if(isset($_POST["SelezionaBevanda"])){
        $url="../HTML/Administrator.html";
        $replace=array("<eliminabevanda/>" => 
                        "<form id=\"delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                        <fieldset>
                        <messaggioBevandaEliminata />
                        <label for=\"text\" lang=\"ITA\">Seleziona bevanda da eliminare: </label>
                        <input type=\"text\" name=\"delBev\" id=\"delBev\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"EliminaBev\" class=\"text-button\" name=\"EliminaBev\" value=\"Elimina\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <div id=\"post\">
                        <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioBevandaEliminata />\"/>
                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                    </div>
                    </fieldset>
                </form>");
    }
    if(isset($_POST["SelezionaDolce"])){
        $url="../HTML/Administrator.html";
        $replace=array("<eliminadolce/>" => 
                        "<form id=\"delete-dolce-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                        <fieldset>
                        <messaggioDolceEliminata />
                        <label for=\"text\" lang=\"ITA\">Seleziona dolce da eliminare: </label>
                        <input type=\"text\" name=\"delDolce\" id=\"delDolce\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"EliminaDolce\" class=\"text-button\" name=\"EliminaDolce\" value=\"Elimina\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <div id=\"post\">
                        <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioDolceEliminata />\"/>
                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                    </div>
                    </fieldset>
                </form>");
    }    
    if(isset($_POST["SelezionaIngrediente"])){
        $url="../HTML/Administrator.html";
        $replace=array("<eliminaingrediente/>" => 
                        "<form id=\"delete-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                        <fieldset>
                        <messaggioIngredienteEliminata />
                        <label for=\"text\" lang=\"ITA\">Seleziona ingrediente da eliminare: </label>
                        <input type=\"text\" name=\"delIngrediente\" id=\"delIngrediente\" value=\"".$_POST["itemName"]["'".$_POST["itemSelection"][0]."'"]."\" readonly/>
                        <input type=\"text\" name=\"oldIdIngr\" id=\"oldIdIngr\" class=\"invIdIng\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"EliminaIngrediente\" class=\"text-button\" name=\"EliminaIngrediente\" value=\"Elimina\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <div id=\"post\">
                        <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioIngredienteEliminata />\"/>
                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                    </div>
                    </fieldset>
                </form>");
    }   
    
    if(isset($_POST["SelezionaPizzamodifica"])){
        $url="../HTML/Administrator.html";
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->selectPizza($_POST["itemSelection"][0]);
            
            if ($result != null) {
                $stringnome="";
                $stringid="";
                $result2 = $dbAccess->getIngredientiPizza($_POST["itemSelection"][0]);
                $dbAccess->closeDBConnection();
                foreach($result2 as $value){
                    if($stringid!="" && $stringnome!=""){
                        $stringnome = $stringnome."-".$value["nome"];
                        $stringid =$stringid."-".$value["id_ingrediente"];
                    }
                    else{
                        $stringnome = $value["nome"];
                        $stringid = $value["id_ingrediente"];
                    }
                }
                $replace=array("<modificapizza/>" => 
                                "<form id=\"upd-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <messaggioPizzaModificata />
                                <label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
                                <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                <label for=\"text\" lang=\"ITA\">Categoria:</label>
                                <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" value=\"".$result[0]["categoria"]."\" required/>
                                <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                                <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                                <input type=\"text\" name=\"updDesc\" id=\"updDesc\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
                                <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value=\"".$stringnome."\" readonly/>
                                <input type=\"text\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value=\"".$stringid."\" readonly/>
                                <div id=\"post\">
                                  <input type=\"submit\" id=\"ModificaPiz\" class=\"text-button\" name=\"ModificaPiz\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"upd-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                            <div id=\"post\">
                                <input type=\"hidden\" name=\"aggNomepizza\" id=\"aggNomepizza\" ".($result[0]["nome"]=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$result[0]["nome"]."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\" ".($result[0]["categoria"]=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$result[0]["categoria"]."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggPrezzo\" id=\"aggPrezzo\"  ".($result[0]["prezzo"]=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$result[0]["prezzo"]."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggDesc\" id=\"aggDesc\"  ".($result[0]["descrizione"]=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$result[0]["descrizione"]."\"")." readonly/>
                                <input type=\"hidden\" name=\"aggIngre\" id=\"aggIngre\" value=\"".$stringnome."\" readonly/>
                                <input type=\"hidden\" name=\"aggIngreId\" id=\"aggIngreId\" class=\"invIdIng\" value=\"".$stringid."\" readonly/>
                                <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi o togli ingredienti!\"/>
                            </div>
                            </form>
                            <form id=\"cancella-upd-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <div id=\"post\">
                                    <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioPizzaModificata />\"/>
                                    <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                </div>
                                </fieldset>
                            </form>");
            }
        }
        else{
            $replace=array("<modificapizza/>" =>
            "<form id=\"upd-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
              <fieldset>
                <messaggioPizzaModificata />
                <label for=\"text\" lang=\"ITA\">Seleziona pizza da modificare: </label>
                <interfacciaModifica/>
                <div id=\"post\">
                  <input type=\"submit\" id=\"SelezionaModifica\" class=\"text-button\" name=\"SelezionaModifica\" value=\"Seleziona pizza!\"/>
                </div>
              </fieldset>
            </form>");
        }
    }

    if(isset($_POST["SelezionaBevandamodifica"])){
        $url="../HTML/Administrator.html";
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->selectBevanda($_POST["itemSelection"][0]);
            
            if ($result != null) {
                $replace=array("<modificabevanda/>" => 
                                "<form id=\"upd-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <messaggioBevandaModificata />
                                <label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
                                <input type=\"text\" name=\"aggNomebevanda\" id=\"aggNomebevanda\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                <label for=\"text\" lang=\"ITA\">Categoria:</label>
                                <input type=\"text\" name=\"aggCategoriabevanda\" id=\"aggCategoriabevanda\" maxlength=\"30\" value=\"".$result[0]["categoria"]."\" required/>
                                <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                                <input type=\"number\" name=\"aggPrezzoBev\" id=\"aggPrezzoBev\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                <label for=\"number\" lang=\"ITA\">Gradi Alcolici:</label>
                                <input type=\"number\" name=\"aggGradi\" id=\"aggGradi\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["gradiAlcolici"]."\" required/>
                                <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                                <input type=\"text\" name=\"aggDescbev\" id=\"aggDescbev\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                <div id=\"post\">
                                  <input type=\"submit\" id=\"ModificaBev\" class=\"text-button\" name=\"ModificaBev\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"cancella-upd-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <div id=\"post\">
                                    <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioBevandaModificata />\"/>
                                    <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                </div>
                                </fieldset>
                            </form>");
            }
        }
        else{
            $replace=array("<modificabevanda/>" =>
            "<form id=\"upd-bevanda-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
              <fieldset>
                <messaggioBevandaModificata />
                <label for=\"text\" lang=\"ITA\">Seleziona bevanda da modificare: </label>
                <interfacciaModificaBev/>
                <div id=\"post\">
                  <input type=\"submit\" id=\"SelezionaModificaBev\" class=\"text-button\" name=\"SelezionaModificaBev\" value=\"Seleziona bevanda!\"/>
                </div>
              </fieldset>
            </form>");
        }
    }

    if(isset($_POST["SelezionaDolcemodifica"])){
        $url="../HTML/Administrator.html";
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->selectDolce($_POST["itemSelection"][0]);
            
            if ($result != null) {
                $replace=array("<modificadolce/>" => 
                                "<form id=\"upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <messaggioDolceModificata />
                                <label for=\"text\" lang=\"ITA\">Nome Dolce:</label>
                                <input type=\"text\" name=\"aggNomedolce\" id=\"aggNomedolce\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                                <input type=\"number\" name=\"aggPrezzodolce\" id=\"aggPrezzodolce\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                                <input type=\"text\" name=\"aggDescdolce\" id=\"aggDescdolce\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                <div id=\"post\">
                                  <input type=\"submit\" id=\"ModificaDolce\" class=\"text-button\" name=\"ModificaDolce\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"cancella-upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <div id=\"post\">
                                    <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioDolceModificata />\"/>
                                    <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                </div>
                                </fieldset>
                            </form>");
            }
            else{
                $replace=array("<modificadolce/>" =>
                    "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                        <messaggioDolceModificata />
                        <label for=\"text\" lang=\"ITA\">Seleziona dolce da modificare: </label>
                        <interfacciaModificaDolce/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                        </div>
                    </fieldset>
                    </form>");
            }
        }
        else{
            $replace=array("<modificadolce/>" =>
                "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                    <messaggioDolceModificata />
                    <label for=\"text\" lang=\"ITA\">Seleziona dolce da modificare: </label>
                    <interfacciaModificaDolce/>
                    <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                    </div>
                </fieldset>
                </form>");
        }
    }   
    if(isset($_POST["SelezionaIngredientemodifica"])){
        $url="../HTML/Administrator.html";
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->selectIngrediente($_POST["itemSelection"][0]);
            
            if ($result != null) {
                $replace=array("<modificaingrediente/>" => 
                                "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <messaggioIngredienteModificata />
                                <label for=\"text\" lang=\"ITA\">Nome Ingrediente:</label>
                                <input type=\"text\" name=\"aggNomeingrediente\" id=\"aggNomeingrediente\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" required/>
                                <label for=\"number\" lang=\"ITA\">Categoria allergene:</label>
                                <input type=\"number\" name=\"aggCategoriaIngrediente\" id=\"aggCategoriaIngrediente\" maxlength=\"30\" value=\"".$result[0]["allergene"]."\" required/>
                                <input type=\"hidden\" name=\"oldId\" id=\"oldId\" maxlength=\"30\" value=\"".$result[0]["id_ingrediente"]."\" required/>
                                <div id=\"post\">
                                  <input type=\"submit\" id=\"ModificaIngrediente\" class=\"text-button\" name=\"ModificaIngrediente\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"cancella-upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                <fieldset>
                                <div id=\"post\">
                                    <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioDolceModificata />\"/>
                                    <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                </div>
                                </fieldset>
                            </form>");
            }
            else{
                $replace=array("<modificaingrediente/>" =>
                    "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                        <messaggioDolceModificata />
                        <label for=\"text\" lang=\"ITA\">Seleziona dolce da modificare: </label>
                        <interfacciaModificaDolce/>
                        <div id=\"post\">
                        <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                        </div>
                    </fieldset>
                    </form>");
            }
        }
        else{
            $replace=array("<modificaingrediente/>" =>
                "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                    <messaggioDolceModificata />
                    <label for=\"text\" lang=\"ITA\">Seleziona dolce da modificare: </label>
                    <interfacciaModificaDolce/>
                    <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                    </div>
                </fieldset>
                </form>");
        }
    }   
    

    if(isset($_POST["SelezionaModificaBev"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getBevandeModifica();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaBevandeModifica/>" => 
                                    "<form id=\"upd-bev-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Bevande</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Bevanda</th><th>Categoria</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaBevandamodifica\" class=\"text-button\" name=\"SelezionaBevandamodifica\" value=\"Seleziona bevanda!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaBevandeModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }

    if(isset($_POST["SelezionaModificaDolce"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getDolciModifica();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></td></td></tr>";
                }
                $replace=array("<listaDolciModifica/>" => 
                                    "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Dolci</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Dolce</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaDolcemodifica\" class=\"text-button\" name=\"SelezionaDolcemodifica\" value=\"Seleziona Dolce!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaDolciModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessun dolce disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }
    if(isset($_POST["SelezionaModificaIngrediente"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getIngredientiModifica();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["id_ingrediente"]."\" /></td></td></tr>";
                }
                $replace=array("<listaIngredientiModifica/>" => 
                                    "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Ingredienti</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Ingrediente</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaIngredientemodifica\" class=\"text-button\" name=\"SelezionaIngredientemodifica\" value=\"Seleziona Ingrediente!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaIngredientiModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessun ingrediente disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }
    

    if(isset($_POST["SelezionaDeleteIngrediente"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getIngredientiDelete();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                    $string = $string."<tr><td><input type=\"text\" name=\"itemName['".$i["id_ingrediente"]."']\" value='".$i["nome"]."' readonly /></td>
                    <td><input type=\"radio\" id=\"itemSelection\" name=\"itemSelection[]\" value=\"".$i["id_ingrediente"]."\" /></td></td></tr>";
                }
                $replace=array("<listaIngredientiDelete/>" => 
                                    "<form id=\"delete-ingredienti-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Ingredienti</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Ingrediente</th><th>Selezione</th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"SelezionaIngrediente\" class=\"text-button\" name=\"SelezionaIngrediente\" value=\"Seleziona Ingrediente!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaIngredientiDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessun ingrediente disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div id=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Ritorna alla gestione pizze\"/>
                                        </div>
                                    </form>");
            }
        }
    }

    if(isset($_POST["Disabilita"])){
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
        $result="";
        
        $ingredienti="";
        if(!isset($_POST["DisabilitaIngred"])){
            $result = $dbAccess->getItems();
        }
        else
        {
            $result = $dbAccess->getItemsIngred();
            $ingredienti="<input type=\"hidden\" id=\"isIngred\" name=\"isIngred\"  value=\"isIngred\" />";
        }
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                foreach ($result as $i) {
                        $string = $string."<tr><td><input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly /></td>
                        <td><input type=\"hidden\" id=\"itemSelection\" name=\"itemSelection[".$i["nome"]."]\"  value=\"0\" />
                        <input type=\"checkbox\" id=\"itemSelection\" name=\"itemSelection[".$i["nome"]."]\"  value=\"1\" ".($i["disponibile"] ? "checked" : "unchecked")."/></td>
                        <td><input type=\"hidden\" id=\"itemSelectionOld\" name=\"itemSelectionOld[".$i["nome"]."]\" ".($i["disponibile"] ? "value=\"1\"" : "value=\"0\"")."/></td></tr>";
                }
                $replace=array("<elementidisponibili/>" => 
                                    "<form id=\"change-diponib-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <table>
                                        <caption>
                                        <h3>Elementi</h3>
                                        </caption>
                                        <thead>
                                        <tr><th>Nome Elemento</th><th>Deseleziona per rendere non diponibile</th><th></th></tr>
                                        </thead>
                                        <tbody>
                                        ".$string."
                                        </tbody>
                                        </table>
                                        ".$ingredienti."
                                        <div id=\"post\">
                                            <input type=\"submit\" id=\"ChangeDisponib\" class=\"text-button\" name=\"ChangeDisponib\" value=\"Disabilita selezionati!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div id=\"post\">
                                        <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                    </div>
                                    </fieldset>
                                </form>");
            }
        }
    }

    if(isset($_POST["ChangeDisponib"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemName"],$_POST["itemSelection"],$_POST["itemSelectionOld"]))
        {
            $nelemento = $_POST["itemName"];
            $disponibile = $_POST["itemSelection"];
            $olddispo = $_POST["itemSelectionOld"];

            $connessioneRiuscita = $dbAccess->openDBConnection();
            if($connessioneRiuscita)
            {
                foreach($nelemento as $item)
                {
                    if(!isset($_POST["isIngred"])){
                        $result = $dbAccess->searchPizza($item);
                        $result2 = $dbAccess->searchBevanda($item);
                        $result3 = $dbAccess->searchDolce($item);
                        if($disponibile[$item]!=$olddispo[$item]){
                            if($result){
                                $result = $dbAccess->disabilitaPizza($item, $disponibile[$item], $olddispo[$item]);
                            }
                            else{
                                if($result2){
                                    $result2 = $dbAccess->disabilitaBevanda($item, $disponibile[$item], $olddispo[$item]);
                                }
                                else{
                                    if($result3){
                                        $result3 = $dbAccess->disabilitaDolce($item, $disponibile[$item], $olddispo[$item]);
                                    }
                                }
                            }
                        }
                    }
                    else{
                        if($disponibile[$item]!=$olddispo[$item]){
                            $result4 = $dbAccess->disabilitaIngred($item, $disponibile[$item], $olddispo[$item]);
                        }
                    }
                }
            }
            $dbAccess->closeDBConnection();
            if(!isset($_POST["isIngred"])){
                if($result!=0 || $result2!=0 || $result3!=0)
                {
                    $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box success\">Elemento/i disabilitati con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilita'!</p>");
                }
            }
            else
            {
                if($result4!=0)
                {
                    $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box success\">Elemento/i disabilitati con successo!</p>");
                }
                else
                {
                    $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilita'!</p>");
                }
            }
            
        }
        else
        {
            if(isset($_POST["isIngred"])){
                $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilita'!</p>");
            }
            else{
                $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilita'!</p>");
            }
        }
        
        $stringHTML = UtilityFunctions::replacer($url, addReplaceIniziali());
        echo UtilityFunctions::replacerFromHTML($stringHTML, $replace);
    }
    
    


    if(isset($_POST["Annulla"])){
        $url="../HTML/Administrator.html";
        echo UtilityFunctions::replacer($url, addReplaceIniziali());
    }
    else{
        $stringHTML = UtilityFunctions::replacer($url, $replace);
        echo UtilityFunctions::replacerFromHTML($stringHTML, addReplaceIniziali());
    }
     
}



?>