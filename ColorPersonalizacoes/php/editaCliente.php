<?php
require_once("conexaoBanco.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpfCnpj = $_POST['cpfCnpj'];
$email = $_POST['email'];
$inscricaoEstadual = $_POST['inscricaoEstadual'];
$tel1 = $_POST['tel1'];
$tel1 = preg_replace("/[^0-9]/", "" , $tel1);
$tel2 = $_POST['tel2'];
$tel2 = preg_replace("/[^0-9]/", "" , $tel2);
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
if (strlen($cpfCnpj) == 11) {
	$comando = "UPDATE clientes SET nome='".$nome."', tel1=".$tel1.", tel2=".$tel2.", email='".$email."', rua='".$rua."', bairro='".$bairro."', cidade='".$cidade."', numero=".$numero.", cpf=".$cpfCnpj.", estado='".$estado."', cep=".$cep.", inscricao_estadual=".$inscricaoEstadual." WHERE id=".$id;
}elseif (strlen($cpfCnpj) == 14) {
	$comando = "UPDATE clientes SET nome='".$nome."', tel1=".$tel1.", tel2=".$tel2.", email='".$email."', rua='".$rua."', bairro='".$bairro."', cidade='".$cidade."', numero=".$numero.", cnpj=".$cpfCnpj.", estado='".$estado."', cep=".$cep.", inscricao_estadual=".$inscricaoEstadual." WHERE id=".$id;
}

$resultado = mysqli_query($conexao, $comando);

if ($resultado == true) {
	header("Location:registroClienteForm.php?retorno=1");
}else{
	header("Location:registroClienteForm.php?retorno=0");
}
?>
