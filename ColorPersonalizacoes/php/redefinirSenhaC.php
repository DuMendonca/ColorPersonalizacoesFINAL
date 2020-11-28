<?php
	session_start();
	if($_SESSION['codigoSenha']==md5("#@zz".$_POST['codigoIns'])){
		if($_SESSION['emailC']==md5("#@zz".$_SESSION['email'])){
			header("Location: redefinirSenhasForm.php");
		}else{ //email errado!
			header("Location: redefinirSenhaFormC.php?retorno=0");
		}
	}else{ //codigo errado!
		header("Location: redefinirSenhaFormC.php?retorno=1");
	}
	
?>