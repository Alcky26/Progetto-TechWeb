var email = $("#email").val();
var username = $("#username").val();
var pwd = $("#password").val();
var birthday = $("#birthday").val();

$(document).ready(function(){
    $("#show-pwd").prop('checked', false);
    $("#set-info").text("Modifica");
    $('#email').prop('disabled', true);
    $('#pwd').prop('disabled', true);
    $('#info-form input[type="submit"]').prop('disabled', true);
    $("#bonus-div").css("display", "none");
    $("#prenotazioni-div").css("display", "none");
    $("#acquisti-div").css("display", "none");
});

$(document).ready(function(){
    $("#info").click(function(){
        $("#user-menu").find(".checked").removeClass("checked");
        $("#info").addClass("checked");
        $("#info-div").css("display", "block");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function(){
    $("#bonus").click(function(){
        $("#user-menu").find(".checked").removeClass("checked");
        $("#bonus").addClass("checked");
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "block");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function(){
    $("#prenotazioni").click(function(){
        $("#user-menu").find(".checked").removeClass("checked");
        $("#prenotazioni").addClass("checked");
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "block");
        $("#acquisti-div").css("display", "none");
    });
});

$(document).ready(function(){
    $("#acquisti").click(function(){
        $("#user-menu").find(".checked").removeClass("checked");
        $("#acquisti").addClass("checked");
        $("#info-div").css("display", "none");
        $("#bonus-div").css("display", "none");
        $("#prenotazioni-div").css("display", "none");
        $("#acquisti-div").css("display", "block");
    });
});

$(document).ready(function(){
    $("#set-info").click(function(){
        if ($("#set-info").text() === "Modifica") {
              $("#set-info").text("Annulla");
              $("#set-info").css("background-color", "red");
              $("#email").prop("disabled", false);
              $("#username").prop("disabled", false);
              $("#pwd").prop("disabled", false);
              $("#birthday").prop("disabled", false);
              $("#info-form input[type='submit']").prop("disabled", false);
        } else {
              $("#set-info").text("Modifica");
              $("#set-info").css("background-color", "#80471C");
              $("#email").prop("value", email);
              $('#email').prop("disabled", true);
              $("#username").prop("value", username);
              $("#username").prop("disabled", true);
              $("#pwd").prop("value", pwd);
              $("#pwd").prop("disabled", true);
              $("#birthday").prop("value", birthday);
              $("#birthday").prop("disabled", true);
              $("#info-form input[type='submit']").prop("disabled", true);
        }
    });
});

$(document).ready(function(){
    $("#show-pwd").click(function(){
        var type = $("#pwd").prop("type") === "password" ? "text" : "password";
        $("#pwd").prop("type", type);
    });
});

$(document).ready(function(){
    $('#info-form').submit(function(event){
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
            email = $("#email").val();
            username = $("#username").val();
            pwd = $("#password").val();
            birthday = $("#birthday").val();
            var result = response;
            $(".alert-box").html(function() {return result.success ? "<p>Modifiche effettuate.</p>" : "<p>Attenzione: non puoi modificare il giorno del compleanno più di una volta. Modifiche annullate.</p>"});
            if (result.success) {
                $(".alert-box").removeClass("danger");
                $(".alert-box").addClass("success");
            } else {
                $(".alert-box").removeClass("success");
                $(".alert-box").addClass("danger");
            }
        });
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
