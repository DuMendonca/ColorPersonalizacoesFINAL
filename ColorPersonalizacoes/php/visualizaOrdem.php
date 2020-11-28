<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1 || $_SESSION['nivelLogado']==2){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/ordemServico.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">

</head>
<body>

<?php

require_once("conexaoBanco.php");
if ($_SESSION['nivelLogado']==1){
include("menuAtendente.php");
}else if ($_SESSION['nivelLogado']==2){
include("menuEstampador.php");
}else if ($_SESSION['nivelLogado']==3){
include("menuAdm.php");
}
?>

<section id="registroCliente">
  <h1>Produtos da Ordem de Serviço</h1>
</section>

  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Consulta dos produtos da ordem de serviço</legend>
      <?php
      $codigoOrdem = $_POST['visualizaOrdem'];
      $comandoInfo = "SELECT data_entrega, data_emissao FROM ordens_de_servicos WHERE codigo=".$codigoOrdem."";
      $resultadoInfo = mysqli_query($conexao,$comandoInfo);
      $ordemInfo = array();
      while($cadaOrdemInfo =mysqli_fetch_assoc($resultadoInfo)){
        array_push($ordemInfo,$cadaOrdemInfo);
      }
      ?>
      <p class="infos">Código da Ordem de Serviço: <?=$codigoOrdem?></p>
      <?php
      foreach($ordemInfo as $cadaOrdemInfo){
        ?>
      <p class="infos">Data de Emissão: <?=$cadaOrdemInfo['data_emissao'];?></p>
      <p class="infos">Data de Entrega: <?=$cadaOrdemInfo['data_entrega'];?></p>
      <?php
    }
      ?>
      <table class="especifica">
        <tr>
          <th>Produtos</th>
          <th>Descrição</th>
          <th>Quantidade dos produtos</th>
        </tr>
        <?php
        require_once("conexaoBanco.php");
        $comando = "SELECT assoc.quantidade, assoc.especificacao, prod.nome FROM ordens_de_servicos AS ordem JOIN orcamentos_tem_produtos AS assoc ON ordem.orcamentos_codigo=assoc.orcamentos_codigo JOIN produtos AS prod ON assoc.produtos_codigo=prod.codigo WHERE ordem.codigo=".$codigoOrdem."";
        $resultado = mysqli_query($conexao,$comando);
        $ordem = array();
        while($cadaOrdem =mysqli_fetch_assoc($resultado)){
          array_push($ordem,$cadaOrdem);
        }
        foreach($ordem as $cadaOrdem){
       ?>
      <tr>
        <td><?=$cadaOrdem['nome'];?></td>
        <td><?=$cadaOrdem['especificacao'];?></td>
        <td><?=$cadaOrdem['quantidade'];?></td>
      </tr>
      <?php
    }
      ?>
    </table>
      <form action="
      <?php
      if($_SESSION['nivelLogado']==1 || $_SESSION['nivelLogado']==2){
      ?>
      consultaOrdemServico.php
      <?php
      }else{
      ?>
      ordemServicoForm.php
      <?php
      }
      ?>
      " method="GET" class="formBotao">
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/button_voltar.png" alt="Botão para voltar a página">
        </button>
      </form>
    </fieldset>
  </div>
</main>
</body>
</html>
<?php
}  //fechamento do IF
else{
  header("Location: login.php");
}
?>
