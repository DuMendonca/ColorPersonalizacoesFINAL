<?php
	require_once("conexaoBanco.php");
	$email = $_POST['email'];
	$comando="SELECT email FROM usuarios WHERE email = '".$email."'";
	$resultado=mysqli_query($conexao, $comando);
	$linhas=mysqli_num_rows($resultado);

	if($linhas==1){
		ini_set('default_charset','UTF-8');
		$codigo=uniqid ( time () );
		session_start();
		$_SESSION['codigoSenha']=md5("#@zz".$codigo);
		$_SESSION['emailC']=md5("#@zz".$email);
		$_SESSION['email']=$email;
		require_once("PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail -> isSMTP();
		$mail -> Host='smtp.gmail.com';
		$mail -> Port=587;
		$mail -> SMTPSecure='tls';
		$mail -> SMTPAuth=true;
		$mail -> Username="colorPersonaliza2019@gmail.com";
		$mail -> Password="color@2019";
		$nome = "ColorPersonalização";
		$nome = '=?UTF-8?B?'.base64_encode($nome).'?=';
		$mail-> setFrom("colorPersonaliza2019@gmail.com", $nome);
		$mail-> addAddress($email);
		$mail-> Subject="Codigo para redefinir senha";
		$mail-> msgHTML("
		  <h1>Mensagem</h1>
		   Código: <b>".$codigo."</b><br>
		   Caso não você não tenha feito pedido de redefinição de senha contato um administrador.
		");

		if($mail->send()==true){ 
			header("Location: redefinirSenhaFormC.php"); 
		}else{
			unset($_SESSION['codigoSenha']);
			unset($_SESSION['emailC']);
			unset($_SESSION['email']);
			header("Location: redefinirSenhaForm.php?retorno=0"); //Erro ao enviar o email!
		}
	}else{
		header("Location: redefinirSenhaForm.php?retorno=1"); //Nenhum email encontrado!
	}
?>