<?php
  session_start();
  if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/relatorioOrcamento.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/relatorioOrcamento.js"></script>
</head>
<body>
  <?php
    include("menuAdm.php");
  ?>

  <div id="divAlerta">
    <?php
      if((isset($_GET['retorno'])==true)&&($_GET['retorno']==0)){
        include("../alertas/emailErro.html");
      }else if((isset($_GET['retorno'])==true)&&($_GET['retorno']==1)){
        include("../alertas/emailSucesso.html");
      }
     ?>
  </div>

<section id="relatorioOrcamento">
  <h1>Relatório de Orçamento</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divFiltro">
    <fieldset id="fieldCadastro">
      <legend >Filtro</legend>
      <form action="#" method="GET" id="formCadastro" onsubmit="return validarCampos()">

        <label class="campos" for="cliente">Cliente:</label>
        <select id="cliente" name="cliente">
          <option value="0">Selecione...</option>
        <?php
          require_once("conexaoBanco.php");
          $comando = "SELECT id,nome FROM clientes";
          $resultado = mysqli_query($conexao,$comando);
          $clientes = array();
          while($cadaCli = mysqli_fetch_assoc($resultado)){
            array_push($clientes,$cadaCli);
          }
          foreach($clientes as $cadaCli){
          ?>
          <option value="<?=$cadaCli['id'];?>">
            <?=$cadaCli['nome'];?>
          </option>
          <?php
        } //FOREACH
           ?>
        </select>

        <label class="campos" for="dataInicial">Data inicial:</label>
        <input class="camposForm" type="date" name="dataInicial" id="dataInicial">
        <label class="campos" for="dataFinal">Data final:</label>
        <input class="camposForm" type="date" name="dataFinal" id="dataFinal">
    

        <label class="campos" for="status">Status:</label>
        <select  name="status" id="status">
          <option value="">Selecione...</option>
          <option value="1">Aprovado</option>
          <option value="2">Em analíse</option>
          <option value="3">Cancelado</option>
        </select>
        <br>

        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão limpa campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonGerar.png" alt="Botão para gerar relatorio">
        </button>
      </form>
    </fieldset>
  </div>

  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Relatório</legend>
      <table>
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Valor total</th>
          <th>Produtos</th>
        </tr>
        <?php
        if(isset($_GET['dataInicial'])&& isset($_GET['dataFinal'])&& isset($_GET['cliente']) && isset($_GET['status'])){
          $dataInicial = $_GET['dataInicial'];
          $dataFinal = $_GET['dataFinal'];
          $idCliente = $_GET['cliente'];
          $status = $_GET['status'];
          $dataAtual = date('Y-m-d');
          $dataMinima = '2000-01-01';

        //N N N N
        if($dataInicial=="" && $dataFinal=="" && $idCliente=="0" && $status==""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, pro.nome as nomeProd FROM
        orcamentos as orc INNER JOIN  clientes  as cli  on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
          orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo";
        }
        // S S S S
        else if($dataInicial!="" && $dataFinal!="" && $idCliente!="0" && $status!="" ){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome  as nomeCliente, pro.nome as nomeProd FROM
          orcamentos  as orc INNER JOIN  clientes as cli on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
          orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND ' orc.status=".$status."' AND cli.id=".$idCliente;
        }
        //S N S N
        else if($dataInicial!="" && $dataFinal=="" && $idCliente!="0" && $status==""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND cli.id=".$idCliente;
        }
        // //S N N N
            else if($dataInicial!="" && $dataFinal=="" && $idCliente=="0" && $status==""){
            $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
            clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
            INNER JOIN orcamentos_tem_produtos as orcpro ON
             orc.codigo=orcpro.orcamentos_codigo INNER JOIN
             produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."'";
          }
        // //S S N S
        else if($dataInicial!="" && $dataFinal!="" && $idCliente=="0" && $status!=""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo
           =pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND orc.status=".$status;
        }
        //N N S S
        else if($dataInicial=="" && $dataFinal=="" && $idCliente!="0" && $status!=""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id INNER JOIN orcamentos_tem_produtos as orcpro ON orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.status='".$status."' AND cli.id=".$idCliente;
        }
        //N S S S
        else if($dataInicial=="" && $dataFinal!="" && $idCliente!="0" && $status!="" ){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND orc.status='".$status."' AND cli.id=".$idCliente;
        }
        //N S N S
        else if($dataInicial=="" && $dataFinal!="" && $idCliente=="0" && $status!=""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND orc.status=".$status;
        }
        //N N N S
          else if($dataInicial=="" && $dataFinal=="" && $idCliente=="0" && $status!=""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.status=".$status;
        }
        //N N S N
          else if($dataInicial=="" && $dataFinal=="" && $idCliente!="0" && $status==""){
          $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
          clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
          INNER JOIN orcamentos_tem_produtos as orcpro ON
           orc.codigo=orcpro.orcamentos_codigo INNER JOIN
           produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE cli.id=".$idCliente;
         }
         //N S N N
           else if($dataInicial=="" && $dataFinal!="" && $idCliente=="0" && $status==""){
           $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
           clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
           INNER JOIN orcamentos_tem_produtos as orcpro ON
            orc.codigo=orcpro.orcamentos_codigo INNER JOIN
            produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."'";
          }
          //S S S N
            else if($dataInicial!="" && $dataFinal!="" && $idCliente!="0" && $status==""){
            $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
            clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
            INNER JOIN orcamentos_tem_produtos as orcpro ON
             orc.codigo=orcpro.orcamentos_codigo INNER JOIN
             produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."' AND cli.id=".$idCliente;
           }
           //S N S S
             else if($dataInicial!="" && $dataFinal=="" && $idCliente!="0" && $status!=""){
             $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
             clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
             INNER JOIN orcamentos_tem_produtos as orcpro ON
              orc.codigo=orcpro.orcamentos_codigo INNER JOIN
              produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND orc.status='".$status."' AND cli.id=".$idCliente;
            }
            //S S N N
              else if($dataInicial!="" && $dataFinal!="" && $idCliente=="0" && $status==""){
              $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
              clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
              INNER JOIN orcamentos_tem_produtos as orcpro ON
               orc.codigo=orcpro.orcamentos_codigo INNER JOIN
               produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataFinal."'";
             }
             // N S S N
             else if($dataInicial=="" && $dataFinal!="" && $idCliente!="0" && $status==""){
             $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
             clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
             INNER JOIN orcamentos_tem_produtos as orcpro ON
              orc.codigo=orcpro.orcamentos_codigo INNER JOIN
              produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataMinima."' AND '".$dataFinal."' AND cli.id=".$idCliente;
            }
              // S N N S
              else if($dataInicial!="" && $dataFinal=="" && $idCliente=="0" && $status!=""){
              $comando1="SELECT orc.codigo as codigoOrc, orc.valor_total as valor_total, orc.status, cli.nome as nomeCliente, orc.data_emissao, pro.nome as nomeProd FROM
              clientes as cli INNER JOIN orcamentos as orc on cli.id=orc.clientes_id
              INNER JOIN orcamentos_tem_produtos as orcpro ON
               orc.codigo=orcpro.orcamentos_codigo INNER JOIN
               produtos as pro ON orcpro.produtos_codigo=pro.codigo WHERE orc.data_emissao BETWEEN '".$dataInicial."' AND '".$dataAtual."' AND orc.status=".$status;
             }

        $resultado1= mysqli_query($conexao,$comando1);
        $linhas=mysqli_num_rows($resultado1);
        if($linhas==0){
          ?>
          <tr>
            <td colspan="4">Nenhum pedido encontrado!</td>
          </tr>
          <?php
        }
        else{
          $orca=array();
          while($cadaOrc = mysqli_fetch_assoc($resultado1)){
            array_push($orca,$cadaOrc);
          }
          $html="";
          foreach($orca as $cadaOrc){
            $html.="
              <tr>
                <td>".$cadaOrc['codigoOrc']."</td>
                <td>".$cadaOrc['nomeCliente']."</td>
                <td>".$cadaOrc['valor_total']."</td>
                <td>".$cadaOrc['nomeProd']."</td>
              </tr>
            ";
          }//FOREACH
          echo $html;
        }//else
      }//Primeiro if
       ?>
      </table>
      <br>
      <form action="geraPDF.php" method="POST">
        <input type="hidden" name="html" value="<?=$html?>">
        <input type="hidden" name="linhas" value="<?=$linhas?>">
        <button type="submit" class="botoes"><img class="botoesImg" src="../imgs/buttonGerarPdf.png" alt="Botão para gerar pdf"></button>
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
