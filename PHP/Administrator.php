<?php

require_once "connectionDB.php";
use DB\DBAccess;

require_once "UtilityFunctions.php";
use UtilityFunctions\UtilityFunctions;


$connessione = new DBAccess();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["isAdmin"],$_SESSION["email"],$_SESSION["isValid"],$_SESSION["username"]))
{
    header("Location: ../PHP/login.php");
}
if(isset($_GET["enter"])&&$_GET["enter"]){
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
                    <label for=\"aggNomepizza\" lang=\"ITA\">Nome Pizza:</label>
                    <input type=\"text\" name=\"aggNomepizza\" id=\"aggNomepizza\" maxlength=\"30\" placeholder=\"Inserisci nome pizza:\" />
                    <label for=\"aggCategoriapizza\" lang=\"ITA\">Categoria:</label>
                    <input type=\"text\" name=\"aggCategoriapizza\" id=\"aggCategoriapizza\" maxlength=\"30\" placeholder=\"Inserisci catergoria:\"/>
                    <label for=\"aggPrezzo\" lang=\"ITA\">Prezzo:</label>
                    <input type=\"number\" name=\"aggPrezzo\" id=\"aggPrezzo\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\"/>
                    <label for=\"aggDesc\" lang=\"ITA\">Descrizione: </label>
                    <input type=\"text\" name=\"aggDesc\" id=\"aggDesc\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                    <label for=\"aggIngre\" lang=\"ITA\">Ingredienti: </label>
                    <input type=\"text\" name=\"aggIngre\" id=\"aggIngre\" placeholder=\"Seleziona un ingrediente per inserirlo:\" readonly/>
                    <input type=\"text\" name=\"aggIngreId\" id=\"aggIngreId\" class=\"invIdIng\" readonly/>
                    <div class=\"post\">
                        <input type=\"submit\"  class=\"text-button\" name=\"AggiungiIngre\" value=\"Lista Ingredienti\"/>
                    </div>
                    </fieldset>
                  </form>",
                  "<eliminapizza/>" => 
                  "<form id=\"delete-pizza-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                  <fieldset>
                  <messaggioPizzaEliminata />
                  <p>Seleziona pizza da eliminare: </p>
                  <input type=\"text\" name=\"delPiz\" id=\"delPiz\" placeholder=\"Seleziona una pizza per eliminarla:\" readonly/>
                  <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaDelete\" class=\"text-button\" name=\"SelezionaDelete\" value=\"Lista Pizze\"/>
                  </div>
                  </fieldset>
                </form>",
                "<modificapizza/>" =>
                "<form id=\"upd-pizza-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                  <fieldset>
                    <messaggioPizzaModificata />
                    <p>Seleziona pizza da modificare: </p>
                    <div class=\"post\">
                      <input type=\"submit\" id=\"SelezionaModifica\" class=\"text-button\" name=\"SelezionaModifica\" value=\"Seleziona pizza!\"/>
                    </div>
                  </fieldset>
                </form>",


                "<disabilitaitem/>" =>
                "<form id=\"disab-elem-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                  <p>Seleziona elemento da cambiare: </p>
                  <messaggioElementoDisabilitato />
                  <div class=\"post\">
                    <input type=\"submit\" class=\"text-button\" name=\"Disabilita\" value=\"Cambia disponibilità!\"/>
                  </div>
                </fieldset>
              </form>",
              "<disabilitaingred/>" =>
              "<form id=\"disab-item-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
              <fieldset>
                <p>Seleziona elemento da cambiare: </p>
                <messaggioElementoDisabilitatoIng />
                <input type=\"hidden\"  class=\"text-button\" name=\"DisabilitaIngred\" value=\"Cambia disponibilità!\"/>
                <div class=\"post\">
                  <input type=\"submit\" class=\"text-button\" name=\"Disabilita\" value=\"Cambia disponibilità!\"/>
                </div>
              </fieldset>
            </form>",


            "<aggiungibevanda/>" =>
                "<form id=\"add-bevanda-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                <messaggioBevandaAggiunta />
                <label for=\"aggNomebevanda\" lang=\"ITA\">Nome Bevanda:</label>
                <input type=\"text\" name=\"aggNomebevanda\" id=\"aggNomebevanda\" maxlength=\"30\" placeholder=\"Inserisci nome bevanda:\" required/>
                <label for=\"aggCategoriabevanda\" lang=\"ITA\">Categoria:</label>
                <input type=\"text\" name=\"aggCategoriabevanda\" id=\"aggCategoriabevanda\" maxlength=\"30\" placeholder=\"Inserisci catergoria:\" required/>
                <label for=\"aggGradi\" lang=\"ITA\">Gradi Alcolici:</label>
                <input type=\"number\" name=\"aggGradi\" id=\"aggGradi\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il grado alcolico:\" required/>
                <label for=\"aggPrezzoBev\" lang=\"ITA\">Prezzo:</label>
                <input type=\"number\" name=\"aggPrezzoBev\" id=\"aggPrezzoBev\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\" required/>
                <label for=\"aggDescbev\" lang=\"ITA\">Descrizione: </label>
                <input type=\"text\" name=\"aggDescbev\" id=\"aggDescbev\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                <div class=\"post\">
                <input type=\"submit\" id=\"AggiungiBev\" class=\"text-button\" name=\"AggiungiBev\" value=\"Aggiungi\"/>
                </div>
                </fieldset>
                </form>",
                "<eliminabevanda/>" => 
                "<form id=\"delete-bevanda-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                <fieldset>
                <messaggioBevandaEliminata />
                <p>Seleziona bevanda da eliminare: </p>
                  <input type=\"text\" name=\"delBev\" id=\"delBev\" placeholder=\"Seleziona una bevanda per eliminarla:\" readonly/>
                  <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaDeleteBev\" class=\"text-button\" name=\"SelezionaDeleteBev\" value=\"Lista Bevande\"/>
                  </div>
                </fieldset>
              </form>",
              "<modificabevanda/>" =>
              "<form id=\"upd-bevanda-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
                <fieldset>
                  <messaggioBevandaModificata />
                  <p>Seleziona bevanda da modificare: </p>
                  <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaModificaBev\" class=\"text-button\" name=\"SelezionaModificaBev\" value=\"Modifica\"/>
                  </div>
                </fieldset>
              </form>",


              "<aggiungidolce/>" =>
              "<form id=\"add-dolce-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
                    <fieldset>
                    <messaggioDolceAggiunta />
                    <label for=\"aggNomedolce\" lang=\"ITA\">Nome Dolce:</label>
                    <input type=\"text\" name=\"aggNomedolce\" id=\"aggNomedolce\" maxlength=\"30\" placeholder=\"Inserisci nome dolce:\" required/>
                    <label for=\"aggPrezzoDolce\" lang=\"ITA\">Prezzo:</label>
                    <input type=\"number\" name=\"aggPrezzoDolce\" id=\"aggPrezzoDolce\" min=\"0.0\" step=\"0.1\" placeholder=\"Inserisci il prezzo:\" required/>
                    <label for=\"aggDescdolce\" lang=\"ITA\">Descrizione: </label>
                    <input type=\"text\" name=\"aggDescdolce\" id=\"aggDescdolce\" maxlenght=\"500\" placeholder=\"Inserisci la descrizione:\"/>
                    <div class=\"post\">
                        <input type=\"submit\" id=\"AggiungiDolce\" class=\"text-button\" name=\"AggiungiDolce\" value=\"Aggiungi\"/>
                    </div>
                    </fieldset>
                  </form>",
            "<eliminadolce/>" =>
                "<form id=\"delete-dolci-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
                <fieldset>
                <messaggioDolceEliminata />
                <p>Seleziona dolce da eliminare: </p>
                <input type=\"text\" name=\"delDolce\" id=\"delDolce\" placeholder=\"Seleziona un dolce per eliminarlo:\"  readonly/>
                <div class=\"post\">
                    <input type=\"submit\" id=\"SelezionaDeleteDolce\" class=\"text-button\" name=\"SelezionaDeleteDolce\" value=\"Elimina\"/>
                </div>
                </fieldset>
            </form>",
            "<modificadolce/>" => 
            "<form id=\"upd-dolci-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
            <fieldset>
              <messaggioDolceModificata />
                <p>Seleziona dolce da modificare: </p>
              <div class=\"post\">
                <input type=\"submit\" id=\"SelezionaModificaDolce\" class=\"text-button\" name=\"SelezionaModificaDolce\" value=\"Modifica\"/>
              </div>
            </fieldset>
          </form>",


          "<aggiungiingrediente/>" => 
          "<form id=\"add-ingrediente-form\"  action=\"../PHP/adminEventHandler.php\" name=\"formsub\" method=\"post\">
          <fieldset>
          <messaggioIngredienteAggiunta />
          <label for=\"aggNomeingred\" lang=\"ITA\">Nome Ingrediente:</label>
          <input type=\"text\" name=\"aggNomeingred\" id=\"aggNomeingred\" maxlength=\"30\" placeholder=\"Inserisci nome ingrediente:\" required/>
          <label for=\"aggCategoriaIngrediente\" lang=\"ITA\">Categoria Allergene:</label>
          <input type=\"number\" name=\"aggCategoriaIngrediente\" id=\"aggCategoriaIngrediente\" min=\"0\" step=\"1\" placeholder=\"Inserisci la categoria:\" required/>
          <div class=\"post\">
            <input type=\"submit\"  class=\"text-button\" name=\"AggiungiIngre\" value=\"Aggiungi\"/>
          </div>
          </fieldset>
        </form>",
        "<eliminaingrediente/>" =>
        "<form id=\"delete-ingrediente-form\"  action=\"../PHP/adminListShow.php\" method=\"post\">
        <fieldset>
        <messaggioIngredienteEliminata />
        <label for=\"delIngrediente\" lang=\"ITA\">Seleziona ingrediente da eliminare: </label>
        <input type=\"text\" name=\"delIngrediente\" id=\"delIngrediente\" placeholder=\"Seleziona un ingrediente per eliminarlo:\"  readonly/>
        <input type=\"text\" name=\"oldIdIngr\" id=\"oldIdIngr\" class=\"invIdIng\" readonly/>
        <div class=\"post\">
          <input type=\"submit\" id=\"SelezionaDeleteIngrediente\" class=\"text-button\" name=\"SelezionaDeleteIngrediente\" value=\"Elimina\"/>
        </div>
        </fieldset>
      </form>",
      "<modificaingrediente/>" =>
      "<form id=\"upd-ingrediente-form\"  action=\"../PHP/adminListShow.php\" name=\"formsub\" method=\"post\">
      <fieldset>
        <messaggioIngredienteModificata />
        <p>Seleziona ingrediente da modificare: </p>
        <div class=\"post\">
          <input type=\"submit\" id=\"SelezionaModificaIngrediente\" class=\"text-button\" name=\"SelezionaModificaIngrediente\" value=\"Modifica\"/>
        </div>
      </fieldset>
    </form>");
    return $add;
}
?>