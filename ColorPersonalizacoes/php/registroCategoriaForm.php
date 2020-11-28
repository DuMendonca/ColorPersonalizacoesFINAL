<?php
  session_start();
  if (isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3) {
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/registroCategoria.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="../js/registroCategoria.js"></script>
</head>
<body>
  <?php
  include("menuAdm.php");
  ?>


<section id="registroCategoria">
  <h1>Registro de Categorias</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Cadastro de categorias</legend>
      <form action="registroCategoria.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">

        <label class="campos" for="nome">*Nome da categoria:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="ex.: Ecológicos"><br>

        <label class="campos" for="descricao">*Descrição:</label>
        <textarea class="camposForm" name="descricao" id="descricao" placeholder="Insira a descrição aqui"></textarea><br>

        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão limpa campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
        </button>
      </form>
    </fieldset>
  </div>
  <div class="divs" id="divConsulta">
    <fieldset id="fieldConsulta">
      <legend>Consulta de categorias</legend>
      <form action="registroCategoriaForm.php" method="GET">
        <label for="consultaNomeCategoria" id="labelConsultaNomeCategoria">Nome da categoria:</label>
        <input type="text" name="consultaNomeCategoria" id="consultaNomeCategoria">
        <button type="submit">Buscar</button>
      </form>

      <table>
        <tr>
          <th>Nome da Categoria</th>
          <th>Descrição da categoria</th>
          <th>Ações</th>
        </tr>
        <?php
        require_once ("conexaoBanco.php");

        if(isset($_GET['consultaNomeCategoria'])==false){
          $comando1="SELECT * FROM categorias";
        }else if (isset($_GET['consultaNomeCategoria'])==true && $_GET['consultaNomeCategoria']==""){
          $comando1="SELECT * FROM categorias";
        }else if(isset($_GET['consultaNomeCategoria'])==true && $_GET['consultaNomeCategoria']!=""){
          $consulta = $_GET['consultaNomeCategoria'];
        $comando1="SELECT * FROM categorias WHERE
        nome LIKE '%".$consulta."%'";
        }

        $resultado1 = mysqli_query($conexao,$comando1);
        $linhas=mysqli_num_rows($resultado1);
        if($linhas==0){		?>

          <tr>
            <td colspan="3">Nenhuma categoria encontrada!</td>
          </tr>
      <?php
        }else{
            $categoriasRetornadas = array();

            while($cadaLinha = mysqli_fetch_assoc($resultado1)){
              array_push($categoriasRetornadas, $cadaLinha);
            }
            foreach ($categoriasRetornadas as $cadaCategoria){
              ?>
            <tr>
            <td> <?php echo $cadaCategoria['nome'];?> </td>
            <td> <?php echo $cadaCategoria['descricao'];?> </td>
            <td>

            <form action="editaCategoriaForm.php" method="POST" class="formBotao">
              <input type="hidden" name="editaCategoria" value="<?php echo $cadaCategoria['codigo'];?>" id="editaCategoria">
              <button type="submit"><img src="../imgs/pencil.png" alt="Botão lápis"></button>
            </form>

            <form action="excluiCategoria.php" method="POST" class="formBotao">
              <input type="hidden" name="excluiCategoria" value="<?php echo $cadaCategoria['codigo'];?>" id="excluiCategoria">
              <button type="submit"><img src="../imgs/trash.png" alt="Botão lixeiro"></button>
            </form>
          </td>
        </tr>
    <?php
          }//foreach
      }//else
    ?>
      </table>
    </fieldset>
  </div>
  <div id="alertas">
  <?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro ao realizar a operação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Operação realizada com sucesso!";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==2){
        $msgPopup="Não é possível excluir uma categoria que contem produtos!";
        include ("../alertas/erro.php");
      }
    }
  ?>  </div>
</main>
</body>
</html>
<?php
  }else {
      header("Location: login.php");
  }

 ?>
