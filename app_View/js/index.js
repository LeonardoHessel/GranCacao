var url = "http://grancacao/server/webservice.php"

function CheckCookie() {
    $.post(url, { req: 'check_user' }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.user) {
            $("#Perfil").html("")
            $("#Perfil").append(
                `<a class="dropdown-item" href="#">Editar Perfil</a>
				<a class="dropdown-item" href="#">Pedidos</a>
				<div class="dropdown-divider"></div>
				<a id="btnLogout" class="dropdown-item" href="javascript:LogoutUser()">Logout</a>`
            )
        }
    })
}

function LogoutUser() {
    $.post(url, { req: 'logout_user' }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json) {
            console.log(json)
            window.location.href = "http://grancacao/app_View"
        }
    })
}



$(document).ready(function () {

    CheckCookie()


})
