<?php

// Limitar o acesso.

require_once 'functions.php';

// ---------- ---------- ---------- ---------- ---------- //

// ----- Clientes ---- //

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
        toJSON($resp);
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
        toJSON($resp);
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
                toJSON($resp);
            }
        }
    }
}
// Checa cliente retorna webservice.
function ctrlCheckClient() {
    $resp["client"] = checkClient();
    toJSON($resp);
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
    toJSON($resp);
}

// ---------- ---------- ---------- ---------- ---------- //

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
        toJSON($resp);
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
    toJSON($resp);
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
    toJSON($resp);
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
                toJSON($resp);
            }
            $resp["message"] = "Email já cadastrado";
        }
    }
    $resp["reg_user"] = false;
    toJSON($resp);
}
// Atualiza um usuario
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
                toJSON($resp);
            }
        }
    }
}

// ---------- ---------- ---------- ---------- ---------- //

// Grupos

// Cria um Grupo
function ctrlRegProdGroup() {
    if (checkUser()) {
        extract($_POST);
        if (isset($description)) {
            $description = htmlspecialchars($description);
            $reg = regProdGroup($description);
            if ($reg) {
                $resp["reg_group"] = true;
                $id = getLastInsertedID();
                $resp["group"] = getProdGroupByID($id);
            } else {
                $resp["reg_group"] = false;
                $resp["group"] = null;
                $resp["message"] = Conexao::$msg;
            }
        } else {
            $resp["reg_group"] = false;
            $resp["group"] = null;
            $resp["message"] = "Undefined Variable for Product Group";
        }
        toJSON($resp);
    }
}
// Retorna os grupos dos produtos
function ctrlGetAllProdGroups() {
    extract($_POST);
    $allProdGroups = getAllProdGroups();
    if (!empty($allProdGroups)) {
        $resp["get_groups"] = true;
        $resp["qtd_groups"] = count($allProdGroups);
        $resp["groups"] = $allProdGroups;
    } else {
        $resp["get_groups"] = false;
        $resp["groups"] = null;
        $resp["message"] = "There is no recorded group";
    }
    toJSON($resp);
}
// Retorna os grupos dos produtos
function ctrlGetProdGroup() {
    extract($_POST);
    if (isset($id_group)) {
        $id_group = htmlspecialchars($id_group);
        $group = getProdGroupByID($id_group);
        if (is_object($group)) {
            $resp["group"] = $group;
        } else {
            $resp["group"] = null;
            $resp["message"] = "There is no group recorded with this id";
        }
    } else {
        $resp["upd_group"] = false;
        $resp["message"] = "Undefined Variable for Description or Id_Group";
    }
    toJSON($resp);
}
// Atualiza o cadastro de um grupo
function ctrlUpdProdGroup() {
    if (checkUser()) {
        extract($_POST);
        if (isset($description,$id_group)) {
            $description = htmlspecialchars($description);
            $id_group = htmlspecialchars($id_group);
            $group = getProdGroupByID($id_group);
            if (is_object($group)) {
                $update = updProdGroup($description,$id_group);
                if ($update) {
                    $resp["upd_group"] = true;
                    $resp["group"] = getProdGroupByID($id_group);
                } else {
                    $resp["upd_group"] = false;
                    $resp["message"] = Conexao::$msg;
                }
            } else {
                $resp["upd_group"] = false;
                $resp["message"] = "There is no group recorded with this id";
            }
            
        } else {
            $resp["upd_group"] = false;
            $resp["message"] = "Undefined Variable for Description or Id_Group";
        }
        toJSON($resp);
    }
    $resp["upd_group"] = false;
    toJSON($resp);
}
// Deleta um grupo pelo id
function ctrlDelProdGroup() {
    if (checkUser()) {
        extract($_POST);
        if (isset($id_group)) {
            $group = getProdGroupByID($id_group);
            if (is_object($group)) {
                $del = delProdGroup($id_group);
                if ($del) {
                    $resp["del_group"] = true;
                    $resp["message"] = "Group successfully deleted";
                } else {
                    $resp["del_group"] = false;
                    $resp["message"] = Conexao::$msg;
                }
            } else {
                $resp["upd_group"] = false;
                $resp["message"] = "There is no group recorded with this id";
            }
        } else {
            $resp["del_group"] = false;
            $resp["message"] = "Undefined Variable for Id_Group";
        }
        toJSON($resp);
    }
}


// ---------- ---------- ---------- ---------- ---------- //

// ----- Produtos ----- //

// Retorna todos os Produtos
function ctrlGetProds() {
    $resp = getProds();
    toJSON($resp);
}
// Retorna um Produto
function ctrlGetProd() {
    extract($_POST);
    $id_product = htmlspecialchars($id_product);
    $resp = getProd($id_product);
    toJSON($resp);
}
// Busca em Produtos -- Em manutenção
function ctrlSearchProds() {
    extract($_POST);
    $search = htmlspecialchars($search);
    $active = htmlspecialchars($active);
    $resp = searchProds($search, $active);
    toJSON($resp);
}
// Cadastra um Produto
function ctrlRegProd() {
    if (checkUser()) {
        extract($_POST);
        if (isset($name,$value,$description,$id_group)) {
            $name = htmlspecialchars($name);
            $value = htmlspecialchars($value);
            $description = htmlspecialchars($description);
            $id_group = htmlspecialchars($id_group);
            $insert = regProd($name,$value,$description,$id_group);
            if ($insert) {
                $id_product = getLastInsertedID();
                $resp["id_product"] = $id_product;
                $resp["product"] = getProd($id_product);
                $resp["reg_product"] = true;
            } else {
                $resp["reg_product"] = false;
            }
            toJSON($resp);
        }
    }
}
// Atualiza um produto
function ctrlUpdProd() {
    if (checkUser()) {
        extract($_POST);
        if (isset($id_product,$name,$value,$description,$id_group,$active)){
            $id_product = htmlspecialchars($id_product);
            $name = htmlspecialchars($name);
            $value = htmlspecialchars($value);
            $description = htmlspecialchars($description);
            $id_group = htmlspecialchars($id_group);
            $active = htmlspecialchars($active);
            $active = toBool($active);
            if(is_object(getProd($id_product))) {
                // verificar o grupo
                $update = updProd($id_product,$name,$value,$description,$id_group,$active);
                if ($update) {
                    $resp["product"] = getProd($id_product);
                    $resp["upd_product"] = true;
                } else {
                    $resp["upd_product"] = false;
                }
            } else {
                $resp["upd_product"] = false;
                $resp["message"] = "Product does not exist";
            }
        } else {
            $resp["upd_product"] = false;
            $resp["message"] = "Undefined Variable for Product ID and/or Name and/or Value and/or Description and/or Group ID and/or Active";
        }
        toJSON($resp);
    }
}
// RESTRITA Altera o produto para ativo ou inativo
function ctrlActiveInactivateProd() {
    if (checkUser()) {
        extract($_POST);
        if (isset($id_product)) {
            $id_product = htmlspecialchars($id_product);
            $prod = getProd($id_product);
            if (toBool($prod->active)) {
                activeInactiveProd($id_product,false);
            } else {
                activeInactiveProd($id_product,true);
            }
            $resp = getProd($id_product);
        } else {
            $resp['activeInactivate'] = false;
            $resp["message"] = "Undefined Variable for Product";
        }
        toJSON($resp);
    }
}
// RESTRITA Deleta um produto.
function ctrlDelProd() {
    if(checkUser()) {
        extract($_POST);
        if (isset($id_product)) {
            $id_product = htmlspecialchars($id_product);
            $resp['del_product'] = delProd($id_product);
        } else {
            $resp['del_product'] = false;
            $resp["message"] = "Undefined Variable for Product";
        }
        toJSON($resp);
    }
}

// ---------- ---------- ---------- ---------- ---------- //

// ----- Imagens ----- //

// RESTRITA Salva a imagem e referencia ela ao produto
function ctrlAddProdImage() {
    if (checkUser()) {
        extract($_FILES);
        extract($_POST);
        if (isset($prodImage,$id_product)) {
            $id_product = htmlspecialchars($id_product);
            $prod = getProd($id_product);
            if (is_object($prod)) {
                if(checkImage($prodImage)){
                    $fileName = renameResizeAndSaveImage($prodImage);
                    $regImage = dbRegProdImage($id_product,$fileName);
                    $resp["add_image"] = $regImage;
                } else {
                    $resp["add_image"] = false;
                    $resp["message"] = "Image is not valid";
                }
            } else {
                $resp["add_image"] = false;
                $resp["message"] = "Product does not exist";
            }
        } else {
            $resp["add_image"] = false;
            $resp["message"] = "Undefined Variable for Product and/or Image";
        }
        toJSON($resp);
    }
}
// IRRESTRITA Retorna as imagens se houver produto ou imagem
function ctrlGetProdImages(){
    extract($_POST);
    $id_product = htmlspecialchars($id_product);
    if (isset($id_product)) {
        $prod = getProd($id_product);
        if (is_object($prod)) {
            $images = getProdImages($id_product);
            $resp['product'] = true;
            if(!empty($images)){
                $resp['get_images'] = true;
                $resp['images'] = $images;
            } else {
                $resp['get_images'] = false;
                $resp["message"] = "There is no Image for this Product";
                $resp['images'] = null;
            }
        } else {
            $resp['get_images'] = false;
            $resp["message"] = "The Product does not exist";
            $resp['images'] = null;
        }
    } else {
        $resp["get_images"] = false;
        $resp["message"] = "Undefined Variable for Product";
        $resp['images'] = null;
    }
    toJSON($resp);
}
// RESTRITA Deleta uma imagen se houver registro da imagem
function ctrlDelProdImage() {
    if (checkUser()) {
        extract($_POST);
        $id_image = htmlspecialchars($id_image);
        if (isset($id_image)) {
            $image = getProdImage($id_image);
            if (is_object($image)) {
                delImageFile($image->address);
                $resp['del_image'] = delProdImage($id_image);
            } else {
                $resp['del_image'] = false;
                $resp["message"] = "The Image does not exist";
            }
        } else {
            $resp['del_image'] = false;
            $resp["message"] = "Undefined Variable for Image";
        }
        toJSON($resp);
    }
}

// ---------- ---------- ---------- ---------- ---------- //
