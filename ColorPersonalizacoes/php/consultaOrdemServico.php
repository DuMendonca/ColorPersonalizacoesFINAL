<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==1 || $_SESSION['nivelLogado']==2){

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

<?php
require_once("conexaoBanco.php");
if ($_SESSION['nivelLogado']==1){
include("menuAtendente.php");
}else if ($_SESSION['nivelLogado']==2){
include("menuEstampador.php");
}?>

<section id="registroCliente">
  <h1>Consulta de Ordem de Serviço</h1>
</section>



<main id="conteudoPrincipal">
  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Consulta de ordem de serviço</legend>
      <form action="consultaOrdemServico.php" method="GET">
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
        $nivelUsuario = $_SESSION['nivelLogado'];
        $idEstampador = $_SESSION['idLogado'];
        if($nivelUsuario==2){

          if(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']==""){
            $comando3 = "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id WHERE ordem.usuarios_codigo = ".$idEstampador." AND ordem.status=1;";
          }
          elseif (isset($_GET['consultaNomeCliente'])==false ){
            $comando3 = "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id WHERE ordem.usuarios_codigo = ".$idEstampador." AND ordem.status=1;";
          }
          elseif(isset($_GET['consultaNomeCliente']) && $_GET['consultaNomeCliente']!=""){
            $consultaNomeCliente = $_GET['consultaNomeCliente'];
            $comando3= "SELECT ordem.codigo, cli.nome, ordem.data_entrega, usu.nome_func, ordem.status FROM ordens_de_servicos AS ordem JOIN orcamentos AS orca ON ordem.orcamentos_codigo = orca.codigo JOIN usuarios AS usu ON ordem.usuarios_codigo=usu.codigo JOIN clientes AS cli ON orca.clientes_id = cli.id WHERE ordem.usuarios_codigo = ".$idEstampador." AND
            cli.nome LIKE '".$consultaNomeCliente."%' AND ordem.status=1";
          }

      }else{
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
      }
        $resultado3=mysqli_query($conexao,$comando3);
        $linhas2=mysqli_num_rows($resultado3);
        if($linhas2==0){
            if($nivelUsuario==2){
              ?>
              <tr><td colspan="5">Você não tem nenhuma ordem de serviço correspondente!</td></tr>
              <?php
            }else{
              ?>
              <tr><td colspan="5">Nenhuma ordem de serviço encontrado!</td></tr>
              <?php
            }
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
            if($_SESSION['nivelLogado']==2){
            if($cadaOrdens['status']==1){
            if($cadaOrdens['nome_func']==$_SESSION['nomeLogado']){
            ?>
            <form action="editaOrdemForm.php" method="POST" class="formBotao">
              <input type="hidden" name="editaOrdem" value="<?=$cadaOrdens['codigo'];?>" id="editaOrdem">
              <button type="submit"><img src="../imgs/pencil.png" alt="Botão lápis"></button>
            </form>
            <?php
              }
            }
          }
            ?>
            <form action="visualizaOrdem.php" method="POST" class="formBotao">
              <input type="hidden" name="visualizaOrdem" value="<?=$cadaOrdens['codigo'];?>" id="">
              <button type="submit"><img src="../imgs/eye.png" alt="Botão olho"></button>
            </form>
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
          $msgPopup="Falha ao editar o status da ordem!";
          include ("../alertas/erro.php");
        }elseif($_GET['retorno']==1){
          $msgPopup="Edição feita com sucesso!";
          include ("../alertas/sucesso.php");
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
