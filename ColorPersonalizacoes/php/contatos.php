<?php
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$catMensagem = $_POST['radio'];
$mensagem = $_POST['mensagem'];

switch ($catMensagem) {
  case 1:
     $catMensagem="Crítico";
    break;
  case 2:
    $catMensagem="Duvida";
    break;
  case 3:
    $catMensagem="Sugestão";
    break;
  case 4:
     $catMensagem="Orçamento";
    break;
}

require_once("PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail -> isSMTP();
$mail -> Host='smtp.gmail.com';
$mail -> Port=587;
$mail -> SMTPSecure='tls';
$mail -> SMTPAuth=true;
$mail -> Username="colorPersonaliza2019@gmail.com";
$mail -> Password="color@2019";

$mail-> setFrom("colorPersonaliza2019@gmail.com", "E-mail do sistema");
$mail-> addAddress("colorPersonaliza2019@gmail.com");
$mail-> Subject="Mensagem para Color";
$mail-> msgHTML("
  <h1>Mensagem</h1>
   Categoria da Mensagem: ".$catMensagem.".<br>
   Cliente: ".$nome.".<br>
   Telefone: ".$telefone.".<br>
   Email: ".$email.".<br>
   Mensagem: ".$mensagem.".<br>
");


if($mail->send()==true){
  header("Location: contatosForm.php?retorno=1");
}else{
  header("Location: contatosForm.php?retorno=0");
}


 ?>
