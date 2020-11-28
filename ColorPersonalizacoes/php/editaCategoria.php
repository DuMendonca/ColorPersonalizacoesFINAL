<?php

require_once("conexaoBanco.php");

$idCategoria = $_POST['codigo'];
$nome=$_POST['nome'];
$descricao=$_POST['descricao'];


$comando="UPDATE categorias SET nome='".$nome."', descricao='".$descricao."' WHERE codigo=".$idCategoria;


$resultado=mysqli_query($conexao,$comando);

if ($resultado==true) {
  header("Location: registroCategoriaForm.php?retorno=1");
}else{
  header("Location: registroCategoriaForm.php?retorno=0");
}

?>
