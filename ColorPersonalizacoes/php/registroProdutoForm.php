<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/registroProduto.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="../js/registroProduto.js"></script>

</head>
<body>

	<?php
    include ("menuAdm.php")
  ?>

<section id="registroProduto">
  <h1>Registro de Produtos</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Cadastro de produtos</legend>
      <form action="registroProduto.php" enctype="multipart/form-data" method="POST" id="formCadastro" onsubmit="return validarCampos()">

        <label class="campos" for="nome">*Nome produto:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira nome do produto aqui">
        <label class="campos" for="categoria">*Categoria</label>
        <select name="categoria" id="categoria">
          <option value="0">Selecione...</option>
          <?php
            require_once("conexaoBanco.php");
            $comando="SELECT codigo, nome FROM categorias";
            $resultado=mysqli_query($conexao,$comando);
            $categorias = array();
            while ($cadaCategoria = mysqli_fetch_assoc($resultado)){
              array_push($categorias, $cadaCategoria);
            }
            foreach ($categorias as $cadaCategoria) {
          ?>
          <option
          value="<?=$cadaCategoria['codigo'];?>"
          >
            <?=$cadaCategoria['nome'];?>
          </option>
          <?php } ?>
        </select><br>
        <label class="campos" for="descricao">Descrição:</label>
        <input class="camposForm" type="text" name="descricao" id="descricao" placeholder="Insira descrição do produto">

        <label class="campos" for="preco">*Preço unitário: R$</label>
        <input class="camposForm" type="text" name="preco" id="preco" placeholder="000,00"><br>

        <label class="campos" for="imagem">*Imagem</label>
        <input type="file" name="imagem" id="imagem" accept="image/x-png,image/gif,image/jpeg"><br>

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
      <legend>Consulta de produtos:</legend>
      <form action="#" method="POST">
        <label for="consultaNomeProduto" id="labelConsultaNomeProduto">Nome do produto:</label>
        <input type="text" name="consultaNomeProduto" id="consultaNomeProduto">
        <button type="submit">Buscar</button>
      </form>

      <table>
        <tr>
          <th>Código</th>
          <th>Nome do produto</th>
          <th>Categoria</th>
          <th>Preço Unitário</th>
          <th>Ações</th>
        </tr>
        <?php 
          require_once("conexaoBanco.php");
          if (isset($_POST['consultaNomeProduto'])==false){
            $comando = "SELECT * FROM produtos";
          }else{
            $busca = $_POST['consultaNomeProduto'];
            $comando="SELECT * FROM produtos WHERE nome LIKE '".$busca."%'";
          }
          $resultado = mysqli_query($conexao,$comando);
          $linhas=mysqli_num_rows($resultado);

          if($linhas==0){?>
            <tr><td colspan="5">Nenhum produto encontrado!</td></tr>
          <?php }else{
            $produtosRetornados=array();

            while ($cadaLinha = mysqli_fetch_assoc($resultado)){
              array_push($produtosRetornados,$cadaLinha);
            }

            foreach($produtosRetornados as $cadaProduto){
              $cat=$cadaProduto['categorias_codigo'];
              $comando = "SELECT nome FROM categorias WHERE codigo=".$cat;
              $resultado = mysqli_query($conexao,$comando);
              $nomeCat = mysqli_fetch_assoc($resultado);
              ?>
                <tr>

                  <td> <?php echo $cadaProduto['codigo'];?> </td>
                  <td> <?php echo $cadaProduto['nome'];?> </td>
                  <td> <?php echo $nomeCat['nome'];?> </td>
                  <td> <?php echo "R$".$cadaProduto['preco_unitario'];?> </td>

                  <td>

                    <form class="formAcoes" action="editaProdutoForm.php" method="post">
                      <input type="hidden" name="codigoProduto" value="<?=$cadaProduto['codigo'];?>">
                      <button type="submit" class="botoesAcao"> <img src="../imgs/pencil.png"></button>
                    </form>

                    <form class="formAcoes" action="excluiProduto.php" method="post">
                      <input type="hidden" name="codigoProduto" value="<?=$cadaProduto['codigo'];?>">
                      <button type="submit" class="botoesAcao"> <img src="../imgs/trash.png"></button>
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
        $msgPopup="Erro ao realizar a operação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Operação realizada com sucesso!";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==2){
        $msgPopup="Não é possível excluir produto que está em algum orçamento!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==3){
        $msgPopup="Imagem inválida!";
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
  header("Location: /login.php");
}



?>