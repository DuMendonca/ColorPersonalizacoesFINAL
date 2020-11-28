<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/editaProduto.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="../js/editaProduto.js"></script>

</head>
<body>

  <?php
    include ("menuAdm.php")
  ?>

<section id="editaProduto">
  <h1>Edição de Produtos</h1>
</section>

<main id="conteudoPrincipal">
  <div id="divEdita">
    <fieldset id="fieldEdita">

      <?php
        require_once("conexaoBanco.php");
        $codigo=$_POST['codigoProduto'];
        $comando = "SELECT * FROM produtos WHERE codigo=".$codigo;
        $resultado = mysqli_query($conexao, $comando);
        $produto = mysqli_fetch_assoc($resultado);
      ?>

      <legend >Edição de produtos</legend>

      <form action="editaProduto.php" enctype="multipart/form-data" method="POST" id="formEdita" onsubmit="return validarCampos()">

        <input type="hidden" name="codigo" id="codigo" value="<?=$produto['codigo']?>">
        <input type="hidden" name="nomeImagem" value="<?=$produto['imagem']?>">

        <label class="campos" for="nome">*Nome produto:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira nome do produto aqui" value="<?=$produto['nome']?>">

        <label class="campos" for="categoria">*Categoria</label>
        <select name="categoria" id="categoria">
          <option value="0">Selecione...</option>
          <?php
          $comando2 = "SELECT * FROM categorias";
          $resultado2 = mysqli_query($conexao,$comando2);
          $categorias=array();

          while($cadaCat = mysqli_fetch_assoc($resultado2)){
            array_push($categorias, $cadaCat);
          }
          foreach($categorias as $cadaCat){
            if($cadaCat['codigo']==$produto['categorias_codigo']){
              ?>
                <option selected="selected" value="<?=$cadaCat['codigo'];?>">
                    <?=$cadaCat['nome'];?>
                </option>
              <?php
            }else{
              ?>
                <option value="<?=$cadaCat['codigo'];?>">
                  <?=$cadaCat['nome'];?>
                </option>
              <?php
            } //else
          } // foreach
          ?>
        </select><br>
        <label class="campos" for="descricao">Descrição:</label>
        <input class="camposForm" type="text" name="descricao" id="descricao" placeholder="Insira descrição do produto" value="<?=$produto['descricao']?>">

        <label class="campos" for="preco">*Preço unitário: R$</label>
        <input class="camposForm" type="text" name="preco" id="preco" placeholder="000,00" value="<?php
        echo str_replace('.', ',', $produto['preco_unitario']);?>"><br>

        <label class="campos" for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem" accept="image/x-png,image/gif,image/jpeg"><br>

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
}  //fechamento do IF
else{
  header("Location: login.php");
}
?>