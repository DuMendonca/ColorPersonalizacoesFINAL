<?php
require_once("conexaoBanco.php");

//pegando os dados de registro
$email  = $_POST['email'];
$senha  = $_POST['senha'];
$nome   = $_POST['nome'];
$nivel  = $_POST['nivel'];

$comando  = "INSERT INTO usuarios (email, senha, nivel, nome_func) VALUES ('".$email."', MD5('".$senha."'), ".$nivel.",'".$nome."')";

$resultado = mysqli_query($conexao,$comando);
if($resultado==true){
  header("location: registroUsuarioForm.php?retorno=1");
}else{
  header("location: registroUsuarioForm.php?retorno=0");
}
 ?>
