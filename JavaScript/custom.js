$(document).ready(function() {
  var button = $("#login-logout");
  $.get(
    "../PHP/checkLogin.php",
    {},
    function(response) {
      button.html(response);
      $(".dropbtn").attr("aria-haspopup", "true");
      $(".dropbtn").attr("aria-expanded", "false");
      $(".dropbtn").click(function(event) {
        $(event.target).parent(".dropdown").toggleClass("focus-within");
        $(event.target).attr("aria-expanded", ($(event.target).attr("aria-expanded") === "false" ? "true" : "false"));
      });
    }
  );
});

$(document).ready(function() {
  $(".confirm").attr("type", "button");
  $(".confirm").click(function(event) {
    if (confirm("Sei sicuro?"))
      $(event.target).parent("form").submit();
  });
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
