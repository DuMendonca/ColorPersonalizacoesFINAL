<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==2){

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
if($_SESSION['nivelLogado']==3){
include("menuAdm.php");
}else if($_SESSION['nivelLogado']==2){
include("menuEstampador.php");
}
?>

<section id="registroCliente">
  <h1>Ordem de serviço</h1>
</section>



<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <?php
        require_once("conexaoBanco.php");
        $codigo =  $_POST['editaOrdem'];
        $comando = "SELECT * FROM ordens_de_servicos WHERE codigo=".$codigo;
        $resultado = mysqli_query($conexao, $comando);
        $ordem = mysqli_fetch_assoc($resultado);

      if($_SESSION['nivelLogado']==3){
      ?>
      <legend>Dados gerais</legend>
      <?php
      }else if($_SESSION['nivelLogado']==2){
      ?>
      <legend >Editar o Status da Ordem</legend>
      <?php
      }
      ?>




      <form action="editaOrdem.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">


      <?php
        if($_SESSION['nivelLogado']==3){
      ?>
        <input type="hidden" name="codigo" id="codigo" value="<?=$ordem['codigo']?>">
        <label class="campos" for="orcamento">Código do orçamento:</label>
        <input class="camposForm" id="orcamento" name="orcamento"  readonly="readonly" value="<?=$ordem['codigo'];?>">

        <label class="campos" for="dataEntrega">Data de entrega:</label>
        <input class="camposForm" type="date" name="dataEntrega" id="dataEntrega" value="<?=$ordem['data_entrega'];?>"required>
      <?php
      }else if($_SESSION['nivelLogado']==2){
      ?>
        <input type="hidden" name="codigo" id="codigo" value="<?=$ordem['codigo']?>">
        <br>
        <label class="campos" for="status">Status:</label>
        <select id="status" name="status">
          <option selected value="1">Em andamento</option>
          <option value="2">Finalizada</option>
        </select>
        <br>
      <?php
      }
      ?>
        <br>
        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonResetarCampos.png" alt="Botão para gerar a resetar os campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/button_editar-ordem-de-servico.png" alt="Botão para gerar a ordem de serviço">
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
