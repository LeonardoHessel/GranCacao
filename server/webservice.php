<?php

// Limitar o acesso.

require_once 'controller.php';

extract($_POST);

if (isset($req)) {
    // Clientes
    if ($req == "reg_client") {
        ctrlRegClient();
    } else if ($req == "login_client") {
        ctrlLoginClient();
    } else if ($req == "upd_client") {
        ctrlUpdClient();
    } else if ($req == "check_client") {
        ctrlCheckClient();
    } else if ($req == "logout_client") {
        ctrlLogoutClient();
    }
    // Usuários
    else if ($req == "login_user") {
        ctrlLoginUser();
    } else if ($req == "check_user") {
        ctrlCheckUser();
    } else if ($req == "logout_user") {
        ctrlLogoutUser();
    } else if ($req == "reg_user") {
        ctrlRegUser();
    } else if ($req == "upd_user") {
        ctrlUpdUser();
    }
    // Produtos
    else if ($req == "get_all_product") {
        ctrlGetProds();
    } else if ($req == "get_product") {
        ctrlGetProd();
    } else if ($req == "search_products") {
        //ctrlSearchProds(); // -- Em manutenção
    } else if ($req == "reg_product") {
        ctrlRegProd();
    } else if ($req == "upd_product") {
        ctrlUpdProd();
    } else if ($req == "active_product") {
        ctrlActiveInactivateProd();
    } else if ($req == "del_product") {
        ctrlDelProd();
    } 
    // Imagens Produtos
    else if ($req == "add_prod_image") {
        ctrlAddProdImage();
    } else if ($req == "get_prod_images") {
        ctrlGetProdImages();
    } else if ($req == "del_prod_image") {
        ctrlDelProdImage();
    } 
    // Grupo Produtos
    else if ($req == "reg_group") {
        ctrlRegProdGroup();
    } else if ($req == "all_group") {
        ctrlGetAllProdGroups();
    } else if ($req == "get_group") {
        ctrlGetProdGroup();
    } else if ($req == "upd_group") {
        ctrlUpdProdGroup();
    } else if ($req == "del_group") {
        ctrlDelProdGroup();
    }
    // 
    else if ($req == "") {
        
    } else if ($req == "") {
        
    }

    


    // Mais Conteudo ainda não produzido.

    $resp["error"] = "Undefined Variable";
    toJSON($resp);
}
$resp["error"] = "Undefined Request";
toJSON($resp);
