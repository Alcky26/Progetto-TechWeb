$(document).ready(function(){
   
    $("#slideFlip").click(function(){
      $("#slidePizza").slideToggle("fast");
    });

    $("#aggiungiFlip").click(function(){
        $("#aggiungiPizza").slideToggle("fast");
      });

    $("#eliminaFlip").click(function(){
        $("#eliminaPizza").slideToggle("fast");
      });

    $("#modificaFlip").click(function(){
        $("#modificaPizza").slideToggle("fast");
      });


    $("#delPiz").on('keydown paste focus mousedown', function(e){
    if(e.keyCode != 9) 
        e.preventDefault();
    });

    $("#aggIngre").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) 
            e.preventDefault();
    });

    $("#aggIngreId").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) 
            e.preventDefault();
    });

    $("#aggIngreUpd").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) 
            e.preventDefault();
    });

    $("#oldName").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) 
            e.preventDefault();
    });
  });

function addItem(itemInput)
{
    var productRow = itemInput.parentNode;
    var id = productRow.querySelector(".idIng").textContent;
    var nome = productRow.querySelector(".itemName").textContent;
    

    var ingred = document.getElementById('aggIngre').value;
    const myArray = ingred.split("-");
    var diverso = true;
    if(ingred.length > 0){
            for(let i = 0; i < myArray.length && diverso; i++){
            if(myArray[i] == nome.text){
                diverso = false;
            }
        }
        if(diverso) {
            document.getElementById('aggIngre').value = document.getElementById('aggIngre').value + "-" + nome;
            document.getElementById('aggIngreId').value = document.getElementById('aggIngreId').value + "-" + id;
        }
    } else {
        document.getElementById('aggIngre').value = document.getElementById('aggIngre').value + nome;
        document.getElementById('aggIngreId').value = document.getElementById('aggIngreId').value + id;
    }
	
}

function removeItem()
{
    var ingred = document.getElementById('aggIngre').value;
    var ingredid = document.getElementById('aggIngreId').value;
    const myArray = ingred.split("-"), myArrayId = ingredid.split("-");

    if(myArray.length > 0 && myArrayId.length > 0 && myArray.length == myArrayId.length && ingred.length > 0 && ingredid.length > 0){
        myArray.pop();
        myArrayId.pop();
        if(myArray.length > 0 && myArrayId.length > 0 && myArray.length == myArrayId.length){
            document.getElementById('aggIngre').value = myArray.shift();
            document.getElementById('aggIngreId').value = myArrayId.shift();
            var size=myArray.length;
            for(let i = 0; i < size; i++){
                document.getElementById('aggIngre').value = document.getElementById('aggIngre').value + "-" + myArray.shift();
                document.getElementById('aggIngreId').value = document.getElementById('aggIngreId').value + "-" + myArrayId.shift();
            }
        }
        else
        {
            document.getElementById('aggIngre').value = "";
            document.getElementById('aggIngreId').value = "";
        }
    }
}

function addItemToDel(itemInput)
{
	var productRow = itemInput.parentNode;
    document.getElementById('delPiz').value = productRow.querySelector(".itemNamePizDel").textContent;
}

function removeItemDel()
{
    if(document.getElementById('delPiz').value.length > 0){
            document.getElementById('delPiz').value = "";
    }
}

function removeItemUpd()
{
    var ingred = document.getElementById('aggIngreUpd').value;
    var ingredid = document.getElementById('aggIngreIdUpd').value;
    const myArray = ingred.split("-"), myArrayId = ingredid.split("-");
    console.log(ingred);
    console.log(ingredid);
    console.log(myArray);
    console.log(myArrayId);
    if(myArray.length > 0 && myArrayId.length > 0 && myArray.length == myArrayId.length && ingred.length > 0 && ingredid.length > 0){
        myArray.pop();
        myArrayId.pop();
        if(myArray.length > 0 && myArrayId.length > 0 && myArray.length == myArrayId.length){
            document.getElementById('aggIngreUpd').value = myArray.shift();
            document.getElementById('aggIngreIdUpd').value = myArrayId.shift();
            var size=myArray.length;
            for(let i = 0; i < size; i++){
                document.getElementById('aggIngreUpd').value = document.getElementById('aggIngreUpd').value + "-" + myArray.shift();
                document.getElementById('aggIngreIdUpd').value = document.getElementById('aggIngreIdUpd').value + "-" + myArrayId.shift();
            }
        }
        else
        {
            document.getElementById('aggIngreUpd').value = "";
            document.getElementById('aggIngreIdUpd').value = "";
        }
    }
}
function addItemUpd(itemInput)
{
    var productRow = itemInput.parentNode;
    var id = productRow.querySelector(".idIngUpd").textContent;
    var nome = productRow.querySelector(".itemNameUpd").textContent;

    var ingred = document.getElementById('aggIngreUpd').value;
    const myArray = ingred.split("-");
    var diverso = true;
    if(ingred.length > 0){
        for(let i = 0; i < myArray.length && diverso; i++){
            if(myArray[i] == nome.text){
                diverso = false;
            }
        }
        if(diverso) {
            document.getElementById('aggIngreUpd').value = document.getElementById('aggIngreUpd').value + "-" + nome;
            document.getElementById('aggIngreIdUpd').value = document.getElementById('aggIngreIdUpd').value + "-" + id;
        }
    } else {
        document.getElementById('aggIngreUpd').value = document.getElementById('aggIngreUpd').value + nome;
        document.getElementById('aggIngreIdUpd').value = document.getElementById('aggIngreIdUpd').value + id;
    }
    
}