<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;


function checkadmin(){
    $connessione = new DBAccess();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"]))
    {
        header("Location: ../PHP/login.php");
    }
    $replace=addReplaceIniziali();
    $url = "../HTML/Administrator.html";
    echo UtilityFunctions::replacer($url, $replace);
    
}

function addReplaceIniziali()
{
    $add = array("<aggiungipizza/>" => 
                    "<form id=\"add-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <messaggioPizzaAggiunta />
                    <label for=\"text\" lang=\"ITA\">Nome Pizza:</label>
                    <input type=\"text\" name=\"aggNomepizza\" id=\"aggNomepizza\" maxlength=\"30\" placeholder=\"Inserisci nome pizza:\" />
                    <label for=\"text\" lang=\"ITA\">Categoria:</label>
                    <input type=\"text\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\" maxlength=\"30\" placeholder=\"Inserisci catergoria:\"/>
                    <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                    <input type=\"number\" name=\"aggPrezzo\" id=\"aggPrezzo\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\"/>
                    <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                    <input type=\"text\" name=\"aggDesc\" id=\"aggDesc\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                    <label for=\"text\" lang=\"ITA\">Ingredienti: </label>
                    <input type=\"text\" name=\"aggIngre\" id=\"aggIngre\" placeholder=\"Seleziona un ingrediente per inserirlo:\" readonly/>
                    <input type=\"text\" name=\"aggIngreId\" id=\"aggIngreId\" class=\"invIdIng\" readonly/>
                    <div id=\"post\">
                        <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Lista Ingredienti\"/>
                    </div>
                    </fieldset>
                  </form>",
                  "<eliminapizza/>" => 
                  "<form id=\"delete-pizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                  <fieldset>
                  <messaggioPizzaEliminata />
                  <label for=\"text\" lang=\"ITA\">Seleziona pizza da eliminare: </label>
                  <input type=\"text\" name=\"delPiz\" id=\"delPiz\" placeholder=\"Seleziona una pizza per eliminarla:\" readonly/>
                  <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaDelete\" class=\"text-button\" name=\"SelezionaDelete\" value=\"Lista Pizze\"/>
                  </div>
                  </fieldset>
                </form>",
                "<modificapizza/>" =>
                "<form id=\"upd-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                  <fieldset>
                    <messaggioPizzaModificata />
                    <label for=\"text\" lang=\"ITA\">Seleziona pizza da modificare: </label>
                    <interfacciaModifica/>
                    <div id=\"post\">
                      <input type=\"submit\" id=\"SelezionaModifica\" class=\"text-button\" name=\"SelezionaModifica\" value=\"Seleziona pizza!\"/>
                    </div>
                  </fieldset>
                </form>",


                "<disabilitaitem/>" =>
                "<form id=\"disab-item-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                  <label for=\"text\" lang=\"ITA\">Seleziona elemento da disabilitare: </label>
                  <messaggioElementoDisabilitato />
                  <div id=\"post\">
                    <input type=\"submit\" id=\"Disabilita\" class=\"text-button\" name=\"Disabilita\" value=\"Disabilita!\"/>
                  </div>
                </fieldset>
              </form>",
              "<disabilitaingred/>" =>
              "<form id=\"disab-item-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
              <fieldset>
                <label for=\"text\" lang=\"ITA\">Seleziona elemento da disabilitare: </label>
                <messaggioElementoDisabilitatoIng />
                <input type=\"hidden\" id=\"DisabilitaIngred\" class=\"text-button\" name=\"DisabilitaIngred\" value=\"DisabilitaIngred!\" readonly/>
                <div id=\"post\">
                  <input type=\"submit\" id=\"Disabilita\" class=\"text-button\" name=\"Disabilita\" value=\"Disabilita!\"/>
                </div>
              </fieldset>
            </form>",


            "<aggiungibevanda/>" =>
                "<form id=\"add-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                <messaggioBevandaAggiunta />
                <label for=\"text\" lang=\"ITA\">Nome Bevanda:</label>
                <input type=\"text\" name=\"aggNomebevanda\" id=\"aggNomebevanda\" maxlength=\"30\" placeholder=\"Inserisci nome bevanda:\" required/>
                <label for=\"text\" lang=\"ITA\">Categoria:</label>
                <input type=\"text\" name=\"aggCategoriabevanda\" id=\"aggCategoriabevanda\" maxlength=\"30\" placeholder=\"Inserisci catergoria:\" required/>
                <label for=\"number\" lang=\"ITA\">Gradi Alcolici:</label>
                <input type=\"number\" name=\"aggGradi\" id=\"aggGradi\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il grado alcolico:\" required/>
                <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                <input type=\"number\" name=\"aggPrezzoBev\" id=\"aggPrezzoBev\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\" required/>
                <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                <input type=\"text\" name=\"aggDescbev\" id=\"aggDescbev\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                <div id=\"post\">
                <input type=\"submit\" id=\"AggiungiBev\" class=\"text-button\" name=\"AggiungiBev\" value=\"Aggiungi\"/>
                </div>
                </fieldset>
                </form>",
                "<eliminabevanda/>" => 
                "<form id=\"delete-bevanda-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                <fieldset>
                <messaggioBevandaEliminata />
                <label for=\"text\" lang=\"ITA\">Seleziona bevanda da eliminare: </label>
                  <input type=\"text\" name=\"delBev\" id=\"delBev\" placeholder=\"Seleziona una bevanda per eliminarla:\" readonly/>
                  <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaDeleteBev\" class=\"text-button\" name=\"SelezionaDeleteBev\" value=\"Lista Bevande\"/>
                  </div>
                </fieldset>
              </form>",
              "<modificabevanda/>" =>
              "<form id=\"upd-bevanda-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                  <messaggioBevandaModificata />
                  <label for=\"text\" lang=\"ITA\">Seleziona bevanda da modificare: </label>
                  <interfacciaModificaBev/>
                  <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaModificaBev\" class=\"text-button\" name=\"SelezionaModificaBev\" value=\"Modifica\"/>
                  </div>
                </fieldset>
              </form>",


              "<aggiungidolce/>" =>
              "<form id=\"add-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <messaggioDolceAggiunta />
                    <label for=\"text\" lang=\"ITA\">Nome Dolce:</label>
                    <input type=\"text\" name=\"aggNomedolce\" id=\"aggNomedolce\" maxlength=\"30\" placeholder=\"Inserisci nome dolce:\" required/>
                    <label for=\"number\" lang=\"ITA\">Prezzo:</label>
                    <input type=\"number\" name=\"aggPrezzoDolce\" id=\"aggPrezzoDolce\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\" required/>
                    <label for=\"text\" lang=\"ITA\">Descrizione: </label>
                    <input type=\"text\" name=\"aggDescdolce\" id=\"aggDescdolce\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                    <div id=\"post\">
                        <input type=\"submit\" id=\"AggiungiDolce\" class=\"text-button\" name=\"AggiungiDolce\" value=\"Aggiungi\"/>
                    </div>
                    </fieldset>
                  </form>",
            "<eliminadolce/>" =>
                "<form id=\"delete-dolci-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                <fieldset>
                <messaggioDolceEliminata />
                <label for=\"text\" lang=\"ITA\">Seleziona dolce da eliminare: </label>
                <input type=\"text\" name=\"delDolce\" id=\"delDolce\" placeholder=\"Seleziona un dolce per eliminarlo:\"  readonly/>
                <div id=\"post\">
                    <input type=\"submit\" id=\"SelezionaDeleteDolce\" class=\"text-button\" name=\"SelezionaDeleteDolce\" value=\"Elimina\"/>
                </div>
                </fieldset>
            </form>",
            "<modificadolce/>" => 
            "<form id=\"upd-dolci-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
            <fieldset>
              <messaggioDolceModificata />
                <label for=\"text\" lang=\"ITA\">Seleziona dolce da modificare: </label>
              <interfacciaModificaDolce/>
              <div id=\"post\">
                <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Modifica\"/>
              </div>
            </fieldset>
          </form>",


          "<aggiungiingrediente/>" => 
          "<form id=\"add-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
          <fieldset>
          <messaggioIngredienteAggiunta />
          <label for=\"text\" lang=\"ITA\">Nome Ingrediente:</label>
          <input type=\"text\" name=\"aggNomeingred\" id=\"aggNomeingred\" maxlength=\"30\" placeholder=\"Inserisci nome ingrediente:\" required/>
          <label for=\"number\" lang=\"ITA\">Categoria Allergene:</label>
          <input type=\"number\" name=\"aggCategoriaDolce\" id=\"aggCategoriaDolce\" min=\"0\" step=\"1\" placeholder=\"Inserisci la categoria:\" required/>
          <div id=\"post\">
            <input type=\"submit\" id=\"AggiungiIngre\" class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi\"/>
          </div>
          </fieldset>
        </form>",
        "<eliminaingrediente/>" =>
        "<form id=\"delete-ingrediente-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
        <fieldset>
        <messaggioIngredienteEliminata />
        <label for=\"text\" lang=\"ITA\">Seleziona ingrediente da eliminare: </label>
        <input type=\"text\" name=\"delIngrediente\" id=\"delIngrediente\" placeholder=\"Seleziona un ingrediente per eliminarlo:\"  readonly/>
        <input type=\"text\" name=\"oldIdIngr\" id=\"oldIdIngr\" class=\"invIdIng\" readonly/>
        <div id=\"post\">
          <input type=\"submit\" id=\"SelezionaDeleteIngrediente\" class=\"text-button\" name=\"SelezionaDeleteIngrediente\" value=\"Elimina\"/>
        </div>
        </fieldset>
      </form>",
      "<modificaingrediente/>" =>
      "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
      <fieldset>
        <messaggioIngredienteModificata />
        <label for=\"text\" lang=\"ITA\">Seleziona ingrediente da modificare: </label>
        <interfacciaModificaIngrediente/>
        <div id=\"post\">
          <input type=\"submit\" id=\"SelezionaModificaIngrediente\" class=\"text-button\" name=\"SelezionaModificaIngrediente\" value=\"Modifica\"/>
        </div>
      </fieldset>
    </form>");
    return $add;
}
?>