<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1){
require_once("conexaoBanco.php");
?>
<?php

function mostraProdutos($conexao){
    $comandoMostrarProdutos = "SELECT * FROM produtos";
    $resultadoMostrarProdutos=mysqli_query($conexao, $comandoMostrarProdutos);
    $produtos=array();

    while($cadaProduto = mysqli_fetch_assoc($resultadoMostrarProdutos)) {
       array_push($produtos, $cadaProduto);
    }
    $options="<option value='0'>Selecione...</option>";
    foreach ($produtos as $cadaProduto) {

        $options.="<option value='".$cadaProduto['codigo']."'>".$cadaProduto['nome']."</option>";
    }
    return $options;
}

 ?>
<input id="todosOsProdutos" type="hidden" value="<?=mostraProdutos($conexao);?>">
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/orcamento.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/orcamentos.js"></script>
</head>
<body>

  <?php
  if ($_SESSION['nivelLogado']==1){
  include("menuAtendente.php");
  }else if ($_SESSION['nivelLogado']==3){
  include("menuAdm.php");
  }
  ?>

<section id="registroOrcamento">
  <h1>Registro de Orçamentos</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Dados do gerais:</legend>
      <form action="orcamento.php" method="POST" id="formCadastro" onsubmit="return validaCampos()">
        <label class="campos" for="clientes">Cliente:</label>
          <select id="clientes" name="clientes">
            <option value="0">Selecione...</option>
            <?php
              $comandoCliente = "SELECT id, nome FROM clientes";
              $resultadoCliente =mysqli_query($conexao,$comandoCliente);
        			$clientes = array();
              while ($cadaCliente = mysqli_fetch_assoc($resultadoCliente)){
                    array_push($clientes, $cadaCliente);
              }
              foreach ($clientes as $cadaCliente) {
            ?>
            <option value="<?=$cadaCliente['id'];?>">
              <?=$cadaCliente['nome'];?>
            </option>
            <?php
              }
             ?>
          </select>
        <label class="campos" for="parcelas">Parcelas:</label>
        <input class="camposForm" type="number" name="parcelas" id="parcelas" min="0" placeholder="Insira o número de parcelas...">
        <br>
        <label class="campos" for="localEntrega">Local de Entrega:</label>
        <input class="camposForm" type="text" name="localEntrega" id="localEntrega" placeholder="Insira o local de entrega...">
        <label class="campos" for="desconto">Desconto:</label>
        <input class="camposForm" type="text" name="desconto" id="desconto" placeholder="Insira o desconto (Se tiver)...">
        <br>
        <label class="campos" for="valorTotal">Valor total</label>
        <input class="camposForm" type="text" id="valorTotal" step="any" value="0.00" name="valorTotal" readonly="readonly" required><br>
        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão para limpar os campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonOrcar.png" alt="Botão para gerar um orçamento">
        </button>
      <div id="div0">
          <label class="campos">Produtos*:</label>
          <select class="camposForm" name="produtos[]" onchange="retornaValorUnitarioProduto(0)" id="produtos0" required>
              <?=mostraProdutos($conexao);?>
          </select>
          <label class="campos">Especificação da Estampa*:</label>
          <input class="camposForm" type="text" name="especifica[]" placeholder="Insira a especificação..." required>

          <label class="campos">Valor unitário*:</label>
          <input class="camposForm" type="text" id="vlUnitario0" name="valoresUnitarios[]" required readonly="readonly">

          <label class="campos">Quantidade*:</label>
          <input class="camposForm" type="number" name="qtdeProduto[]" min="1" onblur="atualizaValorTotal(this.value,0)" id="qtde0" required>
          <button type="button" onclick="adicionaProduto()" class="botoes"><img src="../imgs/plus.png" alt="Botão de mais"></button>
      </div>
      </form>
    </fieldset>
    <fieldset id="fieldConsulta">
      <legend >Consulta de Orçamentos:</legend>
      <form action="orcamentoForm.php" method="GET">
        <label for="consultaNomeCliente" id="labelConsultaNome">Nome do Cliente:</label>
        <input type="text" name="consultaNomeCliente" id="consultaNomeCliente" placeholder="Insira o nome do cliente...">
        <button type="submit">Buscar</button>
      </form>
      <table id="tabelaConsultaOrca">
        <tr>
          <th>Cliente</th>
          <th>Valor Total</th>
          <th>Data de Emissão</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
        <?php
        if(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']==""){
          $comandoConsulta = "SELECT orca.codigo, orca.data_emissao, orca.valor_total, orca.status, cli.nome FROM orcamentos AS orca JOIN clientes AS cli ON orca.clientes_id = cli.id";
        }
        elseif (isset($_GET['consultaNomeCliente'])==false ){
          $comandoConsulta = "SELECT orca.codigo, orca.data_emissao, orca.valor_total, orca.status, cli.nome FROM orcamentos AS orca JOIN clientes AS cli ON orca.clientes_id = cli.id";
        }
        elseif(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']!=""){
          $consultaNomeCliente = $_GET['consultaNomeCliente'];
          $comandoConsulta = "SELECT orca.codigo, orca.data_emissao, orca.valor_total, orca.status, cli.nome FROM orcamentos AS orca JOIN clientes AS cli ON orca.clientes_id = cli.id WHERE cli.nome LIKE '".$consultaNomeCliente."%'";
        }
        $resultadoConsulta =mysqli_query($conexao,$comandoConsulta);
        $linhasConsulta =mysqli_num_rows($resultadoConsulta);
        if($linhasConsulta==0){
        ?>

        <tr><td colspan="6">Nenhum orçamento encontrado!</td></tr>
        <?php
        }else{
          $orcamentos = array();
          while($cadaOrca =mysqli_fetch_assoc($resultadoConsulta)){
            array_push($orcamentos,$cadaOrca);
          }
          foreach($orcamentos as $cadaOrca){
         ?>
        <tr>
          <td><?=$cadaOrca['nome'];?></td>
          <td><?php echo "R$".$cadaOrca['valor_total'];?></td>
          <td><?=$cadaOrca['data_emissao'];?></td>
          <td>
            <?php
              if($cadaOrca['status']==1){
                echo "Em andamento";
              }elseif($cadaOrca['status']==2){
                echo "Finalizado";
              }elseif($cadaOrca['status']==3){
                echo "Reprovado";
              }
          ?>
          </td>
          <td>
            <?php
             if($cadaOrca['status']!=3 && $cadaOrca['status']!=2 ){
             ?>
            <form action="editaOrcamentoForm.php" method="POST" class="formBotao">
              <input type="hidden" name="editaOrcamento" value="<?=$cadaOrca['codigo'];?>" id="editaOrcamento">
              <button type="submit"><img src="../imgs/pencil.png" alt="Botão lápis"></button>
            </form>
            <?php
          }
             ?>
            <form action="visualizaOrcamento.php" method="POST" class="formBotao">
              <input type="hidden" name="visualizaOrcamento" value="<?=$cadaOrca['codigo'];?>" id="visualizaOrcamento">
              <button type="submit"><img src="../imgs/eye.png" alt="Botão olho"></button>
            </form>
              <?php
                if($_SESSION['nivelLogado']==3){
                  ?>
                    <form action="excluiOrcamento.php" method="POST" class="formBotao">
                      <input type="hidden" name="excluiOrcamento" value="<?=$cadaOrca['codigo'];?>" id="excluiOrcamento">
                      <button type="submit"><img src="../imgs/trash.png" alt="Botão lixeiro"></button>
                    </form>
                  <?php
                }elseif($_SESSION['nivelLogado']==1){
                  require_once("conexaoBanco.php");
                  $comando="SELECT orc.codigo FROM orcamentos as orc INNER JOIN usuarios as usu ON usu.codigo=orc.usuarios_codigo WHERE orc.codigo=".$cadaOrca['codigo']." AND orc.usuarios_codigo=".$_SESSION['idLogado'];
                  $resultado=mysqli_query($conexao,$comando);
                  $linhas = mysqli_num_rows($resultado);
                  if($linhas!=0){
              ?>
            <form action="excluiOrcamento.php" method="POST" class="formBotao">
              <input type="hidden" name="excluiOrcamento" value="<?=$cadaOrca['codigo'];?>" id="excluiOrcamento">
              <button type="submit"><img src="../imgs/trash.png" alt="Botão lixeiro"></button>
            </form>
            <?php
                }//fechamento if é atendente
                  }//fechamento if atentende é associado com o orcamento
              if($cadaOrca['status']==1 && $_SESSION['nivelLogado']==3){
            ?>
              <form action="reprovaOrcamento.php" method="POST" class="formBotao">
                <input type="hidden" name="reprovaOrcamento" value="<?=$cadaOrca['codigo'];?>" id="reprovaOrcamento">
                <button type="submit"><img src="../imgs/dislike.png" alt="Botão Dislike"></button>
              </form>
            <?php
              }elseif($cadaOrca['status']==3 && $_SESSION['nivelLogado']==3){
                ?>
                  <form action="reaprovaOrcamento.php" method="POST" class="formBotao">
                    <input type="hidden" name="reaprovaOrcamento" value="<?=$cadaOrca['codigo'];?>" id="reaprovaOrcamento">
                    <button type="submit"><img src="../imgs/like.png" alt="Botão Like"></button>
                  </form>
                <?php
              }
            ?>
          </td>
        </tr>
         <?php
        }
      }
          ?>
        </table>
    </fieldset>
  </div>
  <?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro ao realizar a operação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Operação realizada com sucesso!";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==2){
        $msgPopup="Não é possivel excluir um orçamento associado à uma ordem de serviço!";
        include ("../alertas/erro.php");
      }
    }
  ?>
</main>
</body>
</html>
<?php
}  //fechamento do IF
else{
  header("Location: login.php");
}
?>
