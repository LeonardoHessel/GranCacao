<?php

//Importando PHP Mailer
require_once("envioemail/phpmailer/class.phpmailer.php");

class Email{
        private $emaildestino;
        private $emailorigem;
        private $assunto;
        private $conteudo;
        private $senhaorigem;
        private $nomeorigem;
        
        public function __construct($emaildestino, 
                        $emailorigem, $assunto, $conteudo, 
                        $senhaorigem, $nomeorigem){
            $this->emaildestino = $emaildestino;
            $this->emailorigem = $emailorigem;
            $this->assunto = $assunto;
            $this->conteudo = $conteudo;
            $this->senhaorigem = $senhaorigem;
            $this->nomeorigem = $nomeorigem;
        }
        public function enviar(){
            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->IsSMTP();    // Ativar SMTP
            $mail->SMTPDebug = 0;   // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
            $mail->SMTPAuth = true;   // Autenticação ativada
            $mail->SMTPSecure = 'ssl';  // SSL REQUERIDO pelo GMail
            $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
            $mail->Port = 465;      // A porta 587 deverá estar aberta em 
            $mail->IsHTML(true);
            $mail->Username = $this->emailorigem;
            $mail->Password = $this->senhaorigem;
            $mail->SetFrom($this->emailorigem);
            $mail->Subject = $this->assunto;
            $mail->Body = $this->conteudo;  
            $mail->AddAddress($this->emaildestino);
            var_dump($mail->Send());
            echo $mail->ErrorInfo;
        }
    }
?>