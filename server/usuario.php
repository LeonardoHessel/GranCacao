<?php
use Conexao as Con;

class Usuario extends Con
{
    private $id;
    private $email;
    private $senha;
    private $nome;
    private $token;
    private $status;
    private $del;

    public static function checarCookie($id_user,$token_device){
        $sql = "SELECT COUNT(*) FROM `usuario_dispositivo` WHERE `usuario`=:usuario AND `token`=:token";
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':usuario',$id_user);
        $cmd->bindParam(':token',$token_device);
        $cmd->execute();
        $qtd = $cmd->fetchColumn();
        if ($qtd == '1') {
            return true;
        }
        return false;
    }

    public function definirDados($email,$senha)
    {
        $this->email = htmlentities($email);
        $this->senha = sha1(htmlentities($senha));
    }

    public function cadastrarUsuario()
    {
        if ($this->verificarUsuario() == '0') {
            $this->token = bin2hex(openssl_random_pseudo_bytes(32));
            $sql = 'INSERT INTO `usuario` (`email`,`senha`,`token`) 
                VALUES (:email,:senha,:token)';
            $cmd = Con::getPDO()->prepare($sql);
            $cmd->bindParam(':email',$this->email);
            $cmd->bindParam(':senha',$this->senha);
            $cmd->bindParam(':token',$this->token);
            $cmd->execute();
            $response['cadastro_status'] = true;
            $response['mesage'] = "Cadastro realizado com sucesso.";
            return $response;
        } else {
            $response['cadastro_status'] = false;
            $response['mesage'] = 'E-mail já cadastrado.';
            return $response;
        }
    }
    
    public function verificarUsuario()
    {
        $sql = 'SELECT COUNT(*) FROM `usuario` WHERE `email` = :email';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->execute();
        $src = $cmd->fetchColumn();
        return $src;
    }

    public function logarUsuario()
    {
        $sql = 'SELECT `id`,`email`,`nome`,`status` FROM `usuario` WHERE `email`=:email AND `senha`=:senha AND `del` = false';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_OBJ);
    }

    public function confirmarUsuario($email,$token)
    {
        $this->email = htmlentities($email);
        $this->token = htmlentities($token);
        $sql = 'UPDATE `usuario` SET `status` = "Confirmado" WHERE `email`=:email AND `token`=:token';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':token',$this->token);
        if ($cmd->execute()) {
            $sql = 'SELECT COUNT(*) FROM `usuario` WHERE `email`=:email AND `token`=:token AND `status` = "Confirmado"';
            $cmd = Con::getPDO()->prepare($sql);
            $cmd->bindParam(':email',$this->email);
            $cmd->bindParam(':token',$this->token);
            if ($cmd->execute()) {
                $teste = $cmd->fetch(PDO::FETCH_ASSOC);
                if (intval($teste) == 1) {
                    echo "Sucesso";
                    var_dump($teste);
                } else {
                    echo "falso QTD";
                    var_dump($teste);
                }
            } else {
                echo "falso SEL";
            }
        }
        else{
            echo "falso UPD";
        }
    }

    public function atualUsuario()
    {
        $sql = 'UPDATE FROM `usuario` SET `email`= :email, `senha`=:senha, `nome`=:nome WHERE `cod`=:cod';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':cod',$this->cod);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        $cmd->bindParam(':nome',$this->nome);
        if ($cmd->execute()) {
            // cadastro excluido com sucesso
        }
    }

    public function delUsuario()
    {
        $sql = 'UPDATE FROM `usuario` SET `deletado`= true WHERE `cod`=:cod';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':cod',$this->cod);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        if ($cmd->execute()) {
            // cadastro excluido com sucesso
        }
    }
}
