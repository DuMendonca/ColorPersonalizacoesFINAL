<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/index.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
</head>
<body>

<?php
    include ("php/menuVisita.php")
?>

<section id="bemVindo">
	<h1 id="bemVindoTexto">Bem-Vindo</h1><br>
	<p id="colorTexto">a Color Personalizações</p>
</section>

<main id="conteudoPrincipal">
	<img src="imgs/logoCores.png" id="imagemLogo" alt="Logo da empresa Color Personalizações">
	<p id="principalTexto">
		O nosso trabalho é focado na personalização de produtos, como canecas, canetas, camisas, entre outros.<br> Sempre com a visão de facilitar o nosso meio de se comunicar com o cliente e realizar um negócio.
	</p>

	<div id="caixaPrecisa">
		<h3 class="textoCaixa">Do que você está precisando?</h3>
		<p class="textoCaixa" id="paragrafoCaixa">Caneca personalizada? Camisa para aniversario? <br> Personalizamos itens para presente.</p>
		<a href="php/contatosForm.php"><img src="imgs/none.png" class="botaoOrcamento" alt="Botão de orçamento"></a>
	</div>
</main>

<footer id="rodape">
<p id="copyright">Copyright SENAI &copy;</p>
</footer>

</body>
</html>
