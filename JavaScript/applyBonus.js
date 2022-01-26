function applicaBonus(elem)
{
  if(elem.value != 0){
    cancellaBonus();
    var prezzo = parseFloat(document.getElementById('senzaBonus').textContent) - elem.value;
    if(prezzo < 0) prezzo = 0;
    document.getElementById('senzaBonus').setAttribute("class","canceled");
    var newPrice = document.createElement('span');
    newPrice.id = "conBonus";
    newPrice.textContent = prezzo + "€";
    document.getElementById('totaleFinale').appendChild(newPrice);

    var codice = elem.parentNode.querySelector('p').textContent;
    document.getElementById('codiceBonus').value = parseInt(codice);

  }
}

function cancellaBonus()
{
  document.getElementById('codiceBonus').value = 0;
  if(document.getElementById('conBonus')) document.getElementById('conBonus').remove();
  document.getElementById('senzaBonus').classList.remove("canceled");
}
