<?php
session_start();
require_once("conexaoBanco.php");

$nivel            = $_SESSION['nivelLogado'];
$codigo           = $_POST['codigo'];
$dtEntrega        = $_POST['dataEntrega'];
$status						= $_POST['status'];


if($nivel==2){
	//Caso for estampador, ele vai fazer esse comando
	$comando = "UPDATE ordens_de_servicos SET status=".$status." WHERE codigo=".$codigo."";
}else if($nivel==3){
	//Caso for gerente, ele vai fazer esse comando
	$comando = "UPDATE ordens_de_servicos SET data_entrega='".$dtEntrega."' WHERE codigo=".$codigo."";
}
$resultado=mysqli_query($conexao,$comando);


if($nivel==3){
	if($resultado){
		header("Location: ordemServicoForm.php?retorno=1");
	}else {
		header("Location: ordemServicoForm.php?retorno=0");
	}
}else if($nivel==2){
	if($resultado){
		header("Location: consultaOrdemServico.php?retorno=1");
	}else {
		header("Location: consultaOrdemServico.php?retorno=0");
	}
}
 ?>
