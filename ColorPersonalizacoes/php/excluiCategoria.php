<?php

require_once("conexaoBanco.php");

$codigo = $_POST['excluiCategoria'];

$comando = "DELETE FROM categorias WHERE codigo=".$codigo;
$resultado=mysqli_query($conexao, $comando);
$erro=mysqli_errno($conexao);
if($resultado==true){

  header("Location: registroCategoriaForm.php?retorno=1");
}else{
	if ($erro==1451){
		header("Location: registroCategoriaForm.php?retorno=2");
	}else{
		header("Location: registroCategoriaForm.php?retorno=0");
	}
}
?>
