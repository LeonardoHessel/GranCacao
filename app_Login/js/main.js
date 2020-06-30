function validaEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function validaSenha(senha) {
    const regex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
    return regex.test(senha);
}

$(document).ready(function () {
    $("form").submit(function (e) {
        e.preventDefault()
    })

    verifCookie()
    $('.message a').click(function () {
        $('form').animate({ height: "toggle", opacity: "toggle" }, "slow")
    })



    $("#btnCadastrar").click(function () {
        let error = []
        let email = $('#cadEmail').val()
        let senha = $('#cadSenha').val()
        if (!validaEmail(email)) {
            error.push('email')
        }
        if (!validaSenha(senha)) {
            error.push('senha')
        }
        if (error.length == 0) {
            cadastrarUsuario(email, senha)
        }
    })
    $("#btnLogar").click(function () {
        let error = []
        let email = $('#logEmail').val()
        let senha = $('#logSenha').val()
        if (!validaEmail(email)) {
            error.push('email')
        }
        // // if (!validaSenha(senha)) {
        // //     error.push('senha')
        // // }
        if (error.length == 0) {
            logarUser(email, senha)
        }
    })
})





/*
// https://www.thepolyglotdeveloper.com/2015/05/use-regex-to-test-password-strength-in-javascript/
function validaEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validaSenha(senha) {
    const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    const mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
    return mediumRegex.test(senha);
}
*/
// Envio de imagem ajax.
/*
var datax = new FormData();
var imagem = $('#conteudo").files[0];
datax.append("imagem", imagem);
    $.ajax
    ({
        url: 'http://aula/tcc/server/mediaservice.php',
        method: 'post',
        data: datax,
        cache: false,
        processData: false,
        enctype: 'multipart/form-data',
        contentType: false,
        async: false,
        success: function(retorno){

        },
        timeout:3000,
        error:function()
        {



        }
    });
    */
