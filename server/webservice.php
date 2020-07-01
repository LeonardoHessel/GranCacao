<?php

// Limitar o acesso.

require_once 'controller.php';

extract($_POST);

if (isset($req)) {
    // Cadastro, Login, Verificar, Logout
    if ($req == "register_client") {
        tryRegisterClient();
    } else if ($req == "login_client") {
        tryLoginClient();
    } else if ($req == "check_client") {
        tryCheckClient();
    } else if ($req == "logout_client") {
        logoutClient();
    } else if ($req == "login_user") {
        tryLoginUser();
    } else if ($req == "check_user") {
        tryCheckUser();
    } else if ($req == "logout_user") {
        logoutUser();
    } else if ($req == "register_user") {
        tryRegisterUser();
    }

    // Mais Conteudo ainda não produzido.

    $resp["error"] = "Undefined Variable";
    arrayJSON($resp);
}
$resp["error"] = "Undefined Request";
arrayJSON($resp);
