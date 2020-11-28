<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/destaques.css">
  <link rel="stylesheet" type="text/css" href="../slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="../slick/slick-theme.css"/>

  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/jquery-migrate-1.2.1.min.js"></script>
  <script src="../slick/slick.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/destaques.js"></script>
</head>
<body>

<?php
    include ("menuVisita2.php")
?>

<section id="destaques">
	<h2 id="textoDestaques">Destaques</h2><br>
	<h3 id="subTextoDestaques">Os mais pedidos</h3>
</section>

<main id="conteudoPrincipal">

  <div class="carrossel">
    <?php
      function formataString($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str);
        return $str;
      }
      require_once("conexaoBanco.php");
      $comando="SELECT produtos_codigo, COUNT(`produtos_codigo`) AS `produtoPopular` FROM `orcamentos_tem_produtos` GROUP BY `produtos_codigo` ORDER BY `produtoPopular` DESC LIMIT 3";
      $resultado=mysqli_query($conexao,$comando);
      $topProdutos=array();
      while ($cadaProduto = mysqli_fetch_assoc($resultado)){
        array_push($topProdutos, $cadaProduto);
      }
      foreach ($topProdutos as $cadaTopProduto) {
        $comando1="SELECT * FROM produtos WHERE codigo=".$cadaTopProduto['produtos_codigo'];;
        $resultado1= mysqli_query($conexao,$comando1);
        $produto=mysqli_fetch_assoc($resultado1);

        $comando2 = "SELECT nome FROM categorias WHERE codigo = ".$produto['categorias_codigo'];
        $resultado2 = mysqli_query($conexao,$comando2);
        $categoria = mysqli_fetch_assoc($resultado2);
        $nomeCategoria = strtolower(formataString($categoria['nome']));

        ?>
          <div><img class="imgCarrossel" src="../imgs/<?=$nomeCategoria;?>/<?=$produto['imagem'];?>" alt="<?=$produto['nome'];?>">
          <p class="paragCarrossel"><?=$produto['nome'];?><br>Cor: A escolher<br>Preço médio: R$<?=$produto['preco_unitario'];?></p></div>
        <?php
      }
    ?>
  </div>


</main>

<footer id="rodape">
<p id="copyright">Copyright SENAI &copy;</p>
</footer>
</body>
</html>
