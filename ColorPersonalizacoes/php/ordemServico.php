<?php
require_once("conexaoBanco.php");
$dtEntrega        = $_POST['dataEntrega'];
$dtEmissao        = date('Y-m-d');
$codigo_orcamento = $_POST['orcamento'];
$codigo_usuario   = $_POST['funcExecutor'];

$comando = "INSERT INTO ordens_de_servicos (data_entrega, data_emissao, status, orcamentos_codigo, usuarios_codigo) VALUES ('".$dtEntrega."', '".$dtEmissao."', 1, ".$codigo_orcamento.", ".$codigo_usuario.")";
$resultado=mysqli_query($conexao,$comando);

if($resultado==true){
	$comandoAlteraOrca = "UPDATE orcamentos SET status=2 WHERE codigo=".$codigo_orcamento.";";
	$resultadoAlteraOrca = mysqli_query($conexao,$comandoAlteraOrca);
}

if($resultado==true){
	header("Location: ordemServicoForm.php?retorno=1");
}else {
	header("Location: ordemServicoForm.php?retorno=0");
}
 ?>
