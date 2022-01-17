
window.onload = function() {
  document.getElementById("inpFinalTotal").value = "0€";
};

/* ricalcola prezzo */
function recalculateCart()
{
  var subtotal = 0;

  /* Sum up row totals */
  let prodotti = document.querySelectorAll(".product");
  prodotti.forEach(calcFunction);

  function calcFunction(prodotto) {
	subtotal += parseFloat(prodotto.querySelector(".productLinePrice").textContent);
	}

  document.getElementById("inpFinalTotal").value = subtotal + "€";
}



/* aggiorna quantita */
function updateQuantity(quantityInput)
{
  /* calcola prezzo inline */
  var productRow = quantityInput.parentNode.parentNode;
  var productName = productRow.querySelector(".productName").textContent;
  var price = parseFloat(productRow.querySelector(".productPrice").textContent);
  var quantity = parseFloat(quantityInput.value);
  var linePrice = price * quantity;
  linePrice = linePrice.toFixed(2);
  /* Update line price display and recalc cart totals */
  var productLinePr = productRow.querySelector(".productLinePrice");
  productLinePr.innerHTML = linePrice+"€";

  var fieldset = document.getElementById(productName);
  fieldset.querySelector(".quantitaInput").setAttribute("value", quantity);
  fieldset.querySelector(".totaleInp").setAttribute("value", linePrice);
  recalculateCart();
}


/* togli elemento */
function removeItem(removeButton)
{
  var productRow = removeButton.parentNode.parentNode;
  var productName = productRow.querySelector(".productName").textContent;
  var fieldset = document.getElementById(productName);
  fieldset.remove();
  productRow.remove();
  recalculateCart();
}

/* aggiungi elemento */
function addItem(itemInput)
{
  /* leggi Informazioni del prodotto */
	var productRow = itemInput.parentNode;
	var price = productRow.querySelector(".itemPrice").textContent;
	var item = productRow.querySelector(".itemName").textContent;

	var prodotti = document.getElementsByClassName("product");
	var presente = false;
  /* controlla se il prodotto e' gia presente nel carrello/riepilogo, se presente allora incrementa la quantita */
  if (prodotti){
  	for(let i = 0; i < prodotti.length; i++){
  		if(prodotti[i].querySelector(".productName").textContent == item){
  			var inp = prodotti[i].querySelector("#qtt");
        inp.stepUp(1);
  			updateQuantity(inp);
  			presente = true;
  		}
  	}
  }

	if(!presente){
    /* aggiungi prodotto al carrrello/riepilogo */
		var product = document.createElement("div");
		product.className="product";

		var productName = document.createElement("div");
		productName.className = "productName";
		productName.textContent = item;

		var productPrice = document.createElement("div");
		productPrice.className = "productPrice";
		productPrice.textContent = price;

		var productQuantity = document.createElement("div");
		productQuantity.className = "productQuantity";
		var quantity = document.createElement("input");
		quantity.type = "number";
		quantity.setAttribute("value", "1");
		quantity.min = "1";
    quantity.id = "qtt";
		quantity.onchange = function() {updateQuantity(this)};
		productQuantity.appendChild(quantity);

		var productRemoval = document.createElement("div");
		productRemoval.className = "productRemoval";
		var removeBtn = document.createElement("button");
		removeBtn.className = "remove-product button";
		removeBtn.onclick = function() {removeItem(this)};
		var text = document.createTextNode("Remove");
		removeBtn.appendChild(text);
		productRemoval.append(removeBtn);

		var productLinePrice = document.createElement("div");
		productLinePrice.className = "productLinePrice";
		productLinePrice.textContent = price;

    var per = document.createElement("div");
    per.textContent = "  X  ";
    per.className = "segno";

		product.appendChild(productName);
		product.appendChild(productPrice);
    product.appendChild(per);
		product.appendChild(productQuantity);
		product.appendChild(productRemoval);
		product.appendChild(productLinePrice);

		document.getElementById("riepilogo").appendChild(product);

    /* creazione form nascosto con Informazioni del prodotto */
    var fieldset = document.createElement("fieldset");
    fieldset.id = item;
    fieldset.className = "PnonVisibile";
    fieldset.setAttribute("aria-hidden", true);

    var inpName = document.createElement("input");
    inpName.type = "text";
    inpName.name = "nomePr[]";
    inpName.setAttribute("value", item);

    var inpQuantity = document.createElement("input");
    inpQuantity.type = "number";
    inpQuantity.name = "quantitaPr[]";
    inpQuantity.className = "quantitaInput";
    inpQuantity.setAttribute("value", "1");

    var inpTotal = document.createElement("input");
    inpTotal.type = "text";
    inpTotal.name = "totalPr[]";
    inpTotal.className = "totaleInp";
    inpTotal.setAttribute("value",price);

    fieldset.appendChild(inpName);
    fieldset.appendChild(inpQuantity);
    fieldset.appendChild(inpTotal);

    document.getElementById("contenutiNonVisibili").appendChild(fieldset);

		recalculateCart();
	}
}

function checkDistance(elem) {
    var x = elem.value;
    var array = x.split(",");
    var queryString = "";
    array.forEach(i => {
        queryString += (i + ",");
    });
    queryString += "Italy";
    queryString += "&format=json&limit=1&polygon=0&addressdetails=0";
    var geocodingAPI = "http://nominatim.openstreetmap.org/search?q=" + queryString;
    $.getJSON(geocodingAPI, function(json) {
        if ($.isEmptyObject(json)) {
            if (elem.classList.contains("success"))
                elem.classList.remove("success");
  			    if (!elem.classList.contains("danger"))
                elem.classList.add("danger");
            elem.value = "Nessun risultato! Controlla i dati che hai inserito.";
  		  } else {
            var lati_pizzeria = 45.406972;
            var longi_pizzeria = 11.885583;
            var lati = json["lat"];
            var longi = json["lon"];

            var earthRadiusKm = 6371;

            var lat = ((lati_pizzeria - lati) * Math.PI) / 180;
            var lon = ((longi_pizzeria - longi) * Math.PI) / 180;

            var lati_pizzeria = (lati_pizzeria * Math.PI) / 180;
            lati = (lati * Math.PI) / 180;

            var a = Math.sin(lat/2) * Math.sin(lat/2) + Math.sin(lon/2) * Math.sin(lon/2) * Math.cos(lati_pizzeria) * Math.cos(lati);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = earthRadiusKm * c;

            if (distance > 30) {
                if (elem.classList.contains("success"))
                    elem.classList.remove("success");
                if (!elem.classList.contains("danger"))
                    elem.classList.add("danger");
                elem.value = "Troppo distante.";
            } else {
                if (elem.classList.contains("danger"))
                    elem.classList.remove("danger");
                if (!elem.classList.contains("success"))
                    elem.classList.add("success");
                elem.value = "Va bene!";
            }
        }
    });

}


function deliveryTakeaway(elem)
{
  var x =elem.value;
  document.getElementById(x).checked = true;
}

function indOra(elem)
{
  var x = elem.value;
  document.getElementById("indOra").value = x;
}
