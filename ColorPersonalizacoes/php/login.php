<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/login.js"></script>
</head>
<body>

<?php
	include("menuVisita2.php");
?>

<section id="login">
  <h1 id="loginTexto">Login</h1>
</section>

<main id="conteudoPrincipal">

  <div id="divImgLogo"><img src="../imgs/logoCores.png" id="imgLogo" alt="Logo Color Personalizações"></div>
  <div id="divForm">
  	<form action="efetuaLogin.php" method="POST" id="formLogin" onsubmit="return validarCampos()">
  		<label class="campos" for="email">E-mail</label><br>
		<input class="camposForm" type="email" name="email" id="email" placeholder="Exemplo@email.com"><br>
		<label class="campos" for="senha">Senha</label><br>
		<input class="camposForm" type="password" name="senha" id="senha" placeholder="Insira senha aqui"><br>
		<a href="redefinirSenhaForm.php" id="esqueciSenha">Esqueci minha senha</a><br>

		<button type="reset" class="botoes">
			<img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão limpa campos">
		</button>
		<button type="submit" class="botoes">
			<img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
		</button>
  	</form>
  </div>

</main>
<?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro na autenticação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Senha atualizada com sucesso!";
        include ("../alertas/sucesso.php");
      }
    }
?>
<footer id="rodape">
<p id="copyright">Copyright SENAI &copy;</p>
</footer>

</body>
</html>
