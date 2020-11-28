<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/carrossel.css">
  <link rel="stylesheet" type="text/css" href="../slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="../slick/slick-theme.css"/>

  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/jquery-migrate-1.2.1.min.js"></script>
  <script src="../slick/slick.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/carrossel.js"></script>
</head>
<body>

<?php
    include ("menuVisita2.php")
?>
<?php
  if(isset($_GET['retorno'])){
    require_once("conexaoBanco.php");
    $codigoCat=$_GET['retorno'];
    $comando2 = "SELECT nome, descricao FROM categorias WHERE codigo=".$codigoCat;
    $resultado2 = mysqli_query($conexao,$comando2);
    $categoria = mysqli_fetch_assoc($resultado2);

    $linhas=mysqli_num_rows($resultado2);

    $comando="SELECT * FROM produtos WHERE categorias_codigo=".$codigoCat;
    $resultado= mysqli_query($conexao,$comando);

    $linhasProdutos=mysqli_num_rows($resultado);

    if($linhas != 0 && $linhasProdutos != 0){
?>
<section id="destaques">
	<h2 id="textoDestaques"><?=$categoria['nome'];?></h2><br>
	<h3 id="subTextoDestaques"><?=$categoria['descricao'];?></h3>
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
      $produtos = array();
      while ($cadaProduto = mysqli_fetch_assoc($resultado)){
        array_push($produtos, $cadaProduto);
      }
      $nomeCategoria = strtolower(formataString($categoria['nome']));
        foreach ($produtos as $cadaProduto) {
          ?>
            <div><img class="imgCarrossel" src="../imgs/<?=$nomeCategoria;?>/<?=$cadaProduto['imagem'];?>" alt="<?=$cadaProduto['nome'];?>">
            <p class="paragCarrossel"><?=$cadaProduto['nome'];?><br>Cor: A escolher<br>Preço médio: R$<?=$cadaProduto['preco_unitario'];?></p></div>
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
<?php
    }else{ //fecha if linhas
    header("Location: destaques.php");
  }
  }else{ //fecha if isset
    header("Location: destaques.php");
  }
?>
