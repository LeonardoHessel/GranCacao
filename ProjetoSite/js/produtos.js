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
                if (prod.active == '1') {
                    html += `
                    <div div class="col-xl-3 col-lg-6 mt-5" >
                        <div class="bg-brown">
                            <h3 class="responsive text-center">${prod.name}</h3>
                            <img src="${/*prod.image[0]*/''}" class="img-card mb-2 rounded">
                            <p>${prod.description}</p>`
                    if (user) {
                        html += `
                        <div class="d-flex justify-content-between">
                            <button class="btn" onclick="alert(${prod.id_product})">
                                <i class="text-primary material-icons" aria-hidden="true">mode_edit</i>
                            </button>
                            <button class="btn" onclick="DeleteProduct(${prod.id_product})">
                                <i class="material-icons text-danger" aria-hidden="true">delete</i>
                            </button>
                        </div>`
                    }
                    html += `
                            
                        </div>
                    </div>
                    `
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
			</div>
            `
        }
        $("#cardapio").html(html)
    })
}

function DeleteProduct(id_product) {
    let ask = confirm("Deseja realmente deletar este Produto?")
    if (ask) {
        $.post(url, { req: "del_product", id_product: id_product }).done(function (resp) {
            let json = $.parseJSON(resp)
            if (json.del_product) {
                CarregarProdutos()
            }
        })
    }
}


