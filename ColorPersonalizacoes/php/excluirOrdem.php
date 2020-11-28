<?php
require_once("conexaoBanco.php");

$codigo  = $_POST['excluiOrdem'];
$comandoBuscaCod = "SELECT orcamentos_codigo FROM ordens_de_servicos WHERE codigo=".$codigo.";";
$resultadoBuscaCod = mysqli_query($conexao,$comandoBuscaCod);
$orcamentos = array();
while ($cadaCodigoOrca = mysqli_fetch_assoc($resultadoBuscaCod)){
      array_push($orcamentos, $cadaCodigoOrca);
}foreach ($orcamentos as $cadaCodigoOrca) {
  $codigo_orcamento = $cadaCodigoOrca['orcamentos_codigo'];
}

$comando = "DELETE FROM ordens_de_servicos WHERE codigo=".$codigo;
$resultado=mysqli_query($conexao,$comando);

if($resultado==true){

  $comandoAlteraOrca = "UPDATE orcamentos SET status=1 WHERE codigo=".$codigo_orcamento.";";
	$resultadoAlteraOrca = mysqli_query($conexao,$comandoAlteraOrca);
}

if($resultado){
  header("Location: ordemServicoForm.php?retorno=1");
}else {
  header("Location: ordemServicoForm.php?retorno=0");
}
 ?>
