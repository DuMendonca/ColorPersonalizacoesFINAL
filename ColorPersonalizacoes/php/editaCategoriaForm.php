<?php
session_start();

if(isset($_SESSION['nivelLogado']) && ($_SESSION['nivelLogado']==3)){
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/registroCategoria.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/editaCategoria.js"></script>
</head>

<body>
  <?php
  include("menuAdm.php");
  ?>

<div class="divs" id="divAlertas">
  <?php
  if(isset($_GET['retorno'])==true){
    if($_GET['retorno']==1){
      include ("../alertas/sucesso.html");
    }else if($_GET['retorno']==0){
      include ("../alertas/erro.html");
    }
  }

   ?>
</div>

<section id="registroCategoria">
  <h1>Edição de Categorias</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Dados da categorias</legend>
    <?php
    require_once("conexaoBanco.php");
    $idCategoria = $_POST['editaCategoria'];


    $comando="SELECT * FROM categorias WHERE codigo=".$idCategoria;
    $resultado=mysqli_query($conexao,$comando);
    $categoria=mysqli_fetch_assoc($resultado);
    ?>

    <form action="editaCategoria.php" method="POST">
      <input class="camposForm" type="hidden" name="codigo" value="<?=$categoria['codigo'];?>">

      <label>Nome da categoria</label>
      <input class="camposForm" type="text" name="nome" id="nome" value="<?=$categoria['nome'];?>">
      <br>
      <label>Descrição</label>
      <textarea class="camposForm" name="descricao" id="descricao"><?=$categoria['descricao'];?></textarea><br>

      <button type="reset" class="botoes">
        <img class="botoesImg" src="../imgs/buttonResetarCampos.png" alt="Botão limpa campos">
      </button>

      <button type="submit" class="botoes">
        <img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
      </button>
    </form>
    </fieldset>
  </div>
</main>
</body>
</html>
<?php
  }else {
    header("Location: login.php");
  }

 ?>
