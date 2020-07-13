<?php

// Limitar o acesso.

require_once 'conexao.php';
use Conexao as Con;

// --- Untilitários --- //
// INTERNA Pega o ultimo id inserido.
function getLastInsertedID() {
    return Con::PDO()->lastInsertId();
}
// INTERNA Tranforma em JSON e termina o script.
function toJSON($var){
    echo json_encode($var, JSON_UNESCAPED_UNICODE);
    exit;
}
// INTERNA Tranforma em Veradeiro ou falso
function toBool($var) {
    if ($var == '1' || $var == 'true' || $var == 'TRUE') {
        return true;
    } else if ($var == '0' || $var == 'false' || $var == 'FALSE') {
        return false;
    }
    return null;
}
// INTERNA Gera um nome aleatório com a extenção no arquivo.
function genFileName($file){
    $fileExtension = explode('.', $file['name'])[1];
    $randomName = bin2hex(openssl_random_pseudo_bytes(10));
    return $randomName.".".$fileExtension;
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Cliente ----- //

// Verifica se há registro com email.
function isRegistered($email){
    $sql = 'SELECT * FROM `client` WHERE `email`=:email';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->execute();
    $user = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($user);
}
// Registra o cliente.
function regClient($email,$pass){
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $sql = 'INSERT INTO `client` (`email`,`pass`) VALUES (:email,:pass)';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    return $cmd->execute();
}
// Atualiza o cadastro de um cliente
function updClient($email,$pass,$name,$id_client) {
    $sql = 'UPDATE `client` SET `email`=:email, `pass`=:pass, `name`=:name WHERE `id_client`=:id_client';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    $cmd->bindParam(':name',$name);
    $cmd->bindParam(':id_client',$id_client);
    return $cmd->execute();
}
// Gera um objeto através da tabela cliente.
function getClient($email,$pass) {
    $sql = 'SELECT * FROM `client` WHERE `email`=:email AND `pass`=:pass AND `active`= TRUE';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}
// Salva o token do dispositivo e set o cookie.
function setDeviceCookie($id_client, $days) {
    $sql = "INSERT INTO `client_device` VALUES (:id_client,:token,DATE_ADD(NOW(), INTERVAL :days DAY))";
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_client',$id_client);
    $cmd->bindParam(':token',$token);
    $cmd->bindParam(':days',$days);
    $cmd->execute();
    if ($days > 1){
        setcookie('device',$token, time() + (86400 * 7), "/");
        setcookie('client',$id_client, time() + (86400 * 7), "/");
    } else {
        setcookie('device',$token,0);
        setcookie('client',$id_client,0);
    }
}
// Verifica a validade do token no banco de dados.
function checkDeviceCookie($id_client, $token){
    $sql = "SELECT * FROM `client_device` WHERE `id_client`= :id_client AND `token`= :token AND `expiration` > DATE(NOW())";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_client',$id_client);
    $cmd->bindParam(':token',$token);
    $cmd->execute();
    $device = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($device);
}
// (Logout) Deleta o refistro no BD e dropa o cookie.
function dropDeviceCookies($id_client,$token) {
    $sql = 'DELETE FROM `client_device` WHERE `id_client`=:id_client AND `token`=:token';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_client',$id_client);
    $cmd->bindParam(':token',$token);
    $cmd->execute();
    setcookie('client','', time() - 3600);
    setcookie('device','', time() - 3600);
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Usuário ----- //

// Cria um objeto através da tabela user.
function getUser($email, $pass) {
    $sql = 'SELECT * FROM `user` WHERE `email`=:email AND `pass`=:pass AND `active`= TRUE';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}
// Gera um token para o usuario
function generateUserToken($id_user) {
    $sql = "UPDATE `user` SET `token`= :token WHERE `id_user`= :id_user";
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_user',$id_user);
    $cmd->bindParam(':token',$token);
    $cmd->execute();
    return $token;
}
// Define o cookie para a sessao do usuario.
function setUserCookies($id_user,$token) {
    setcookie('id_user',$id_user,0);
    setcookie('token',$token,0);
}
// Checa o cookie do usuario.
function checkUserToken($id_user, $token) {
    $sql = "SELECT * FROM `user` WHERE `id_user`= :id_user AND `token`= :token AND `active`= TRUE";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_user',$id_user);
    $cmd->bindParam(':token',$token);
    $cmd->execute();
    $user = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($user);
}
// Define o cookie para a sessao do usuario.
function dropUserCookies() {
    setcookie('id_user',"",time() - 3600);
    setcookie('token',"",time() - 3600);
}
// Verifica se o e-mail está cadastrado
function haveUserWithEmail($email){
    $sql = 'SELECT * FROM `user` WHERE `email`=:email';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->execute();
    $user = $cmd->fetch(PDO::FETCH_OBJ);
    return is_object($user);
}
// Registra um Usuário
function registerUser($email,$pass,$name){
    $sql = 'INSERT INTO `user` (`email`,`pass`,`name`) VALUES (:email,:pass,:name)';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    $cmd->bindParam(':name',$name);
    return $cmd->execute();
}
// Atualiza Um Usuário
function updUser($email,$pass,$name,$id_user) {
    $sql = 'UPDATE `user` SET `email`=:email, `pass`=:pass, `name`=:name WHERE `id_user`=:id_user';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':email',$email);
    $cmd->bindParam(':pass',$pass);
    $cmd->bindParam(':name',$name);
    $cmd->bindParam(':id_user',$id_user);
    return $cmd->execute();
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Grupos ----- //
// Registra um grupo
function regProdGroup($description){
    $sql = 'INSERT INTO `product_group` (`description`) VALUES (:description)';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':description',$description);
    return $cmd->execute();
}
// Busca todos os grupos de produtos
function getAllProdGroups() {
    $sql = "SELECT * FROM `product_group`";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->execute();
    return $cmd->fetchAll(PDO::FETCH_OBJ);
}
// Busca grupo por id
function getProdGroupByID($id_group) {
    $sql = "SELECT * FROM `product_group` WHERE `id_group`=:id_group";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_group',$id_group);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}
// Atualiza um Grupo
function updProdGroup($description,$id_group) {
    $sql = 'UPDATE `product_group` SET `description`= :description WHERE `id_group`=:id_group';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':description',$description);
    $cmd->bindParam(':id_group',$id_group);
    return $cmd->execute();
}
// Deletaum Grupo pelo id
function delProdGroup($id_group) {
    $sql = "DELETE FROM `product_group` WHERE `id_group`=:id_group";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_group',$id_group);
    return $cmd->execute();
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Produtos ----- //
// Retorna todos os Produtos
function getProds(){
    $sql = "SELECT * FROM `product`";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_product',$id_product);
    $cmd->execute();
    return $cmd->fetchAll(PDO::FETCH_OBJ);
}
// Retorna um produto
function getProd($id_product){
    $sql = "SELECT * FROM `product` WHERE `id_product`=:id_product";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_product',$id_product);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}
// Busca em Produtos --- Em manutenção
function searchProds($search, $active){
    $sql = "SELECT * FROM `product` WHERE (`id_product` LIKE CONCAT('%',:search,'%') OR `nome` LIKE CONCAT('%',:search,'%') OR `value` LIKE CONCAT('%',:search,'%') OR `description` LIKE CONCAT('%',:search,'%'))AND `active`=:active";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':search',$search);
    $cmd->bindParam(':active',$active);
    $cmd->execute();
    return $cmd->fetchAll(PDO::FETCH_OBJ);
}
// Cadastra um produto.
function regProd($name,$value,$description,$id_group) {
    $sql = 'INSERT INTO `product` VALUES (0,:name,:value,:description,:id_group,TRUE)';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':name',$name);
    $cmd->bindParam(':value',$value);
    $cmd->bindParam(':description',$description);
    $cmd->bindParam(':id_group',$id_group);
    return $cmd->execute();
}
// Atualiza um produto
function updProd($id_product,$name,$value,$description,$id_group,$active){
    $sql = 'UPDATE `product` SET `name`=:name, `value`=:value, `description`=:description, `id_group`=:id_group, `active`=:active WHERE `id_product`=:id_product';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':name',$name);
    $cmd->bindParam(':value',$value);
    $cmd->bindParam(':description',$description);
    $cmd->bindParam(':id_group',$id_group);
    $cmd->bindParam(':active',$active);
    $cmd->bindParam(':id_product',$id_product);
    return $cmd->execute();
}
// Altera o produto para ativo ou inativo
function activeInactiveProd($id_product,$active){
    $sql = 'UPDATE `product` SET `active`=:active WHERE `id_product`=:id_product';
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_product',$id_product);
    $cmd->bindParam(':active',$active);
    return $cmd->execute();
}
// Deleta um produto.
function delProd($id_product) {
    $sql = "DELETE FROM `product` WHERE `id_product`=:id_product LIMIT 1";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(":id_product",$id_product);
    return $cmd->execute();
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Imagens de Produtos ----- //
// Renomeia, redimenciona e salva a imagem
function renameResizeAndSaveImage($prodImage) {
    $oldfileName = genFileName($prodImage);
    $path = "../image/";
    sendImage($prodImage,$path,$oldfileName);
    $rsd = resizeImage($path.$oldfileName, 300, 300);
    $fileName = "300x_".$oldfileName;
    imagejpeg($rsd,$path.$fileName);
    unlink($path.$oldfileName);
    return $fileName;
}
// Registra o arquivo
function dbRegProdImage($id_product,$fileName) {
    $sql = "INSERT INTO `product_image` (`id_product`,`address`) VALUES (:id_product,:address)";            
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(":id_product", $id_product);
    $cmd->bindParam(":address", $fileName);
    return $cmd->execute();
}
// Retorna as imagens se houver produto ou imagem
function getProdImages($id_product){
    $sql = "SELECT * FROM `product_image` WHERE `id_product`=:id_product";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(':id_product',$id_product);
    $cmd->execute();
    return $cmd->fetchAll(PDO::FETCH_OBJ);
}
// INTERNA Retorna uma imagem se houver produto ou imagem
function getProdImage($id_image){
    $sql = "SELECT * FROM `product_image` WHERE `id_image`=:id_image";
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(":id_image", $id_image);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_OBJ);
}
// Deleta uma imagen se houver produto ou imagem
function delProdImage($id_image) {
    $sql = "DELETE FROM `product_image` WHERE `id_image`=:id_image";          
    $cmd = Con::PDO()->prepare($sql);
    $cmd->bindParam(":id_image", $id_image);
    return $cmd->execute();
}

// INTERNA Veriica se a imagem é do tipo desejado e menor do que 5Mb
function checkImage($image) {
    if ($image['type'] == 'image/jpeg' || $image['type'] == 'image/jpg' || $image['type'] == 'image/png') {
        $size = ($image['size'] / 1024) / 1024;
        if ($size <= 5) {
            return true;
        }
    }
    return false;
}
// INTERNA Redimenciona a imagem.
function resizeImage($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}
// INTERNA Salva a imagem para o servidor numa pasta especifica.
function sendImage($file, $path, $fileName) {
    return move_uploaded_file($file['tmp_name'], $path.$fileName);
}
// INTERNA Deleta arquivo de imagem
function delImageFile($imageFile) {
    $path = "../image/";
    unlink($path.$imageFile);
}

// ---------- ---------- ---------- ---------- ---------- //
