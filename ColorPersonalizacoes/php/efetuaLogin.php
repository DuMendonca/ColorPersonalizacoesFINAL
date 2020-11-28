<?php

require_once("conexaoBanco.php");

$email=$_POST['email'];
$senha=$_POST['senha'];

$senha=md5($senha);

$comando="SELECT * FROM usuarios WHERE email='".$email."' AND senha='".$senha."'";

$resultado=mysqli_query($conexao,$comando);
$usuario=mysqli_fetch_assoc($resultado);
$linhas=mysqli_num_rows($resultado);

if($linhas==0){
	header("Location: login.php?retorno=0");
}else{
	session_start();
	$_SESSION['idLogado']=$usuario['codigo'];
	$_SESSION['nomeLogado']=$usuario['nome_func'];
	$_SESSION['nivelLogado']=$usuario['nivel'];
    	header("Location: inicios.php");
}

?>
