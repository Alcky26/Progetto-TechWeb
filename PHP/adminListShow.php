<?php
require_once "connectionDB.php";
require_once "Administrator.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

        $_SESSION["NomePizza"] = (isset($_POST["aggNomepizzaMod"])&&$_SESSION["NomePizza"]="" ? $_POST["aggNomepizzaMod"] : "");
        $_SESSION["CategoriaPizza"] = (isset($_POST["aggCategoriapizzaMod"])&&$_SESSION["CategoriaPizza"]="" ? $_POST["aggCategoriapizzaMod"] : "");
        $_SESSION["PrezzoPizza"] = (isset($_POST["aggPrezzoMod"])&&$_SESSION["PrezzoPizza"]="" ? $_POST["aggPrezzoMod"] : "");
        $_SESSION["DescrizionePizza"] = (isset($_POST["aggDescMod"])&&$_SESSION["DescrizionePizza"]="" ? $_POST["aggDescMod"] : "");
        $_SESSION["Ingredienti"] = (isset($_POST["aggIngreMod"])&&$_SESSION["Ingredienti"]="" ? explode("-",$_POST["aggIngreMod"]) : "");
        $_SESSION["IdIngredienti"] = (isset($_POST["aggIngreIdMod"])&&$_SESSION["IdIngredienti"]="" ? explode("-",$_POST["aggIngreIdMod"]) : "");
        $connessioneOK = $dbAccess->openDBConnection();
        if ($connessioneOK) 
        {
            $result = $dbAccess->getIngredienti();
            $dbAccess->closeDBConnection();
            if ($result != null) {
                $string="";
                $isModifica="";
                foreach ($result as $i) {
                    $string = $string."<div class=\"subsubcontaineradmin\">";
                    if(!in_array($i["nome"], $_SESSION["Ingredienti"])&&!in_array($i["id_ingrediente"], $_SESSION["IdIngredienti"])){
                        $string = $string."<input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly />
                        <input type=\"hidden\"  name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"0\" />
                        <input type=\"checkbox\"  name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"1\" />
                        <input type=\"hidden\" name=\"idIng[]\" class=\"idIng\" value='".$i["id_ingrediente"]."'  />";
                    }
                    else{
                        $string = $string."<input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly />
                        <input type=\"hidden\"  name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"0\" />
                        <input type=\"checkbox\"  name=\"itemSelection[".$i["id_ingrediente"]."]\"  value=\"1\" checked/>
                        <input type=\"hidden\" name=\"idIng[]\" class=\"idIng\" value='".$i["id_ingrediente"]."'  />";
                        $isModifica="<input type=\"hidden\" id=\"isModifica\" name=\"isModifica\"  value=\"1\"/>";
                    }
                    $string = $string."</div>";
                }
                $replace=array("<ingredientiAggiungi/>" => 
                                    "<form id=\"add-ingTopizza-form\"   action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitile\">Ingredienti</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>".$isModifica."
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"AggiungiIngredienti\" class=\"text-button\" name=\"AggiungiIngredienti\" value=\"Aggiungi ingredienti selezionati\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" />
                    </div>";
                }
                $replace=array("<listaPizzeDelete/>" => 
                                    "<form id=\"delete-pizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Pizze</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaPizza\" class=\"text-button\" name=\"SelezionaPizza\" value=\"Seleziona pizza!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaPizzeDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></div>";
                }
                $replace=array("<listaBevandeDelete/>" => 
                                    "<form id=\"delete-bevanda-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Bevande</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaBevanda\" class=\"text-button\" name=\"SelezionaBevanda\" value=\"Seleziona Bevanda!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaBevandeDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessuna bevanda disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></div>";
                }
                $replace=array("<listaDolciDelete/>" => 
                                    "<form id=\"delete-dolci-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <h2 class=\"subtitle\">Dolci</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaDolce\" class=\"text-button\" name=\"SelezionaDolce\" value=\"Seleziona Dolce!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaDolciDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessun dolce disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></div>";
                }
                $replace=array("<listaPizzeModifica/>" => 
                                    "<form id=\"add-ingTopizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Pizze</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaPizzamodifica\" class=\"text-button\" name=\"SelezionaPizzamodifica\" value=\"Seleziona pizza!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaPizzeModifica/>>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
            $i=0;
            foreach($_POST["idIng"] as $var){
                if($_POST["itemSelection"][$var]==1)
                {
                    if($stringaNomi==""){
                        $stringaNomi = $stringaNomi . $_POST["itemName"][$i];
                        $stringaId = $stringaId . $var;
                    }
                    else{
                        $stringaNomi = $stringaNomi . "-" . $_POST["itemName"][$i];
                        $stringaId = $stringaId . "-" . $var;
                    }
                }
                $i++;
            }
            if(!isset($_POST["isModifica"])){
                $replace=array("<aggiungipizza/>" => 
                        "<form id=\"add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <messaggioPizzaAggiunta />
                        <label for=\"aggNomepizza\" lang=\"ITA\">Nome Pizza:</label>
                        <input type=\"text\" name=\"aggNomepizza\" id=\"aggNomepizza\" maxlength=\"30\" ".($_SESSION['NomePizza']=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$_SESSION['NomePizza']."\"")." required/>
                        <label for=\"aggCategoriapizza\" lang=\"ITA\">Categoria:</label>
                        <input type=\"text\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\"  maxlength=\"30\" ".($_SESSION['CategoriaPizza']=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$_SESSION['CategoriaPizza']."\"")." required/>
                        <label for=\"aggPrezzo\" lang=\"ITA\">Prezzo:</label>
                        <input type=\"number\" name=\"aggPrezzo\" id=\"aggPrezzo\"  min=\"0.0\" step=\"0.1\" ".($_SESSION['PrezzoPizza']=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$_SESSION['PrezzoPizza']."\"")." required/>
                        <label for=\"aggDesc\" lang=\"ITA\">Descrizione: </label>
                        <input type=\"text\" name=\"aggDesc\" id=\"aggDesc\"  maxlenght=\"500\" ".($_SESSION['DescrizionePizza']=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$_SESSION['DescrizionePizza']."\"")." />
                        <label for=\"aggIngre\" lang=\"ITA\">Ingredienti: </label>
                        <input type=\"text\" name=\"aggIngre\" id=\"aggIngre\"  value=\"".$stringaNomi."\" readonly/>
                        <input type=\"hidden\" name=\"aggIngreId\"  class=\"invIdIng\" value=\"".$stringaId."\" />
                        <div class=\"post\">
                            <input type=\"submit\" id=\"AggiungiPiz\" class=\"text-button\" name=\"AggiungiPiz\" value=\"Aggiungi\"/>
                        </div>
                        </fieldset>
                    </form>
                    <form id=\"cancella-add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div class=\"post\">
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
                                <label for=\"updNomepizza\" lang=\"ITA\">Nome Pizza:</label>
                                <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" ".($_SESSION['NomePizza']=="" ? "placeholder=\"Inserisci nome pizza:\"" : "value=\"".$_SESSION['NomePizza']."\"")." readonly/>
                                <label for=\"updCategoriapizza\" lang=\"ITA\">Categoria:</label>
                                <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" ".($_SESSION['CategoriaPizza']=="" ? "placeholder=\"Inserisci categoria:\"" : "value=\"".$_SESSION['CategoriaPizza']."\"")." required/>
                                <label for=\"updPrezzo\" lang=\"ITA\">Prezzo:</label>
                                <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" ".($_SESSION['PrezzoPizza']=="" ? "placeholder=\"Inserisci prezzo:\"" : "value=\"".$_SESSION['PrezzoPizza']."\"")." required/>
                                <label for=\"updDesc\" lang=\"ITA\">Descrizione: </label>
                                <input type=\"text\" name=\"updDesc\"  maxlenght=\"500\" ".($_SESSION['DescrizionePizza']=="" ? "placeholder=\"Inserisci descrizione:\"" : "value=\"".$_SESSION['DescrizionePizza']."\"")." />
                                <label for=\"aggIngreUpd\" lang=\"ITA\">Ingredienti: </label>
                                <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value=\"".$stringaNomi."\" readonly/>
                                <input type=\"hidden\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value=\"".$stringaId."\" />
                                <div class=\"post\">
                                  <input type=\"submit\" id=\"ModificaPiz\" class=\"text-button\" name=\"ModificaPiz\" value=\"Modifica\"/>
                                </div>
                                </fieldset>
                            </form>
                            <form id=\"add-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                            <div class=\"post\">
                                <input type=\"hidden\" name=\"aggNomepizza\"  ".($_SESSION['NomePizza']=="" ? "" : "value=\"".$_SESSION['NomePizza']."\"")." />
                                <input type=\"hidden\" name=\"aggCategoriapizza\"  ".($_SESSION['CategoriaPizza']=="" ? "" : "value=\"".$_SESSION['CategoriaPizza']."\"")." />
                                <input type=\"hidden\" name=\"aggPrezzo\"   ".($_SESSION['PrezzoPizza']=="" ? "" : "value=\"".$_SESSION['PrezzoPizza']."\"")." />
                                <input type=\"hidden\" name=\"aggDesc\"   ".($_SESSION['DescrizionePizza']=="" ? "" : "value=\"".$_SESSION['DescrizionePizza']."\"")." />
                                <input type=\"hidden\" name=\"aggIngre\"  value=\"".$stringaNomi."\" />
                                <input type=\"hidden\" name=\"aggIngreId\"  class=\"invIdIng\" value=\"".$stringaId."\" />
                                <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi o togli ingredienti!\"/>
                            </div>
                            </form>
                            <form id=\"cancella-add-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                            <fieldset>
                            <div class=\"post\">
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
        if(isset($_POST["itemSelection"])){
            $replace=array("<eliminapizza/>" => 
                            "<form id=\"delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                            <fieldset>
                            <messaggioPizzaEliminata />
                            <label for=\"delPiz\" lang=\"ITA\">Seleziona pizza da eliminare: </label>
                            <input type=\"text\" name=\"delPiz\" id=\"delPiz\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                            <div class=\"post\">
                            <input type=\"submit\" id=\"EliminaPiz\" class=\"text-button\" name=\"EliminaPiz\" value=\"Elimina\"/>
                            </div>
                            </fieldset>
                        </form>
                        <form id=\"cancella-delete-pizza-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div class=\"post\">
                            <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioPizzaEliminata />\"/>
                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                        </div>
                        </fieldset>
                    </form>");
        }
    }
    if(isset($_POST["SelezionaBevanda"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $replace=array("<eliminabevanda/>" => 
                            "<form id=\"delete-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                            <fieldset>
                            <messaggioBevandaEliminata />
                            <label for=\"delBev\" lang=\"ITA\">Seleziona bevanda da eliminare: </label>
                            <input type=\"text\" name=\"delBev\" id=\"delBev\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                            <div class=\"post\">
                            <input type=\"submit\" id=\"EliminaBev\" class=\"text-button\" name=\"EliminaBev\" value=\"Elimina\"/>
                            </div>
                            </fieldset>
                        </form>
                        <form id=\"cancella-delete-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div class=\"post\">
                            <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioBevandaEliminata />\"/>
                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                        </div>
                        </fieldset>
                    </form>");
        }
    }
    if(isset($_POST["SelezionaDolce"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $replace=array("<eliminadolce/>" => 
                            "<form id=\"delete-dolce-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                            <fieldset>
                            <messaggioDolceEliminata />
                            <label for=\"delDolce\" lang=\"ITA\">Seleziona dolce da eliminare: </label>
                            <input type=\"text\" name=\"delDolce\" id=\"delDolce\" value=\"".$_POST["itemSelection"][0]."\" readonly/>
                            <div class=\"post\">
                            <input type=\"submit\" id=\"EliminaDolce\" class=\"text-button\" name=\"EliminaDolce\" value=\"Elimina\"/>
                            </div>
                            </fieldset>
                        </form>
                        <form id=\"cancella-delete-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div class=\"post\">
                            <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioDolceEliminata />\"/>
                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                        </div>
                        </fieldset>
                    </form>");
        }
    }    
    if(isset($_POST["SelezionaIngrediente"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $replace=array("<eliminaingrediente/>" => 
                            "<form id=\"delete-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" method=\"post\">
                            <fieldset>
                            <messaggioIngredienteEliminata />
                            <label for=\"delIngrediente\" lang=\"ITA\">Seleziona ingrediente da eliminare: </label>
                            <input type=\"text\" name=\"delIngrediente\" id=\"delIngrediente\" value=\"".$_POST["itemName"]["'".$_POST["itemSelection"][0]."'"]."\" readonly/>
                            <input type=\"hidden\" name=\"oldIdIngr\" id=\"oldIdIngr\" class=\"invIdIng\" value=\"".$_POST["itemSelection"][0]."\" />
                            <div class=\"post\">
                            <input type=\"submit\" id=\"EliminaIngrediente\" class=\"text-button\" name=\"EliminaIngrediente\" value=\"Elimina\"/>
                            </div>
                            </fieldset>
                        </form>
                        <form id=\"cancella-delete-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                        <fieldset>
                        <div class=\"post\">
                            <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioIngredienteEliminata />\"/>
                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                        </div>
                        </fieldset>
                    </form>");
        }
    }   
    
    if(isset($_POST["SelezionaPizzamodifica"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
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
                                    <label for=\"updNomepizza\" lang=\"ITA\">Nome Pizza:</label>
                                    <input type=\"text\" name=\"updNomepizza\" id=\"updNomepizza\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                    <label for=\"updCategoriapizza\" lang=\"ITA\">Categoria:</label>
                                    <input type=\"text\" name=\"updCategoriapizza\" id=\"updCategoriapizza\" maxlength=\"30\" value=\"".$result[0]["categoria"]."\" required/>
                                    <label for=\"updPrezzo\" lang=\"ITA\">Prezzo:</label>
                                    <input type=\"number\" name=\"updPrezzo\" id=\"updPrezzo\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                    <label for=\"updDesc\" lang=\"ITA\">Descrizione: </label>
                                    <input type=\"text\" name=\"updDesc\" id=\"updDesc\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                    <label for=\"aggIngreUpd\" lang=\"ITA\">Ingredienti: </label>
                                    <input type=\"text\" name=\"aggIngreUpd\" id=\"aggIngreUpd\" value=\"".$stringnome."\" readonly/>
                                    <input type=\"hidden\" name=\"aggIngreIdUpd\" id=\"aggIngreIdUpd\" class=\"invIdIng\" value=\"".$stringid."\" />
                                    <div class=\"post\">
                                    <input type=\"submit\" id=\"ModificaPiz\" class=\"text-button\" name=\"ModificaPiz\" value=\"Modifica\"/>
                                    </div>
                                    </fieldset>
                                </form>
                                <form id=\"upd-pizza-form-modifica\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                                <div class=\"post\">
                                    <input type=\"hidden\" name=\"aggNomepizza\"  ".($result[0]["nome"]=="" ? "" : "value=\"".$result[0]["nome"]."\"")." />
                                    <input type=\"hidden\" name=\"aggCategoriapizza\"  ".($result[0]["categoria"]=="" ? "" : "value=\"".$result[0]["categoria"]."\"")." />
                                    <input type=\"hidden\" name=\"aggPrezzo\"   ".($result[0]["prezzo"]=="" ? "" : "value=\"".$result[0]["prezzo"]."\"")." />
                                    <input type=\"hidden\" name=\"aggDesc\"   ".($result[0]["descrizione"]=="" ? "" : "value=\"".$result[0]["descrizione"]."\"")." />
                                    <input type=\"hidden\" name=\"aggIngre\"  value=\"".$stringnome."\" />
                                    <input type=\"hidden\" name=\"aggIngreId\"  class=\"invIdIng\" value=\"".$stringid."\" />
                                    <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi o togli ingredienti!\"/>
                                </div>
                                </form>
                                <form id=\"cancella-upd-pizza-form-annulla\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
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
                    <p>Seleziona pizza da modificare: </p>
                    <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaModifica\" class=\"text-button\" name=\"SelezionaModifica\" value=\"Seleziona pizza!\"/>
                    </div>
                </fieldset>
                </form>");
            }
        }
    }

    if(isset($_POST["SelezionaBevandamodifica"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $connessioneOK = $dbAccess->openDBConnection();
            if ($connessioneOK) 
            {
                $result = $dbAccess->selectBevanda($_POST["itemSelection"][0]);
                
                if ($result != null) {
                    $replace=array("<modificabevanda/>" => 
                                    "<form id=\"upd-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <messaggioBevandaModificata />
                                    <label for=\"aggNomebevandaMod\" lang=\"ITA\">Nome Pizza:</label>
                                    <input type=\"text\" name=\"aggNomebevandaMod\" id=\"aggNomebevandaMod\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                    <label for=\"aggCategoriabevandaMod\" lang=\"ITA\">Categoria:</label>
                                    <input type=\"text\" name=\"aggCategoriabevandaMod\" id=\"aggCategoriabevandaMod\" maxlength=\"30\" value=\"".$result[0]["categoria"]."\" required/>
                                    <label for=\"aggPrezzoBevMod\" lang=\"ITA\">Prezzo:</label>
                                    <input type=\"number\" name=\"aggPrezzoBevMod\" id=\"aggPrezzoBevMod\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                    <label for=\"aggGradiMod\" lang=\"ITA\">Gradi Alcolici:</label>
                                    <input type=\"number\" name=\"aggGradiMod\" id=\"aggGradiMod\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["gradiAlcolici"]."\" required/>
                                    <label for=\"aggDescbevMod\" lang=\"ITA\">Descrizione: </label>
                                    <input type=\"text\" name=\"aggDescbevMod\" id=\"aggDescbevMod\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                    <div class=\"post\">
                                    <input type=\"submit\" id=\"ModificaBev\" class=\"text-button\" name=\"ModificaBev\" value=\"Modifica\"/>
                                    </div>
                                    </fieldset>
                                </form>
                                <form id=\"cancella-upd-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
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
                    <p>Seleziona bevanda da modificare: </p>
                    <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaModificaBev\" class=\"text-button\" name=\"SelezionaModificaBev\" value=\"Seleziona bevanda!\"/>
                    </div>
                </fieldset>
                </form>");
            }
        }
    }

    if(isset($_POST["SelezionaDolcemodifica"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $connessioneOK = $dbAccess->openDBConnection();
            if ($connessioneOK) 
            {
                $result = $dbAccess->selectDolce($_POST["itemSelection"][0]);
                
                if ($result != null) {
                    $replace=array("<modificadolce/>" => 
                                    "<form id=\"upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <messaggioDolceModificata />
                                    <label for=\"aggNomedolceMod\" lang=\"ITA\">Nome Dolce:</label>
                                    <input type=\"text\" name=\"aggNomedolceMod\" id=\"aggNomedolceMod\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" readonly/>
                                    <label for=\"aggPrezzodolceMod\" lang=\"ITA\">Prezzo:</label>
                                    <input type=\"number\" name=\"aggPrezzodolceMod\" id=\"aggPrezzodolceMod\" min=\"0.0\" step=\"0.1\" value=\"".$result[0]["prezzo"]."\" required/>
                                    <label for=\"aggDescdolceMod\" lang=\"ITA\">Descrizione: </label>
                                    <input type=\"text\" name=\"aggDescdolceMod\" id=\"aggDescdolceMod\" maxlenght=\"500\" value=\"".$result[0]["descrizione"]."\" />
                                    <div class=\"post\">
                                    <input type=\"submit\" id=\"ModificaDolce\" class=\"text-button\" name=\"ModificaDolce\" value=\"Modifica\"/>
                                    </div>
                                    </fieldset>
                                </form>
                                <form id=\"cancella-upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
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
                            <p>Seleziona dolce da modificare: </p>
                            <div class=\"post\">
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
                        <p>Seleziona dolce da modificare: </p>
                        <div class=\"post\">
                        <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                        </div>
                    </fieldset>
                    </form>");
            }
        }
    }   

    if(isset($_POST["SelezionaIngredientemodifica"])){
        $url="../HTML/Administrator.html";
        if(isset($_POST["itemSelection"])){
            $connessioneOK = $dbAccess->openDBConnection();
            if ($connessioneOK) 
            {
                $result = $dbAccess->selectIngrediente($_POST["itemSelection"][0]);
                
                if ($result != null) {
                    $replace=array("<modificaingrediente/>" => 
                                    "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <messaggioIngredienteModificata />
                                    <label for=\"aggNomeingredienteMod\" lang=\"ITA\">Nome Ingrediente:</label>
                                    <input type=\"text\" name=\"aggNomeingredienteMod\" id=\"aggNomeingredienteMod\" maxlength=\"30\" value=\"".$result[0]["nome"]."\" required/>
                                    <label for=\"aggCategoriaIngredienteMod\" lang=\"ITA\">Categoria allergene:</label>
                                    <input type=\"number\" name=\"aggCategoriaIngredienteMod\" id=\"aggCategoriaIngredienteMod\" value=\"".$result[0]["allergene"]."\" required/>
                                    <input type=\"hidden\" name=\"oldIdMod\" id=\"oldIdMod\" value=\"".$result[0]["id_ingrediente"]."\" />
                                    <div class=\"post\">
                                    <input type=\"submit\" id=\"ModificaIngrediente\" class=\"text-button\" name=\"ModificaIngrediente\" value=\"Modifica\"/>
                                    </div>
                                    </fieldset>
                                </form>
                                <form id=\"cancella-upd-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
                                        <input type=\"text\" name=\"qualeSost\" class=\"invisibile\" value=\"<messaggioIngredienteModificata />\"/>
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
                            <p>Seleziona dolce da modificare: </p>
                            <div class=\"post\">
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
                        <p>Seleziona dolce da modificare: </p>
                        <div class=\"post\">
                        <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Seleziona bevanda!\"/>
                        </div>
                    </fieldset>
                    </form>");
            }
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"text\" name=\"itemCateg\" value='".$i["categoria"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></div>";
                }
                $replace=array("<listaBevandeModifica/>" => 
                                    "<form id=\"upd-bev-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Bevande</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaBevandamodifica\" class=\"text-button\" name=\"SelezionaBevandamodifica\" value=\"Seleziona bevanda!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaBevandeModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessuna pizza disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["nome"]."\" /></div>";
                }
                $replace=array("<listaDolciModifica/>" => 
                                    "<form id=\"upd-dolce-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Dolci</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaDolcemodifica\" class=\"text-button\" name=\"SelezionaDolcemodifica\" value=\"Seleziona Dolce!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaDolciModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessun dolce disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName\" value='".$i["nome"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["id_ingrediente"]."\" />
                    </div>";
                }
                $replace=array("<listaIngredientiModifica/>" => 
                                    "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Ingredienti</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaIngredientemodifica\" class=\"text-button\" name=\"SelezionaIngredientemodifica\" value=\"Seleziona Ingrediente!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaIngredientiModifica/>" => 
                                    "<p class=\"alert-box danger\">Nessun ingrediente disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                    $string = $string."<div class=\"subsubcontaineradmin\">
                    <input type=\"text\" name=\"itemName['".$i["id_ingrediente"]."']\" value='".$i["nome"]."' readonly />
                    <input type=\"radio\"  name=\"itemSelection[]\" value=\"".$i["id_ingrediente"]."\" />
                    </div>";
                }
                $replace=array("<listaIngredientiDelete/>" => 
                                    "<form id=\"delete-ingredienti-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Ingredienti</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"SelezionaIngrediente\" class=\"text-button\" name=\"SelezionaIngrediente\" value=\"Seleziona Ingrediente!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
                                            <input type=\"submit\" id=\"Annulla\" class=\"text-button\" name=\"Annulla\" value=\"Annulla\"/>
                                        </div>
                                    </form>");
            }
            else{
                $replace=array("<listaIngredientiDelete/>" => 
                                    "<p class=\"alert-box danger\">Nessun ingrediente disponibile!</p>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                    <div class=\"post\">
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
                        $string = $string."<div class=\"subsubcontaineradmin\">
                        <input type=\"text\" name=\"itemName[]\" value='".$i["nome"]."' readonly />
                        <input type=\"hidden\"  name=\"itemSelection[".$i["nome"]."]\"  value=\"0\" />
                        <input type=\"checkbox\"  name=\"itemSelection[".$i["nome"]."]\"  value=\"1\" ".($i["disponibile"] ? "checked" : "unchecked")."/>
                        <input type=\"hidden\"  name=\"itemSelectionOld[".$i["nome"]."]\" ".($i["disponibile"] ? "value=\"1\"" : "value=\"0\"")."/>
                        </div>";
                }
                $replace=array("<elementidisponibili/>" => 
                                    "<form id=\"change-diponib-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                                        <h2 class=\"subtitle\">Elementi</h2>
                                        <div class=\"grid-subcontaineradmin\">".$string."</div>
                                        ".$ingredienti."
                                        <div class=\"post\">
                                            <input type=\"submit\" id=\"ChangeDisponib\" class=\"text-button\" name=\"ChangeDisponib\" value=\"Conferma cambio diponibilità!\"/>
                                        </div>
                                    </form>
                                    <form id=\"annulla-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                                    <fieldset>
                                    <div class=\"post\">
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
                    $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box success\">Elemento/i cambiati con successo!</p>");
                    
                }
                else
                {
                    $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilità!</p>");
                }
            }
            else
            {
                if($result4!=0)
                {
                    $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box success\">Elemento/i cambiati con successo!</p>");
                }
                else
                {
                    $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilità!</p>");
                }
            }
            
        }
        else
        {
            if(isset($_POST["isIngred"])){
                $replace = array("<messaggioElementoDisabilitatoIng />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilità!</p>");
            }
            else{
                $replace = array("<messaggioElementoDisabilitato />" => "<p class=\"alert-box danger\">Errore nella modifica della disponibilità!</p>");
            }
        }
    }
    
    


    if(isset($_POST["Annulla"])){
        $url="../HTML/Administrator.html";
        echo UtilityFunctions::replacer($url, addReplaceIniziali());
    }
    else{
        if($replace==""){
            $url="../HTML/Administrator.html";
            echo UtilityFunctions::replacer($url, addReplaceIniziali());
        }
        else{
            $stringHTML = UtilityFunctions::replacer($url, $replace);
            echo UtilityFunctions::replacerFromHTML($stringHTML, addReplaceIniziali());
        }
    }
     
}



?>