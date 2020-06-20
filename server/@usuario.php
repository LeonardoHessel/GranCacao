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

    public function definirDados($email,$senha)
    {
        $this->email = htmlentities($email);
        $this->senha = sha1(htmlentities($senha));
    }

    // Cadastra un novo usuário.
    public function cadastrarUsuario()
    {
        $this->token = bin2hex(openssl_random_pseudo_bytes(32));
        $sql = 'INSERT INTO `usuario` (`email`,`senha`,`token`)
                VALUES (:email,:senha,:token)';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        $cmd->bindParam(':token',$this->token);
        return $cmd->execute();
    }
    
    // Verifica se email já está cadastrato.
    public function verificarUsuario()
    {
        $sql = 'SELECT COUNT(*) FROM `usuario` WHERE `email` = :email';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->execute();
        $src = $cmd->fetchColumn();
        return $src;
    }

    // Cria cookies e token para o dispositivo.
    public function gerarTokenDevice($id_user)
    {
        $sql = "INSERT INTO `usuario_dispositivo` VALUES (:id_user,:token_device,DATE(DATE_ADD(NOW(), INTERVAL 7 DAY)))";
        $token_device = bin2hex(openssl_random_pseudo_bytes(32));
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':id_user',$id_user);
        $cmd->bindParam(':token_device',$token_device);
        $cmd->execute();
        setcookie('device',$token_device, time() + (86400 * 7), "/");
        setcookie('user',$id_user, time() + (86400 * 7), "/");
    }

    // Verifica a validade dos cookies.
    public static function checarCookie($id_user,$token_device){
        $sql = "SELECT * FROM `usuario_dispositivo` WHERE `usuario`= :usuario AND `token`= :token AND `validade` > DATE(NOW())";
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

    // Loga o usuario.
    public function logarUsuario()
    {
        $sql = 'SELECT `id`,`email`,`nome`,`status` FROM `usuario` WHERE `email`=:email AND `senha`=:senha AND `del` = false';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        $cmd->execute();
        $user = $cmd->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    // Confirma o usuário atravez do email.
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

    // Atualiza as informações do usuario.
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

    // Deleta o usuario. ------------ Alterar Para // Deleta as informações do usuário e inativa a conta.
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
