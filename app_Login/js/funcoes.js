var url = 'http://grancacao/server/webservice.php'
var methodType = 'post'

function verifCookie() {
    $.post(url, { type: 'verif_cookie' }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.cookie) {
            alert("Tem cookie")
        } else {
            alert("Não tem cookie")
        }
    })
}

function logarUser(email, senha) {
    $.post(url, { type: 'logar_user', email: email, senha: senha }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.login) {
            alert('login válido')
        } else {
            alert('login inválido')
        }
    })
}