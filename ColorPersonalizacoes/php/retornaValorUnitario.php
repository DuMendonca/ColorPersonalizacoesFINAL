<?php

require_once("conexaoBanco.php");

$id = $_POST['id'];

$comando="SELECT preco_unitario FROM produtos WHERE codigo=".$id;
$resultado=mysqli_query($conexao, $comando);
$precoUnitario=array();
$precoUnitario=mysqli_fetch_assoc($resultado);

 ?>

 <?=$precoUnitario['preco_unitario'];?>
