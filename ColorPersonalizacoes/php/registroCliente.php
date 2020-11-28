<?php
require_once("conexaoBanco.php");

$nome = $_POST["nome"];
$cpfCnpj = $_POST["cpfCnpj"];
$email = $_POST["email"];
$inscricaoEstadual = $_POST["inscricaoEstadual"];
$tel1 = $_POST["tel1"];
$tel1 = preg_replace("/[^0-9]/", "" , $tel1);
$tel2 = $_POST["tel2"];
$tel2 = preg_replace("/[^0-9]/", "" , $tel2);
$rua = $_POST["rua"];
$bairro = $_POST["bairro"];
$numero = $_POST["numero"];
$cidade = $_POST["cidade"];
$estado = $_POST["estado"];
$cep = $_POST["cep"]; 

if ($tel2 == "") {
	$tel2 = 'NULL';
}
if ($inscricaoEstadual == "") {
	$inscricaoEstadual = 'NULL';
}

if (strlen($cpfCnpj) == 11 && $email != "") {
	$comando = "INSERT INTO clientes (nome, tel1, tel2, email, rua, bairro, cidade, numero, cpf, estado, cep, inscricao_estadual) VALUES ('".$nome."', ".$tel1.", ".$tel2.", '".$email."', '".$rua."', '".$bairro."', '".$cidade."', ".$numero.", ".$cpfCnpj.", '".$estado."', ".$cep.", ".$inscricaoEstadual.")";
}elseif (strlen($cpfCnpj) == 14 && $email != "") {
	$comando = "INSERT INTO clientes (nome, tel1, tel2, email, rua, bairro, cidade, numero, cnpj, estado, cep, inscricao_estadual) VALUES ('".$nome."', ".$tel1.", ".$tel2.", '".$email."', '".$rua."', '".$bairro."', '".$cidade."', ".$numero.", ".$cpfCnpj.", '".$estado."', ".$cep.", ".$inscricaoEstadual.")";
}elseif (strlen($cpfCnpj) == 11 && $email == "") {
	$comando = "INSERT INTO clientes (nome, tel1, tel2, rua, bairro, cidade, numero, cpf, estado, cep, inscricao_estadual) VALUES ('".$nome."', ".$tel1.", ".$tel2.", '".$rua."', '".$bairro."', '".$cidade."', ".$numero.", ".$cpfCnpj.", '".$estado."', ".$cep.", ".$inscricaoEstadual.")";
}elseif (strlen($cpfCnpj) == 14 && $email == "") {
	$comando = "INSERT INTO clientes (nome, tel1, tel2, rua, bairro, cidade, numero, cnpj, estado, cep, inscricao_estadual) VALUES ('".$nome."', ".$tel1.", ".$tel2.", '".$rua."', '".$bairro."', '".$cidade."', ".$numero.", ".$cpfCnpj.", '".$estado."', ".$cep.", ".$inscricaoEstadual.")";
}

$resultado = mysqli_query($conexao, $comando);

 if ($resultado == true) {
 	header("Location:registroClienteForm.php?retorno=1");
 }else{
 	header("Location:registroClienteForm.php?retorno=0");
 }

?>