<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/orcamento.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">

</head>
<body>

<?php

require_once("conexaoBanco.php");
if ($_SESSION['nivelLogado']==1){
include("menuAtendente.php");
}else if ($_SESSION['nivelLogado']==3){
include("menuAdm.php");
}
?>

<section id="registroOrcamento">
  <h1>Produtos do Orçamento</h1>
</section>

  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Consulta dos produtos do orçamento:</legend>
      </form>

      <table>
        <tr>
          <th>Produtos</th>
          <th>Descrição</th>
          <th>Quantidade dos produtos</th>
          <th>Preço Unitário</th>
        </tr>
        <?php
        require_once("conexaoBanco.php");
        $codigoOrca = $_POST['visualizaOrcamento'];
        $comando = "SELECT assoc.quantidade, assoc.especificacao, prod.nome, prod.preco_unitario FROM orcamentos AS orca JOIN orcamentos_tem_produtos AS assoc ON orca.codigo=assoc.orcamentos_codigo JOIN produtos AS prod ON assoc.produtos_codigo=prod.codigo WHERE orca.codigo=".$codigoOrca."";
        $resultado = mysqli_query($conexao,$comando);
        $orcamento = array();
        while($cadaOrca =mysqli_fetch_assoc($resultado)){
          array_push($orcamento,$cadaOrca);
        }
        foreach($orcamento as $cadaOrca){
       ?>
      <tr>
        <td><?=$cadaOrca['nome'];?></td>
        <td><?=$cadaOrca['especificacao'];?></td>
        <td><?=$cadaOrca['quantidade'];?></td>
        <td><?php echo "R$".$cadaOrca['preco_unitario'];?>
      </tr>

      <?php
    }
      ?>
      </table>
      <form action="orcamentoForm.php" method="GET" class="formBotao">
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
