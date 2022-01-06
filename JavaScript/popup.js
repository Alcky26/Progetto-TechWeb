$(document).ready(function(){
  $(".open-popup").click(function(){
    $(".popup").css("display", "block");
  });
});

$(document).ready(function(){
  $(".popup .cancel").click(function(){
    $(".popup").css("display", "none");
  });
});

$(document).ready(function(){
    $(".popup").submit(function(){
        $(".popup").css("display", "none");
    });
});
