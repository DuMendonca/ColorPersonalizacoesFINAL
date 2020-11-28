<?php
	session_start();
		if($_SESSION['emailC']==md5("#@zz".$_SESSION['email'])){
			if($_POST['senhaNova']==$_POST['senhaConfirma']){
				require_once("conexaoBanco.php");
				$comando="UPDATE usuarios SET senha='".md5($_POST['senhaNova'])."' WHERE email='".$_SESSION['email']."'";
				$resultado=mysqli_query($conexao,$comando);
				if($resultado){
					session_start();
					unset($_SESSION['codigoSenha']);
					unset($_SESSION['emailC']);
					unset($_SESSION['email']);
					header("Location: login.php?retorno=1"); // Senha alterada com sucesso!
				}else{
					header("Location: redefinirSenhasForm.php?retorno=0"); // Erro ao atualizar a senha!
				}
			}else{ //Senhas diferentes!
				header("Location: redefinirSenhasForm.php?retorno=1"); // Senhas diferentes
			}
			
		}else{ //email errado!
			header("Location: redefinirSenhaFormC.php?retorno=1"); //algo deu errado mudaram email !
		}
	
?>