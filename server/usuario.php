<?php
use Conexao as Con;

class Usuario extends Con
{
    private $cod;
    private $email;
    private $senha;
    private $nome;
    private $token;
    private $status;

    public function setDados($nome,$email,$senha)
    {
        $this->nome = htmlentities($nome);
        $this->email = htmlentities($email);
        $this->senha = sha1(htmlentities($senha));
    }

    public function cadUsuario()
    {
        if ($this->verifUsuario() == '0') {
            $this->token = sha1(uniqid());
            $sql = 'INSERT INTO `usuario` (`nome`,`email`,`senha`,`token`) VALUES (:nome,:email,:senha,:token)';
            $cmd = Con::getPDO()->prepare($sql);
            $cmd->bindParam(':nome',$this->nome);
            $cmd->bindParam(':email',$this->email);
            $cmd->bindParam(':senha',$this->senha);
            $cmd->bindParam(':token',$this->token);
            $cmd->execute();
            $this->cod = Con::getPDO()->lastInsertId();
            echo 'Usuario Cadastrado<br>';
            echo 'Clique no link enviado ao e-mail para confirmar seu cadastro';
        } else {
            echo 'Email já cadastrado!';
        }
    }
    
    public function verifUsuario()
    {
        $sql = 'SELECT COUNT(*) FROM `usuario` WHERE `email` = :email';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->execute();
        $src = $cmd->fetchColumn();
        return $src;
    }

    public function logUsuario()
    {
        $sql = 'SELECT * FROM `usuario` WHERE `email`=:email AND `senha`=:senha AND `deletado` = false';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':senha',$this->senha);
        $cmd->execute();
        $usuario = $cmd->fetch(PDO::FETCH_OBJ);
        $this->cod = $usuario->cod;
        $this->email = $usuario->email;
        $this->senha = $usuario->senha;
        $this->nome = $usuario->nome;
        $this->token = $usuario->token;
        $this->status = $usuario->status;
    }

    public function getUsuarios()
    {
        $sql = 'SELECT * FROM `usuario`';
        if (Con::getPDO()->exec($sql)) {
            $usuarios = $cmd->fetchAll(PDO:: FETCH_OBJ);
            // Exibe todos os usuarios
        }
    }

    public function confUsuario()
    {
        $sql = 'UPDATE `usuario` SET `status` = "Comfirmado" WHERE `email`=:email AND `token`=:token';
        $cmd = Con::getPDO()->prepare($sql);
        $cmd->bindParam(':email',$this->email);
        $cmd->bindParam(':token',$this->token);
        if ($cmd->execute()){
            echo 'Usuario confirmado!';
        }
        //redirecionar usuario para a tela de logon
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
