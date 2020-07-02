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
        ctrlRegisterUser();
    }  else if ($req == "reg_group") {
        tryRegisterProductGroup();
    }




    // Mais Conteudo ainda não produzido.

    $resp["error"] = "Undefined Variable";
    arrayJSON($resp);
}
$resp["error"] = "Undefined Request";
arrayJSON($resp);
