<?php
	require_once("conexaoBanco.php");
	$comando = "UPDATE orcamentos SET status=3 WHERE codigo=".$_POST['reprovaOrcamento'];
	$resultado=mysqli_query($conexao,$comando);
	if($resultado){
		header("Location: orcamentoForm.php?retorno=1");
	}else{
		header("Location: orcamentoForm.php?retorno=0");
	}
?>