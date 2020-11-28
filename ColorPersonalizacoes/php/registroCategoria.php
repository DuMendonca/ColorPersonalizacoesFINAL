<?php

require_once("conexaoBanco.php");

$nome=$_POST['nome'];
$descricao=$_POST['descricao'];

$comando="INSERT INTO categorias (nome, descricao) VALUES ('".$nome."', '".$descricao."')";
$resultado=mysqli_query($conexao,$comando);

if($resultado==true){

  header("Location: registroCategoriaForm.php?retorno=1");
}else{

  header("Location: registroCategoriaForm.php?retorno=0");
}




 ?>
