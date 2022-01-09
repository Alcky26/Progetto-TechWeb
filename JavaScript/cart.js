
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
  var total = document.getElementById("total");
  total.textContent = subtotal+"€";
}



/* aggiorna quantita */
function updateQuantity(quantityInput)
{
  /* calcola prezzo inline */
  var productRow = quantityInput.parentNode.parentNode;
  var price = parseFloat(productRow.querySelector(".productPrice").textContent);
  var quantity = parseFloat(quantityInput.value);
  var linePrice = price * quantity;
  linePrice = linePrice.toFixed(2);
  /* Update line price display and recalc cart totals */
  var productLinePr = productRow.querySelector(".productLinePrice");
  productLinePr.innerHTML = linePrice+"€";
      recalculateCart();
}


/* togli elemtto */
function removeItem(removeButton)
{
  var productRow = removeButton.parentNode.parentNode;
    productRow.remove();
    recalculateCart();
}

/* aggiungi elemento */
function addItem(itemInput)
{
	var productRow = itemInput.parentNode;
	var price = productRow.querySelector(".itemPrice").textContent;
	var item = productRow.querySelector(".itemName").textContent;

	var prodotti = document.getElementsByClassName("product");
	var presente = false;

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
		removeBtn.className = "remove-product";
		removeBtn.onclick = function() {removeItem(this)};
		var text = document.createTextNode("Remove");
		removeBtn.appendChild(text);
		productRemoval.append(removeBtn);

		var productLinePrice = document.createElement("div");
		productLinePrice.className = "productLinePrice";
		productLinePrice.textContent = price;

		product.appendChild(productName);
		product.appendChild(productPrice);
		product.appendChild(productQuantity);
		product.appendChild(productRemoval);
		product.appendChild(productLinePrice);

		document.getElementById("riepilogo").appendChild(product);
		recalculateCart();
	}
}
