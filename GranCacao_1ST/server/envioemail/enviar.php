<?php 
$mensagem = "<h2> Aula de Desenvolvimento de Software II</h2>
Professor: <b>Giovanni Guarnieri</b><br>
Este é um email de teste.<br>
Att, Biazinha<br>
<i>Etec Sales Gomes</i>";
// Variável que junta os valores acima e monta o corpo do email
require_once("phpmailer/class.phpmailer.php");

define('EMAIL', '');  // <-- Insira aqui o seu GMail
define('SENHA', '');    // <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
  global $error;
  $mail = new PHPMailer();
  $mail->CharSet = 'UTF-8';
  $mail->IsSMTP();    // Ativar SMTP
  $mail->SMTPDebug = 0;   // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
  $mail->SMTPAuth = true;   // Autenticação ativada
  $mail->SMTPSecure = 'ssl';  // SSL REQUERIDO pelo GMail
  $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
  $mail->Port = 465;      // A porta 587 deverá estar aberta em 
  $mail->IsHTML(true);
  $mail->Username = EMAIL;
  $mail->Password = SENHA;
  $mail->SetFrom($de);
  $mail->Subject = $assunto;
  $mail->Body = $corpo;  
  $mail->AddAddress($para);
  if(!$mail->Send()) {
    $error = 'Mail error: '.$mail->ErrorInfo; 
    return false;
  } else {
    echo "Mensagem Enviada";
    return true;
  }
}
smtpmailer('emaildestino', 'emailorigem', 'Nome Origem', ' TÍTULO EMAIL ', $mensagem);

 ?>