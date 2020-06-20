<?php

// Limitar o acesso.

require_once 'controller.php';

extract($_POST);

if (isset($req)) {
    if ($req == "checkUser") {
        checkUser();
    } else if ($req == "login_user") {
        tryLoginUser();
    } else if ($req == "logout_user") {
        logoutUser();
    } else if ($req == "reg_user") {
        tryRegisterUser();
    }
    $resp["error"] = "Undefined Variable";
    arrayJSON($resp);
}
$resp["error"] = "Undefined Request";
arrayJSON($resp);
