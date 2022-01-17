$(document).ready(function(){
  $("#classicheFlip").click(function(){
    $("#classiche").slideToggle("fast");
  });

  $("#specialiFlip").click(function(){
    $("#speciali").slideToggle("fast");
  });

  $("#biancheFlip").click(function(){
    $("#bianche").slideToggle("fast");
  });

  $("#calzoniFlip").click(function(){
    $("#calzoni").slideToggle("fast");
  });

  $("#bevandeFlip").click(function(){
    $("#bevande").slideToggle("fast");
  });

  $("#viniFlip").click(function(){
    $("#vini").slideToggle("fast");
  });

  $("#birreFlip").click(function(){
    $("#birre").slideToggle("fast");
  });

  $("#dolciFlip").click(function(){
    $("#dolci").slideToggle("fast");
  });

  $("input[name=deliveryTakeaway]").on('change', function(){
      $("#scegliOrario")[this.value=='TakeAway'?'slideDown':'slideUp']();
  });

  $("input[name=deliveryTakeaway]").on('change', function(){
      $("#inserisciIndirizzo")[this.value=='Delivery'?'slideDown':'slideUp']();
  });

  $('#submit').click(function(){
   if(!$('.PnonVisibile').length) {
     alert("Attenzione: sceglie almeno un prodotto");
     return false;
   }
   if(!$("input[name='DT']:checked").val()){
      alert("Attenzione: sceglie il ritiro a mano o consegna a domicilio");
      return false;
   } else {
     if ($("input[id='TakeAway']:checked").val() && $('#indOra').val() == ''){
       alert("Attenzione: sceglie l'ora di ritiro");
       return false;
     } else {
       if ($("input[id='Delivery']:checked").val() && $('#indOra').val() == ''){
         alert("Attenzione: inserire l'indirizzo di consegna");
         return false;
       } else {
         if(parseFloat($("#inpFinalTotal").value) < 15) {
           alert("Si accettano solo ordini maggiori di 15€ per consegna a domicilio");
           return false;
       }
     }
   }
   }
  });
});
