var url = 'http://grancacao/server/webservice.php'
var methodType = 'post'

function verifCookie() {
    $.post(url, { req: 'check_user' }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.user) {
            window.location.href = "http://grancacao/app_View"
        }
    })
}

function cadastrarUsuario(email, senha) {
    $.post(url, { req: 'reg_user', email: email, senha: senha }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.record) {
            alert("Cadastro realizado com sucesso!\n Faça login para acessar!")
            window.location.href = "http://grancacao/app_Login/"
        } else {
            alert("Falha ao realizar cadastro.")
        }
    })
}

function logarUser(email, senha) {
    $.post(url, { req: 'login_user', email: email, senha: senha, setCookie: true }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.user) {
            verifCookie()
        } else {
            // usuario inválido
        }
    })
}

