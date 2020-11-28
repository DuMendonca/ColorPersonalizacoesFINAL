<?php
require_once("conexaoBanco.php");

$codigo  = $_POST['excluiUsuario'];

$comando = "DELETE FROM usuarios WHERE codigo=".$codigo;
$resultado=mysqli_query($conexao,$comando);

if($resultado){
	header("Location: registroUsuarioForm.php?retorno=1");
}else {
	$erro=mysqli_errno($conexao);
	if ($erro==1451){
		header("Location: registroUsuarioForm.php?retorno=2");
	}else{
		header("Location: registroUsuarioForm.php?retorno=0");
	}
}
 ?>
