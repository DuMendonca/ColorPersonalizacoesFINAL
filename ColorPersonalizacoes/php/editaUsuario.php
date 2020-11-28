<?php
require_once("conexaoBanco.php");

$codigo  = $_POST['codigo'];
$email  = $_POST['email'];
$senha  = $_POST['senha'];
$nome   = $_POST['nome'];
$nivel  = $_POST['nivel'];
if ($senha==""){
  $comando = "UPDATE usuarios SET email = '".$email."', nivel = ".$nivel.", nome_func = '".$nome."' WHERE usuarios.codigo = ".$codigo;
}else{
  $comando = "UPDATE usuarios SET email = '".$email."',senha = MD5('".$senha."'), nivel = ".$nivel.", nome_func = '".$nome."' WHERE usuarios.codigo = ".$codigo;
}
$resultado=mysqli_query($conexao,$comando);
if($resultado==true){
  header("location: registroUsuarioForm.php?retorno=1");
}else {
  header("location: registroUsuarioForm.php?retorno=0");
}
?>
