var url = "http://grancacao/server/webservice.php"

function CheckUser() {
    let user = false
    $.ajax({
        url: url, method: 'post', data: { "req": "check_user" }, async: false, success: function (resp) {
            let json = $.parseJSON(resp)
            user = json.user
        }, timeout: 3000, error: function (resp) {
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
            $('.pvIMG').attr('src', e.target.result)
        }
        reader.readAsDataURL(input.files[0])
    }
}


$(document).ready(function () {
    // Configura O layout caso usuário esteja logado
    if (CheckUser()) {
        $("#login").hide()
        $("#logout").show()
    } else {
        $("#login").show()
        $("#logout").hide()
    }

    // Exibe a imagem no modal
    $("#images").change(function () {
        readURL(this);
    })

    // Exibe a imagem no modal
    $("#upd_images").change(function () {
        readURL(this);
    })

    // Limpa o modal de cadastro Produto
    $("#btnCloseModal").click(function () {
        $('#blah').attr('src', "#");
        $('#lblNomeProduto').val(" ");
        $('#lblDescricao').val(" ");
    })

    // Salva o produto
    $('#Product').submit(function (e) {
        e.preventDefault()
        let data = new FormData(Product);
        $.ajax({
            url: url, method: 'post', data: data, cache: false,
            processData: false, enctype: 'multipart/form-data',
            contentType: false, async: false,
            success: function (resp) {
                let json = $.parseJSON(resp)
                if (json.reg_product) {
                    $('.btnCloseModal').click()
                }
            },
            timeout: 3000,
            error: function (resp) {
                console.log(resp)
            }
        })
        CarregarProdutos()
    })

    $('#modalEditarProduto').submit(function (e) {
        e.preventDefault()
        let data = new FormData(upd_product)
        data.append('id_product', $('#upd_id').val())
        $.ajax({
            url: url, method: 'post', data: data, cache: false,
            processData: false, enctype: 'multipart/form-data',
            contentType: false, async: false,
            success: function (resp) {
                let json = $.parseJSON(resp)
                if (json.upd_product) {
                    $('.btnCloseModal').click()
                }
            },
            timeout: 3000,
            error: function (resp) {
                console.log(resp)
            }
        })
        updLimparCampos()
        CarregarProdutos()
    })


    $('#reg_user').submit(function (e) {
        e.preventDefault()
        let data = new FormData(reg_user)
        $.ajax({
            url: url, method: 'post', data: data, cache: false,
            processData: false, enctype: 'multipart/form-data',
            contentType: false, async: false,
            success: function (resp) {
                let json = $.parseJSON(resp)
                console.log(json)
                if (json.reg_user) {
                    alert("Usuário adicionado com sucesso!")
                    $('.btnCloseModal').click()
                }
            },
            timeout: 3000,
            error: function (resp) {
                let json = $.parseJSON(resp)
                console.log(json)
            }
        })
    })
})

































