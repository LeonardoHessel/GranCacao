<?php
require_once 'conexao.php';
require_once 'usuario.php';



$usuario = new Usuario();
$usuario->setDados('Leonardo','leonardo@hotmail.com','4783@');
//$usuario->cadUsuario();
$usuario->logUsuario();
var_dump($usuario);
