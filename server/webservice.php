<?php

// Limitar o acesso.

require_once 'controller.php';

extract($_POST);

if (isset($req)) {
    // Cadastro, Login, Verificar, Logout
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
    } else if ($req == "login_user") {
        ctrlLoginUser();
    } else if ($req == "check_user") {
        ctrlCheckUser();
    } else if ($req == "logout_user") {
        ctrlLogoutUser();
    } else if ($req == "reg_user") {
        ctrlRegUser();
    } else if ($req == "upd_user") {
        ctrlUpdUser();
    } else if ($req == "reg_group") {
        ctrlRegProdGroup();
    } else if ($req == "upd_group") {
        ctrlUpdProdGroup();
    } else if ($req == "reg_product") {
        //ctrlRegProd();
    } else if ($req == "upd_product") {
        //ctrlUpdProd();
    } else if ($req == "del_product") {
        //ctrlDelProd();
    } else if ($req == "add_prod_image") {
        ctrlAddProdImage();
    } else if ($req == "del_prod_image") {
        //ctrlDelProdImage();
    } else if ($req == "") {
        
    } else if ($req == "") {
        
    } else if ($req == "") {
        
    }

    


    // Mais Conteudo ainda não produzido.

    $resp["error"] = "Undefined Variable";
    arrayJSON($resp);
}
$resp["error"] = "Undefined Request";
arrayJSON($resp);
