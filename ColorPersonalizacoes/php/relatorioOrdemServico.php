<?php
  session_start();
  if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/relatorioOrdemServico.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/relatorioOrdemServico.js"></script>
</head>
<body>

<?php
  include("menuAdm.php");
?>

<section id="relatorioOrdem">
  <h1>Relatório de ordem de serviço</h1>
</section>


<main id="conteudoPrincipal">
  <div class="divs" id="divFiltro">
    <fieldset id="fieldFiltro">
      <legend >Filtro</legend>
      <form action="#" method="GET" id="formFiltro" onsubmit="return validarCampos()">
        <label class="campos" for="selectClientes" id="filtroClientes" >Clientes:</label>
        <select id="selectClientes" name="cliente">
          <option value="">Selecione...</option>
           <?php
            require_once("conexaoBanco.php");
            $comando = "SELECT id, nome FROM clientes";
            $resultado = mysqli_query($conexao, $comando);
            $clientes = array();
            while ($cadaCli = mysqli_fetch_assoc($resultado)) {
              array_push($clientes, $cadaCli);
            }
            foreach ($clientes as $cadaCli) {
              ?>
              <option value="<?= $cadaCli['id'];?>">
                <?= $cadaCli['nome'];?>
              </option>
              <?php
            }
          ?>
        </select>

        <label  class="campos" for="dataInicialFiltro" id="filtroDataInicial">Data Inicial</label>
        <input class ="camposForm" type="date" name="dataInicial" id="dataInicialFiltro">

        <label class="campos" for="dataFinalFiltro" id="filtroDataFinal">Data Final</label>
        <input class="camposForm" type="date" name="dataFinal" id="dataFinalFiltro">

        <label class="campos" for="selectFuncionarios" id="filtroFuncionario">Funcionário responsável:</label>
        <select id="selectFuncionarios" name="func">
          <option value="">Selecione...</option>
          <?php
            $comando2 = "SELECT codigo, nome_func FROM usuarios WHERE nivel=2;";
            $resultado2=mysqli_query($conexao,$comando2);
            $funcionarios = array();
            while ($cadaFunc = mysqli_fetch_assoc($resultado2)){
                  array_push($funcionarios, $cadaFunc);
            }
            foreach ($funcionarios as $cadaFunc) {
          ?>
          <option value="<?=$cadaFunc['codigo'];?>">
            <?=$cadaFunc['nome_func'];?>
          </option>
          <?php
            }

           ?>
        </select>

        <label class="campos" for="selectStatus" id="filtroStatus">Status:</label>
        <select id="selectStatus" name="status">
          <option value="0">Selecione...</option>
          <option value="1">Em andamento</option>
          <option value="2">Finalizada</option>
        </select><br>

        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão limpa campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonGerar.png" alt="Botão para gerar o relatorio ">
        </button>
      </form>
    </fieldset>
  </div>
  <div class="divs" id="divRelatorio">
    <fieldset id="fieldRelatorio">
    <legend>Relatório</legend>
      <table>
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Valor total</th>
          <th>Funcionário responsável</th>
          <th>Produtos</th>
        </tr>
        <?php
          if (isset($_GET['cliente']) && isset($_GET['dataInicial']) && isset($_GET['dataFinal']) && isset($_GET['func']) && isset($_GET['status'])) {
           $idCliente = $_GET['cliente'];
           $dataInicial = $_GET['dataInicial'];
           $dataFinal = $_GET['dataFinal'];
           $dataAtual = date('Y-m-d');
           $dataMinima   = '2000-01-01';
           $idFunc = $_GET['func'];
           $status = $_GET['status'];

           //N N N N 0
           if ($idCliente=="" && $dataInicial=="" && $dataFinal=="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo";
           }
           //S N N N 0
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal=="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE cli.id=".$idCliente;
           }
           //S S N N 0
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal=="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND cli.id=".$idCliente;
           }
           //S S S N 0
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal!="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND cli.id=".$idCliente;
           }
           //S S S S 0
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal!="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND cli.id=".$idCliente;
           }
           //S S S S S
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal!="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //S S S N S
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal!="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //S S N S S
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal=="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND usu.codigo=".$idFunc." AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //S N S S S
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal!="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //N S S S S
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal!="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND od.status=".$status;
           }
           //N N S S S
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal!="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND od.status=".$status;
           }
           //N N N S S
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal=="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE usu.codigo=".$idFunc." AND od.status=".$status;
           }
           //N N N N S
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal=="" && $idFunc=="" && $status!="0") {
              $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.status=".$status;
           }
           //N N S N S
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal!="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND od.status=".$status;
           }
           //N S N N S
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal=="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND od.status=".$status;
           }
           //S N N N S
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal=="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE cli.id=".$idCliente." AND od.status=".$status;
           }
           //S S N N S
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal=="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //N N S S 0
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal!="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND usu.codigo=".$idFunc;
           }
           //N S S N 0
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal!="" && $idFunc=="" && $status=="0") {
            $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."'";
           }
           //N S N N 0
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal=="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."'";
           }
           //N N S N 0
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal!="" && $idFunc=="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."'";
           }
           //N N N S 0
           elseif ($idCliente=="" && $dataInicial=="" && $dataFinal=="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE usu.codigo=".$idFunc;
           }
           //S N S N 0
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal!="" && $idFunc=="" && $status=="0") {
              $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND cli.id=".$idCliente;
           }
           //S N N S 0
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal=="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE cli.id=".$idCliente." AND usu.codigo=".$idFunc;
           }
           //S N S S 0
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal!="" && $idFunc!="" && $status=="0") {
            $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND usu.codigo=".$idFunc." AND cli.id=".$idCliente;
           }
           //N S N S 0
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal=="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND usu.codigo=".$idFunc;
           }
           //N S S S 0
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal!="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND usu.codigo=".$idFunc;
           }
           //S N S N S
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal!="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND od.status=".$status." AND cli.id=".$idCliente;
           }
           //S S N S 0
           elseif ($idCliente!="" && $dataInicial!="" && $dataFinal=="" && $idFunc!="" && $status=="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND usu.codigo=".$idFunc." AND cli.id=".$idCliente;
           }
           //N S S N S
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal!="" && $idFunc=="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND od.status=".$status;
           }
           //S N N S S
           elseif ($idCliente!="" && $dataInicial=="" && $dataFinal=="" && $idFunc!="" && $status!="0") {
              $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE cli.id=".$idCliente." AND usu.codigo=".$idFunc." AND od.status=".$status;
           }
           //N S N S S
           elseif ($idCliente=="" && $dataInicial!="" && $dataFinal=="" && $idFunc!="" && $status!="0") {
             $comando = "SELECT od.codigo , usu.nome_func, oc.valor_total, od.data_entrega, pro.nome as nomePro, cli.nome as nomeCli, od.status FROM clientes as cli INNER JOIN orcamentos as oc ON cli.id=oc.clientes_id INNER JOIN orcamentos_tem_produtos as orc ON oc.codigo=orc.orcamentos_codigo INNER JOIN produtos as pro ON orc.produtos_codigo=pro.codigo INNER JOIN ordens_de_servicos as od ON orc.orcamentos_codigo=od.orcamentos_codigo INNER JOIN usuarios as usu ON od.usuarios_codigo=usu.codigo WHERE od.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND od.status=".$status." AND usu.codigo=".$idFunc;
           }
           $resultado = mysqli_query($conexao, $comando);
           $linhas=mysqli_num_rows($resultado);
           if ($linhas == 0) {
             ?>
             <tr>
               <td colspan="5">Nenhuma Ordem de Serviço encontrada!</td>
             </tr>
             <?php
           }else{
            $ordens = array();
              while ($cadaOrd = mysqli_fetch_assoc($resultado)) {
                array_push($ordens, $cadaOrd);
              }
              $html = "";
              foreach ($ordens as $cadaOrd) {
                $html .= "
                  <tr>
                    <td>".$cadaOrd['codigo']."</td>
                    <td>".$cadaOrd['nomeCli']."</td>
                    <td>".$cadaOrd['valor_total']."</td>
                    <td>".$cadaOrd['nome_func']."</td>
                    <td>".$cadaOrd['nomePro']."</td>
                  </tr>
                ";
              }
              echo $html;
           }
          }//fecha primeiro if
        ?>
      </table>
      <br>
       <form action="gerarPdfOrdemServico.php" method="POST">
         <input type="hidden" name="html" value="<?=$html?>">
         <input type="hidden" name="linhas" value="<?=$linhas?>">
         <button type="submit" class="botoes">
            <img  class="botoesImg" src="../imgs/buttonGerarPdf.png">
         </button>
      </form>
   </fieldset>
  </div>
</main>


</body>
</html>

<?php
}else{
  header("Location: /login.php");
}
?>
