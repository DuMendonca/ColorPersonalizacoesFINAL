<?php
require_once("conexaoBanco.php");

$id = $_POST['excluiCliente'];

$comando = "DELETE FROM clientes WHERE id=".$id;


$resultado=mysqli_query($conexao,$comando);

if($resultado == true){
  header("Location: registroClienteForm.php?retorno=1");
}else {
	$erro=mysqli_errno($conexao);
  	if ($erro==1451){
		header("Location: registroClienteForm.php?retorno=2");
	}else{
		header("Location: registroClienteForm.php?retorno=0");
	}
}

?>
