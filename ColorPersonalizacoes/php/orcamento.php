<?php
session_start();

require_once("conexaoBanco.php");

$clientes       = $_POST['clientes'];
$parcelas = $_POST['parcelas'];
if ($parcelas==null){
  $parcelas = 0;
}
$localEntrega  = $_POST['localEntrega'];
$dataEmissao  = date('Y-m-d');
$desconto  = $_POST['desconto'];
if ($desconto==null){
  $desconto = 0;
}
$valorTotal  = $_POST['valorTotal'];
$idUsuario  = $_SESSION['idLogado'];

$produtos    = array();
$produtos    = $_POST['produtos'];
$especifica  = array();
$especifica  = $_POST['especifica'];
$vlUnitarios = array();
$vlUnitarios = $_POST['valoresUnitarios'];
$qtdes       = array();
$qtdes       = $_POST['qtdeProduto'];


$comando ="INSERT INTO orcamentos (parcelas, local_entrega, desconto, data_emissao, clientes_id, usuarios_codigo, status, valor_total) VALUES
          (".$parcelas.", '".$localEntrega."', '".$desconto."', '".$dataEmissao."', ".$clientes.", ".$idUsuario.", 1, '".$valorTotal."');";
$resultado = mysqli_query($conexao, $comando);

$comando2= "SELECT MAX(codigo) as codigoOrcamento FROM orcamentos";
$resultado2 = mysqli_query($conexao, $comando2);

$idOrcamento = mysqli_fetch_assoc($resultado2);

$resultado3 = null;
for($i=0; $i < sizeof($produtos); $i++){
  $comando3 = "INSERT INTO orcamentos_tem_produtos (orcamentos_codigo, produtos_codigo, preco_atual, quantidade, especificacao) VALUES
  (".$idOrcamento['codigoOrcamento'].",".$produtos[$i].", '".$vlUnitarios[$i]."', ".$qtdes[$i].", '".$especifica[$i]."');";
  echo $comando3;

  $resultado3 = mysqli_query($conexao, $comando3);

}
if($resultado3==true){

header("Location: orcamentoForm.php?retorno=1");

}else{

header("Location: orcamentoForm.php?retorno=0");

}
?>
