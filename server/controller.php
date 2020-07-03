<?php

// Limitar o acesso.

require_once 'functions.php';

// Tenta cadastrar cliente.
function ctrlRegClient() {
    extract($_POST);
    if (isset($email,$pass)) {
        $email = htmlspecialchars($email);
        $pass = htmlspecialchars($pass);
        if (!isRegistered($email)){
            $pass = hash('sha256', $pass);
            $reg = regClient($email,$pass);
            $resp["record"] = $reg;
        } else {
            $resp["record"] = false;
            $resp["message"] = "Email já cadastrado";
        }
        arrayJSON($resp);
    }
}

// INTERNA Checa cliente retorna true ou false.
function checkClient() {
    extract($_COOKIE);
    if (isset($client,$device)){
        $client = htmlspecialchars($client);
        $device = htmlspecialchars($device);
        return checkDeviceCookie($client,$device);
    }
    return false;
}


// Tenta logar o cliente.
function ctrlLoginClient() {
    extract($_POST);
    if (isset($email,$pass,$stayLoggedIn)) {
        $email = htmlspecialchars($email);
        $pass = htmlspecialchars($pass);
        $stay = htmlspecialchars($stayLoggedIn);
        $pass = hash('sha256', $pass);
        $client = getClient($email,$pass);
        if ($client) {
            if ($stay == "true") {
                setDeviceCookie($client->id_client, 7);
            } else {
                setDeviceCookie($client->id_client, 1);
            }
            $resp["client"] = true;
        } else {
            $resp["client"] = false;
        }
        arrayJSON($resp);
    }
}

// Tenta atualiza cliente.
function ctrlUpdClient() {
    if (checkClient()) {
        extract($_COOKIE);
        if (isset($client,$device)){
            extract($_POST);
            if (isset($email,$pass,$name)) {
                $email = htmlspecialchars($email);
                $pass = htmlspecialchars($pass);
                $name = htmlspecialchars($name);
                $pass = hash('sha256', $pass);
                $client = htmlspecialchars($client);
                $resp["upd_client"] = updClient($email,$pass,$name,$client);
                arrayJSON($resp);
            }
        }
    }
}

// Checa cliente retorna webservice.
function ctrlCheckClient() {
    $resp["client"] = checkClient();
    arrayJSON($resp);
}

// Faz logout do cliente.
function ctrlLogoutClient() {
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
function ctrlLoginUser() {
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

// INTERNA Checa usuário retorna true ou false.
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
function ctrlCheckUser() {
    $resp["user"] = checkUser();
    arrayJSON($resp);
}

// Realiza o logout do usuário.
function ctrlLogoutUser() {
    extract($_COOKIE);
    if (isset($id_user)) {
        $id_user = htmlspecialchars($id_user);
        dropUserCookies($id_user);
        generateUserToken($id_user);
    }
    $resp["logout"] = true;
    arrayJSON($resp);
}

// Registra um novo usuário através de um usuário.
function ctrlRegUser() {
    if (checkUser()) {
        extract($_POST);
        if (isset($email, $pass, $name)) {
            $email = htmlspecialchars($email);
            $pass = htmlspecialchars($pass);
            $pass = hash('sha256', $pass);
            $name = htmlspecialchars($name);
            if (!haveUserWithEmail($email)) {
                $resp["reg_user"] = registerUser($email,$pass,$name);
                arrayJSON($resp);
            }
            $resp["message"] = "Email já cadastrado";
        }
    }
    $resp["reg_user"] = false;
    arrayJSON($resp);
}


function ctrlUpdUser() {
    if (checkUser()) {
        extract($_COOKIE);
        if (isset($id_user,$token)){
            extract($_POST);
            if (isset($email,$pass,$name)) {
                $email = htmlspecialchars($email);
                $pass = htmlspecialchars($pass);
                $name = htmlspecialchars($name);
                $pass = hash('sha256', $pass);
                $id_user = htmlspecialchars($id_user);
                $resp["upd_user"] = updUser($email,$pass,$name,$id_user);
                arrayJSON($resp);
            }
        }
    }
}

function ctrlRegProdGroup() {
    if (checkUser()) {
        extract($_POST);
        if (isset($description)) {
            $description = htmlspecialchars($description);
            $resp["reg_group"] = regProdGroup($description);
            arrayJSON($resp);
        }
    }
    $resp["reg_group"] = false;
    arrayJSON($resp);
}

function ctrlUpdProdGroup() {
    if (checkUser()) {
        extract($_POST);
        if (isset($description,$id_group)) {
            $description = htmlspecialchars($description);
            $id_group = htmlspecialchars($id_group);
            $resp["upd_group"] = updProdGroup($description,$id_group);
            arrayJSON($resp);
        }
    }
    $resp["upd_group"] = false;
    arrayJSON($resp);
}






// Tranforma um array em JSON e termina o script.
function arrayJSON($array){
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
    exit;
}
