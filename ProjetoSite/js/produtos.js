var urlImg = "http://grancacao/image/"
$(document).ready(function () {
    CarregarProdutos()
})

function cardProduto(prod, user) {
    let html = ''
    // Se o Produto estiver ativo ou se o usuario estiver logado
    if (prod.active == '1' || user) {
        let info
        prod.active != '1' ? info = "(Inativo)" : info = ''
        html += `
        <div div class="col-xl-3 col-lg-6 mt-5">
            <div class="bg-brown">
                <h3 class="responsive text-center">${prod.name + ' ' + info}</h3>`
        // Verifica se o produto possui foto
        if (prod.images.length > 0) {
            let img = prod.images[0]
            html += `<img src="${urlImg + img.address}" alt="${img.id_image + '.' + img.id_product}" class="img-card mb-2 rounded">`
        }
        html += `
        <div class="d-flex justify-content-end">
            <h4>$ ${prod.value}</h4>
        </div>
        <p>${prod.description}</p>
        `
        if (user) {
            html += `
            <div class="d-flex justify-content-between">
                <button class="btn" data-toggle="modal" data-target="#modalEditarProduto" onclick="EditarProduct(${prod.id_product})">
                    <i class="text-primary material-icons" aria-hidden="true">mode_edit</i>
                </button>
                <button class="btn" onclick="DeleteProduct(${prod.id_product})">
                    <i class="material-icons text-danger" aria-hidden="true">delete</i>
                </button>
            </div>`
        }
        html += `</div></div>`
    }
    return html
}

function CarregarProdutos() {
    let user = false
    user = CheckUser()
    $.post(url, { req: "all_product" }).done(function (resp) {
        let json = $.parseJSON(resp)
        let html = ""
        if (json.all_products) {
            $("#cardapio").html("")
            json.products.forEach(prod => {
                // Monta os card dos Produtos
                html += cardProduto(prod, user)
            })
        }
        if (user) {
            html += `
            <div class="col-xl-3 col-lg-6 mt-5">
                <div id="btnAddCard" class="bg-brown d-flex flex-column justify-content-center" style="height: 10vh;">
                    <button type="button" class="btn" data-toggle="modal" data-target="#modalProd">
                        <i class="fa fa-plus text-light" aria-hidden="true"></i>
                    </button>
                </div>
			</div> `
        }
        $("#cardapio").html(html)
    })
}

function DeleteProduct(id_product) {
    let ask = confirm("Todas as imagens desse produto serão apagadas.\nDeseja realmente deletar este Produto?")
    if (ask) {
        $.post(url, { req: "del_product", id_product: id_product }).done(function (resp) {
            let json = $.parseJSON(resp)
            if (json.del_product) {
                CarregarProdutos()
            } else {
                CarregarProdutos()
                alert("falha ao deletar o produto")
                console.log(json)
            }
        })
    }
}

function EditarProduct(id_product) {
    $.post(url, { req: "get_product", id_product: id_product }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.product != null) {
            updLimparCampos()
            $('#btnDelIMG').prop('disabled', true)
            let prod = json.product
            $('#upd_name').val(prod.name)
            $('#upd_id').val(prod.id_product)
            $('#upd_value').val(prod.value)
            $('#upd_active').val(prod.active)
            $('#upd_description').val(prod.description)
            if (prod.images.length > 0) {
                $('#btnDelIMG').prop('disabled', false)
                $("#btnDelIMG").attr("onclick", `DelIMG(${prod.images[0].id_image})`);
                $('.pvIMG').attr('src', urlImg + prod.images[0].address)
            } else {
                $('.pvIMG').attr('src', '')
            }

        }
    })
}

function DelIMG(id_image) {
    $.post(url, { req: "del_prod_image", id_image: id_image }).done(function (resp) {
        let json = $.parseJSON(resp)
        if (json.del_image) {
            CarregarProdutos()
            $('.btnCloseModal').click()
        } else {
            CarregarProdutos()
            alert("falha ao deletar Imagem")
            console.log(json)
        }
    })
}

function LimparCampos() {
    $('#name').val('')
    $('#id').val(0)
    $('#value').val('')
    $('#active').val("0")
    $('#description').val('')
    $('#images').val('')
    $('.images').val('')
    $('#upd_images').val('')
    $('.pvIMG').attr('src', '')
}

function updLimparCampos() {
    $('#upd_name').val('')
    $('#upd_id').val(0)
    $('#upd_value').val('')
    $('#upd_active').val("0")
    $('#upd_description').val('')
    $('#upd_images').val('')
    $('#images').val('')
    $('.images').val('')
    $('.pvIMG').attr('src', '')
}


