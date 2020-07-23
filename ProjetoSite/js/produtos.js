var urlImg = "http://grancacao/image/"
$(document).ready(function () {
    CarregarProdutos()
})

function CarregarProdutos() {
    let user = false
    user = CheckUser()
    $.post(url, { req: "all_product" }).done(function (resp) {
        let json = $.parseJSON(resp)
        let html = ""
        if (json.all_products) {
            $("#cardapio").html("")
            json.products.forEach(prod => {
                // Se o Produto estiver ativo ou se o usuario estiver logado
                if (prod.active == '1' || user) {
                    html += `
                    <div div class="col-xl-3 col-lg-6 mt-5">
                        <div class="bg-brown">
                            <h3 class="responsive text-center">${prod.name}</h3>`
                    // Verifica se o produto possui foto
                    if (prod.images.length > 0) {
                        // Abre a div do carrossel
                        html += `
                        <div id="imgsProd${prod.id_product}" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">`
                        // Para cada foto que for gerar e se for a primeira ira receber a classe active
                        for (let i = 0; i < prod.images.length; i++) {
                            let a
                            i == 0 ? a = 'active' : a = ''
                            const img = prod.images[i]
                            html += `
                            <div class="carousel-item ${a}">
                                <img class="d-block" height="auto" width="100%" src="http://grancacao/image/${img.address}" alt="${img.id_image + '.' + img.id_product}">
                            </div>`
                        }
                        // Fecha a div do carrossel
                        html += `</div></div>`
                    }
                    html += `<p>${prod.description}</p> `
                    if (user) {
                        html += `
                            <div class="d-flex justify-content-between">
                                <button class="btn" data-toggle="modal" data-target="#modalProd" onclick="EditarProduct(${prod.id_product})">
                                    <i class="text-primary material-icons" aria-hidden="true">mode_edit</i>
                                </button>
                                <button class="btn" onclick="DeleteProduct(${prod.id_product})">
                                    <i class="material-icons text-danger" aria-hidden="true">delete</i>
                                </button>
                            </div>`
                    }
                    html += `</div ></div >`
                }
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
			</div>`
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
            LimparCampos()
            let prod = json.product
            $('#name').val(prod.name)
            $('#id').val(prod.id_product)
            $('#value').val(prod.value)
            $('#active').val(prod.active)
            $('#description').val(prod.description)
        } else {
            // console.log(json)
        }
    })
    LimparCampos()
}

function LimparCampos() {
    $('#name').val('')
    $('#id').val(0)
    $('#value').val('')
    $('#active').val("0")
    $('#description').val('')
}


