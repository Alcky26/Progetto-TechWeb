var info = {
  "email": "",
  "username": "",
  "pwd": "",
  "birthday": ""
};
var code;

$(document).ready(function() {
    info["email"] = $("#email").val();
    info["username"] = $("#username").val();
    info["pwd"] = $("#password").val();
    info["birthday"] = $("#birthday").val();
    $("#set-info").text("Modifica");
    $("#email").prop("disabled", true);
    $("#username").prop("disabled", true);
    $("#pwd").prop("disabled", true);
    $("#birthday").prop("disabled", true);
    $("#set-info").prop("disabled", false);
    $("#save-info").prop("disabled", true);
    $(".show-code").next(".qr-code").css("display", "none");
    $("#scadenza, #valore, #periodo, #persone, #data-acquisto, #spesa").prop("disabled", false);
});

$(document).ready(function(){
    $("#set-info").click(function() {
        if ($("#set-info").text() === "Modifica") {
              $("#set-info").text("Annulla");
              $("#set-info").css("background-color", "red");
              $("#email, #username, #pwd, #birthday, #save-info").each(function(index) {
                  $(this).prop("disabled", false);
              });
              $("#save-info").prop("disabled", false);
        } else {
              $("#set-info").text("Modifica");
              $("#set-info").css("background-color", "");
              $("#email, #username, #pwd, #birthday").each(function(index) {
                  $(this).prop("disabled", true);
              });
              $("#save-info").prop("disabled", true);
        }
    });
});

$(document).ready(function() {
    var bonus = $("#bonus .subcontainer:nth-child(2)");
    $("#scadenza, #valore").change(function() {
        $.get(
            "../PHP/bonus.php",
            {
                scadenza: $("#scadenza").val(),
                persone: $("#valore").val()
            },
            function(response) {
                bonus.html(response);
            }
        );
    });
});

$(document).ready(function() {
    var prenotazioni = $("#prenotazioni .subcontainer:nth-child(2)");
    $("#periodo, #persone").change(function() {
        $.get(
            "../PHP/prenotazioni.php",
            {
                periodo: $("#periodo").val(),
                persone: $("#persone").val()
            },
            function(response) {
                prenotazioni.html(response);
                $(".show-code").closest(".list-item").find(".qr-code").css("display", "none");
                $(".show-code").click(function(event) {
                  showQRCode(event);
                });
            }
        );
    });
});

$(document).ready(function() {
  $(".show-code").click(function(event) {
    showQRCode(event);
  });
});

function showQRCode(event) {
  code = $(event.target).closest(".list-item").find(".qr-code");
  code.css("display", code.css("display") === "none" ? "block" : "none");
  $(event.target).text(code.css("display") === "none" ? "Mostra codice QR" : "Nascondi codice QR");
}

$(document).ready(function() {
    var acquisti = $("#acquisti .subcontainer:nth-child(2)");
    $("#data-acquisto, #spesa").change(function() {
        $.get(
            "../PHP/acquisti.php",
            {
                data: $("#data-acquisto").val(),
                spesa: $("#spesa").val()
            },
            function(response) {
                acquisti.html(response);
            }
        );
    });
});
