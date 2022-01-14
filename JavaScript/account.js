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
    $("#pwd").prop("disabled", true);
    $("#info-form .alert-box").css("display", "none");
    $("#info-form input[type='submit']").prop("disabled", true);
    $("#bonus-div").css("display", "none");
    $("#prenotazioni-div").css("display", "none");
    $("#acquisti-div").css("display", "none");
    $(".show-code").closest(".list-item").find(".qr-code").css("display", "none");
});

$(document).ready(function() {
    $("#user-menu > li").click(function(event) {
        $("#user-menu").children(".checked").removeClass("checked");
        $(event.target).addClass("checked");
    });
});

$(document).ready(function() {
    $("#info").click(function() {
        $("#info-div").css("display", "block");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function() {
    $("#bonus").click(function() {
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "block");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function() {
    $("#prenotazioni").click(function() {
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "block");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function() {
    $("#acquisti").click(function() {
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "block");
    });
});

$(document).ready(function(){
    $("#set-info").click(function() {
        if ($("#set-info").text() === "Modifica") {
              $("#set-info").text("Annulla");
              $("#set-info").css("background-color", "red");
              $("#email, #username, #pwd, #birthday, #info-form input[type='submit']").each(function(index) {
                  $(this).prop("disabled", false);
              });
        } else {
              $("#set-info").text("Modifica");
              $("#set-info").css("background-color", "#80471C");
              $("#email, #username, #pwd, #birthday").each(function(index) {
                  $(this).prop("value", info[index]);
                  $(this).prop("disabled", true);
              });
              $("#info-form input[type='submit']").prop("disabled", true);
        }
    });
});

$(document).ready(function(){
    $('#info-form').submit(function(event) {
        event.preventDefault();
        $.post(
            "../PHP/setUserInfo.php",
            {
                email: $("#email").val(),
                username: $("#username").val(),
                pwd: $("#pwd").val(),
                birthday: $("#birthday").val()
            },
            function(response) {
                info["email"] = $("#email").val();
                info["username"] = $("#username").val();
                info["pwd"] = $("#password").val();
                info["birthday"] = $("#birthday").val();
                var alert = $("#info-form .alert-box");
                alert.html(response.success ? "Modifiche effettuate." : "<strong>Attenzione:</strong> non puoi modificare il giorno del compleanno più di una volta. Modifiche non salvate.");
                alert.removeClass(response.success ? "danger" : "success");
                alert.addClass(response.success ? "success" : "danger");
                animateAlert(alert, 3000);
                setTimeout(function() {alert.css("display", "none");}, 3000);
            }
        );
    });
});

$(document).ready(function(){
    $("#delete-account").submit(function(event){
        event.preventDefault();
        $.post("../PHP/deleteAccount.php").done(function(){
                window.location.href = "../HTML/index.html";
            }).fail(function(xhr, status, error){
                console.log("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText);
            }
        );
    });
});

function showCode(event) {
    code = $(event.target).closest(".list-item").find(".qr-code");
    code.css("display", code.css("display") === "none" ? "block" : "none");
    $(event.target).text(code.css("display") === "none" ? "Mostra codice QR" : "Nascondi codice QR");
}

$(document).ready(function() {
    var bonus = $("#bonus-div > :nth-child(2)");
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
    var prenotazioni = $("#prenotazioni-div > :nth-child(2)");
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
                $(".show-code").click(function(event) {showCode(event)});
            }
        );
    });
});

$(document).ready(function() {
    var acquisti = $("#acquisti-div > :nth-child(2)");
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

$(document).ready(function(){
    $(".show-code").click(function(event) {showCode(event)});
});
