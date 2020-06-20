<?php

// Limitar o acesso.

require_once 'conexao.php';
use Conexao as Con;

// Usuário //
// Verifica se há registro com email.
function isRegistered($email){
    $sql = 'SELECT * FROM `usuario` WHERE `email`=:email';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->execute();
    $user = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($user);
}

// Registra o usuario.
function registerUser($email,$senha){
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $sql = 'INSERT INTO `usuario` (`email`,`senha`,`token`) VALUES (:email,:senha,:token)';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':senha',$senha);
    $cmd->bindParam(':token',$token);
    return $cmd->execute();
}

// Carrega um objeto usuario.
function getUser($email,$senha) {
    $sql = 'SELECT * FROM `usuario` WHERE `email`=:email AND `senha`=:senha AND `del`= FALSE';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':senha',$senha);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}

// Cookies //
// Salva o token do dispositivo e set o cookie.
function setDeviceCookie($user) {
    $sql = "INSERT INTO `usuario_dispositivo` VALUES (:id_user,:token,DATE(DATE_ADD(NOW(), INTERVAL 7 DAY)))";
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_user',$user);
    $cmd->bindParam(':token',$token);
    $cmd->execute();
    setcookie('device',$token, time() + (86400 * 7), "/");
    setcookie('user',$user, time() + (86400 * 7), "/");
}

// Verifica a validade do token no banco de dados.
function checkDeviceCookie($user, $device){
    $sql = "SELECT * FROM `usuario_dispositivo` WHERE `usuario`= :user AND `token`= :token AND `validade` > DATE(NOW())";
    $cmd = Con::getPDO()->prepare($sql);
    $cmd->bindParam(':user',$user);
    $cmd->bindParam(':token',$device);
    $cmd->execute();
    $dev = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($dev);
}

// (Logout) Deleta o refistro no BD e dropa o cookie.
function dropDeviceCookies($user,$device) {
    $sql = 'DELETE FROM `usuario_dispositivo` WHERE `usuario`=:usuario AND `token`=:token';
    $cmd = Con::getPDO()->prepare($sql);
    $cmd->bindParam(':usuario',$user);
    $cmd->bindParam(':token',$device);
    $cmd->execute();
    setcookie('user','', time() + (86400 * 7), "/");
    setcookie('device','', time() + (86400 * 7), "/");
}
