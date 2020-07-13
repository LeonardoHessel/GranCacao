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
    // Produtos
    else if ($req == "reg_product") {
        ctrlRegProduct();
    } else if ($req == "all_product") {
        ctrlGetAllProducts();
    } else if ($req == "get_product") {
        ctrlGetProduct();
    } else if ($req == "upd_product") {
        ctrlUpdProduct();
    } else if ($req == "active_product") {
        ctrlChangeProductActivation();
    } else if ($req == "del_product") {
        ctrlDelProduct();
    } 
    // Imagens Produtos
    else if ($req == "add_prod_image") {
        ctrlAddProdImage();
    } else if ($req == "get_prod_images") {
        ctrlGetProdImages();
    } else if ($req == "del_prod_image") {
        ctrlDelProdImage();
    } 
    // 
    $resp["error"] = "Undefined Variable";
    toJSON($resp);
}
$resp["error"] = "Undefined Request";
toJSON($resp);
