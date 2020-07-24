function LoginUser() {
    let email = $("#email").val()
    let senha = $("#senha").val()
    $.post(url, { req: "login_user", email: email, pass: senha }).done(function (resp) {
        let json = $.parseJSON(resp)
        console.log(json)
        if (json.user) {
            window.location.href = "index.html"
        }
    })
}


$(document).ready(function () {
    if (CheckUser()) {
        window.location.href = "index.html"
    }

    $("#btnAcessar").click(function () {
        
    })


    $(".toggle-password").click(function () {
        $(this).toggleClass("fas fa-eye-slash")
        var input = $($(this).attr("toggle"))
        if (input.attr("type") == "password") {
            input.attr("type", "text")
        } else {
            input.attr("type", "password")
        }
    })
})

































