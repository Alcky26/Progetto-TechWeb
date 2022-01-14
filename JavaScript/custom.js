$(document).ready(function() {
  var button = $("#login-logout");
  $.get(
    "../PHP/checkLogin.php",
    {},
    function(response) {
      button.html(response);
    }
  );
});

$(document).ready(function() {
    $(".show-pwd").prop("checked", false);
});

$(document).ready(function(){
    $("input + .show-pwd").click(function() {
        var input = $(this).prev("input");
        var type = input.prop("type") === "password" ? "text" : "password";
        input.prop("type", type);
    });
});

function animateAlert(alertBox, time) {
    alertBox.css({
      "padding": "0 1rem",
      "font-size": 0,
      "display": "block"
    });
    alertBox.animate({
        "padding-top": "1rem",
        "padding-bottom": "1rem",
        "font-size": "1rem"
    }, time/4, function() {
        setTimeout(function() {
            alertBox.animate({
              "padding-top": "0",
              "padding-bottom": "0",
              "font-size": "0"
            }, time/4)
        }, time/2);
    });
}
