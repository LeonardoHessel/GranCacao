<?php

// Limitar o acesso.

require_once 'functions.php';

// Tenta cadastrar usuario.
function tryRegisterUser() {
    extract($_POST);
    // limpeza de dados.
    if (isset($email,$senha)) {
        if (!isRegistered($email)){
            $senha = hash('sha256', $senha);
            $reg = registerUser($email,$senha);
            $resp["record"] = $reg;
        } else {
            $resp["record"] = false;
        }
        arrayJSON($resp);
    }
}

// Tenta logar o usuario.
function tryLoginUser() {
    extract($_POST);
    // limpeza de dados.
    if (isset($email,$senha,$setCookie)) {
        $senha = hash('sha256', $senha);
        $user = getUser($email,$senha);
        if ($user) {
            $resp["id"] = $user->id;
            if ($setCookie == "true") {
                setDeviceCookie($user->id);
            }
        } else {
            $resp["id"] = false;
        }
        arrayJSON($resp);
    }
}

// Faz logout do usuario.
function logoutUser() {
    extract($_COOKIE);
    // limpeza de dados.
    if (isset($user,$device)) {
        dropDeviceCookies($user,$device);
    }
    $resp["Logout"] = true;
    arrayJSON($resp);
}

// Faz a checagem do usuario.
function checkUser() {
    extract($_COOKIE);
    // limpeza de dados.
    if (isset($user,$device)){
        $resp["user"] = checkDeviceCookie($user,$device);
        arrayJSON($resp);
    }
}

// Tranforma um array em JSON e termina o script.
function arrayJSON($array){
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
    exit;
}
