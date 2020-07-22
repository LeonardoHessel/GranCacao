var url = "http://grancacao/server/webservice.php"

function CheckUser() {
    let user = true
    $.ajax({
        url: url,
        method: 'post',
        data: {
            "req": "check_user"
        },
        async: false,
        success: function (resp) {
            let json = $.parseJSON(resp)
            user = json.user
        },
        timeout: 3000,
        error: function (resp) {
            console.log(resp)
        }
    })
    return user
}

function Logout() {
    $.post(url, { req: "logout_user" }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.logout) {
            window.location.href = "index.html"
        }
    })
}



$(document).ready(function () {
    let user = CheckUser()
    if (user) {
        $("#login").hide()
        $("#logout").show()
    } else {
        $("#login").show()
        $("#logout").hide()
    }

})

































