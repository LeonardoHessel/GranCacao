<?php

// Limitar o acesso.

require_once 'functions.php';

// Tenta cadastrar cliente.
function tryRegisterClient() {
    extract($_POST);
    if (isset($email,$pass)) {
        $email = htmlspecialchars($email);
        $pass = htmlspecialchars($pass);
        if (!isRegistered($email)){
            $pass = hash('sha256', $pass);
            $reg = registerClient($email,$pass);
            $resp["record"] = $reg;
        } else {
            $resp["record"] = false;
        }
        arrayJSON($resp);
    }
}

// Tenta logar o cliente.
function tryLoginClient() {
    extract($_POST);
    if (isset($email,$pass,$keep)) {
        $email = htmlspecialchars($email);
        $pass = htmlspecialchars($pass);
        $keep = htmlspecialchars($keepMeLoggedIn);
        $pass = hash('sha256', $pass);
        $client = getClient($email,$pass);
        if ($client) {
            $resp["client"] = true;
            if ($keep == "true") {
                setDeviceCookie($client->id_client, 7);
            } else {
                setDeviceCookie($client->id_client, 1);
            }
        } else {
            $resp["client"] = false;
        }
        arrayJSON($resp);
    }
}

// Checa cliente retorna true ou false.
function CheckClient() {
    extract($_COOKIE);
    if (isset($client,$device)){
        $client = htmlspecialchars($client);
        $device = htmlspecialchars($device);
        return checkDeviceCookie($client,$device);
    }
    return false;
}

// Checa cliente retorna webservice.
function tryCheckClient() {
    $resp["client"] = CheckClient();
    arrayJSON($resp);
}

// Faz logout do cliente.
function logoutClient() {
    extract($_COOKIE);
    if (isset($client,$device)) {
        $client = htmlspecialchars($client);
        $device = htmlspecialchars($device);
        dropDeviceCookies($client,$device);
    }
    $resp["logout"] = true;
    arrayJSON($resp);
}


// ----- Usuários ----- //

// Realiza o login de um usuário.
function tryLoginUser() {
    extract($_POST);
    if (isset($email,$pass)) {
        $email = htmlspecialchars($email);
        $pass = htmlspecialchars($pass);
        $pass = hash('sha256', $pass);
        $user = getUser($email,$pass);
        if (is_object($user)) {
            $user->token = generateUserToken($user->id_user);
            setUserCookies($user->id_user,$user->token);
            $resp["user"] = true;
        } else {
            $resp["user"] = false;
        }
        arrayJSON($resp);
    }
}

// Checa usuário retorna true ou false.
function checkUser() {
    extract($_COOKIE);
    if (isset($id_user,$token)) {
        $id_user = htmlspecialchars($id_user);
        $token = htmlspecialchars($token);
        return checkUserToken($id_user, $token);
    }
    return false;
}

// Checa usuário retorna webservice.
function tryCheckUser() {
    $resp["user"] = checkUser();
    arrayJSON($resp);
}

// Realiza o logout do usuário.
function logoutUser() {
    extract($_COOKIE);
    if (isset($id_user)) {
        $id_user = htmlspecialchars($id_user);
        dropUserCookies($id_user);
        generateUserToken($id_user);
    }
    $resp["logout"] = true;
    arrayJSON($resp);
}


// ----- Usuários Funções ----- //

// Registra um novo usuário através de um usuário.
function tryRegisterUser() {
    if (checkUser()) {
        extract($_POST);
        if (isset($email, $pass, $name)) {
            $email = htmlspecialchars($email);
            $pass = htmlspecialchars($pass);
            $name = htmlspecialchars($name);
            if (!haveUserWithEmail($email)) {
                $resp["registered"] = registerUser($email,$pass,$name);
                arrayJSON($resp);
            }
            $resp["message"] = "Email já cadastrado";
        }
    }
    $resp["registered"] = false;
    arrayJSON($resp);
}








// Tranforma um array em JSON e termina o script.
function arrayJSON($array){
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
    exit;
}
