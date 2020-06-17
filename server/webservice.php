<?php
require_once 'conexao.php';
require_once 'usuario.php';


function arrayJSON($array){
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
    exit;
}

extract($_POST);

if (!isset($type)){
    $response['error'] = "Invalid Request";
    arrayJSON($response);
}

if ($type == 'cadastrar_usuario'){
    if (isset($email,$senha)){
        $usuario = new Usuario();
        $usuario->definirDados($email,$senha);
        $response = $usuario->cadastrarUsuario();
        arrayJSON($response);
    } else {
        $response['cadastro_status:'] = false;
        $response['error'] = "Variáveis não definidas para o tipo de requisição.";
        arrayJSON($response);
    }
}

if ($type == 'checar_cookie'){
    extract($_COOKIE);
    if (isset($id_user,$token_device)){
        if (Usuario::checarCookie($id_user,$token_device)){
            $response['cookie_status'] = "Válidos";
            arrayJSON($response);
        } else {
            $response['cookie_status'] = "Inválidos";
            arrayJSON($response);
        }
    } else {
        $response['cookie_status'] = "Não definidos.";
        arrayJSON($response);
    }
}

if ($type == 'logar_usuario'){
    if (isset($email,$senha)){
        $usuario = new Usuario();
        $usuario->definirDados($email,$senha);
        $user = $usuario->logarUsuario();
        if ($user != false){
            arrayJSON($user);
        } else {
            $response['logar_status:'] = false;
            $response['error:'] = "E-mail invalido.";
            arrayJSON($response);
        }
    } else {
        $response['logar_status:'] = false;
        $response['error:'] = "Variáveis não definidas para o tipo de requisição.";
        arrayJSON($response);
    }
}




