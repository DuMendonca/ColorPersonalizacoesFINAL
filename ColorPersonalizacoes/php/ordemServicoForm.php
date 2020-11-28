<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/ordemServico.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/ordemServico.js"></script>

</head>
<body>

<?php include("menuAdm.php"); ?>

<section id="registroCliente">
  <h1>Ordem de serviço</h1>
</section>



<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Dados gerais</legend>
      <form action="ordemServico.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">

        <label class="campos" for="orcamento">Código do orçamento:</label>
        <select id="orcamento" name="orcamento">
          <option value="0">Selecione...</option>
          <?php
            require_once("conexaoBanco.php");
            $comando = "SELECT codigo, status FROM orcamentos;";
            $resultado=mysqli_query($conexao,$comando);
      			$orcamentos = array();
              while ($cadaOrcamento = mysqli_fetch_assoc($resultado)){
                $comandorepete = "SELECT orcamentos_codigo FROM ordens_de_servicos WHERE orcamentos_codigo=".$cadaOrcamento['codigo'].";";
                $resultado1=mysqli_query($conexao,$comandorepete);
                $linhas 		=	mysqli_num_rows($resultado1);
                    if($linhas==0){
                      array_push($orcamentos, $cadaOrcamento);
                  }else{

                  }
      			  }
              foreach ($orcamentos as $cadaOrcamento) {
                if ($cadaOrcamento['status']!=3){
        		?>
        		<option value="<?=$cadaOrcamento['codigo'];?>">
        			<?=$cadaOrcamento['codigo'];?>
        		</option>
        		<?php
                }
              }
            ?>

        </select>

        <label class="campos" for="dataEntrega">Data de entrega:</label>
        <input class="camposForm" type="date" name="dataEntrega" id="dataEntrega" required>
        <label class="campos" for="funcExecutor">Funcionário responsável:</label>
        <select id="funcExecutor" name="funcExecutor">
          <option value="0">Selecione...</option>
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
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonGerarordem.png" alt="Botão para gerar a ordem de serviço">
        </button>
      </form>
    </fieldset>
  </div>
  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Consulta de ordem de serviço</legend>
      <form action="ordemServicoForm.php" method="GET">
        <label for="consultaNomeCliente" id="labelConsultaNome">Nome do Cliente:</label>
        <input type="text" name="consultaNomeCliente" id="consultaNomeCliente" placeholder="Insira o nome do cliente...">
        <button type="submit">Buscar</button>
      </form>

      <table>
        <tr>
          <th>Cliente</th>
          <th>Data de entrega</th>
          <th>Funcionário responsável</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
        <?php
        if(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']==""){
          $comando3 = "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id";
        }
        elseif (isset($_GET['consultaNomeCliente'])==false ){
          $comando3 = "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id";
        }
        elseif(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']!=""){
          $consultaNomeCliente = $_GET['consultaNomeCliente'];
          $comando3= "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id WHERE cli.nome LIKE '".$consultaNomeCliente."%'";
        }
        $resultado3=mysqli_query($conexao,$comando3);
        $linhas2=mysqli_num_rows($resultado3);
        if($linhas2==0){
        ?>

        <tr><td colspan="5">Nenhuma ordem de serviço encontrado</td></tr>
        <?php
        }else{
          $ordens = array();
          while($cadaOrdens =mysqli_fetch_assoc($resultado3)){
            array_push($ordens,$cadaOrdens);
          }
          foreach($ordens as $cadaOrdens){
         ?>
        <tr>
          <td><?=$cadaOrdens['nome'];?></td>
          <td><?=$cadaOrdens['data_entrega'];?></td>
          <td><?=$cadaOrdens['nome_func'];?></td>
          <td>
            <?php
              if($cadaOrdens['status']==1){
                echo "Em andamento";
              }else{
                echo "Finalizado";
              }
          ?>
          </td>
          <td>
            <?php
            if($cadaOrdens['status']==1){
            ?>
            <form action="editaOrdemForm.php" method="POST" class="formBotao">
              <input type="hidden" name="editaOrdem" value="<?=$cadaOrdens['codigo'];?>" id="editaOrdem">
              <button type="submit"><img src="../imgs/pencil.png" alt="Botão lápis"></button>
            </form>
            <?php
            }
            ?>
            <form action="visualizaOrdem.php" method="POST" class="formBotao">
              <input type="hidden" name="visualizaOrdem" value="<?=$cadaOrdens['codigo'];?>" id="">
              <button type="submit"><img src="../imgs/eye.png" alt="Botão olho"></button>
            </form>
            <?php
            if($cadaOrdens['status']==1){
            ?>
            <form action="excluirOrdem.php" method="POST" class="formBotao">
              <input type="hidden" name="excluiOrdem" value="<?=$cadaOrdens['codigo'];?>" id="excluiOrdem">
              <button type="submit"><img src="../imgs/trash.png" alt="Botão lixeiro"></button>
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
</main>
<?php
  if(isset($_GET['retorno'])==true){
    if($_GET['retorno']==0){
      $msgPopup="Erro ao realizar a operação!";
      include ("../alertas/erro.php");
    }else if($_GET['retorno']==1){
      $msgPopup="Operação realizada com sucesso!";
      include ("../alertas/sucesso.php");
    }
  }
?>
</body>
</html>
<?php
}  //fechamento do IF
else{
  header("Location: login.php");
}
?>
