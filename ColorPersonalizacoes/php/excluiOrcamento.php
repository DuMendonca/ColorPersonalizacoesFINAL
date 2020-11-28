<?php
	$codigo=$_POST['excluiOrcamento'];
	require_once("conexaoBanco.php");
	$comando="SELECT codigo FROM ordens_de_servicos WHERE orcamentos_codigo=".$codigo;
	$resultado=mysqli_query($conexao,$comando);
	$linhas=mysqli_num_rows($resultado);
	if($linhas==0){
		$comando2="DELETE FROM orcamentos_tem_produtos WHERE orcamentos_codigo=".$codigo;
		$resultado2=mysqli_query($conexao,$comando2);
		if($resultado2){
			$comando3="DELETE FROM orcamentos WHERE codigo=".$codigo;
			$resultado3=mysqli_query($conexao,$comando3);
			if($resultado3){
				header("Location: orcamentoForm.php?retorno=1");
			}else{
				header("Location: orcamentoForm.php?retorno=0");
			}
		}else{
			header("Location: orcamentoForm.php?retorno=0");
		}
	}else{
		header("Location: orcamentoForm.php?retorno=2");
	}
?>