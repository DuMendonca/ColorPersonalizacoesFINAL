<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/redefinirSenha.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/redefinirSenha.js"></script>
</head>
<body>

<?php
	include("menuVisita2.php");
?>

<section id="redefinir">
  <h1 id="redefinirTexto">Redefinir senha</h1>
  <h3>Uma mensagem foi enviada para seu email com um código de redefinição!</h3>
</section>

<main id="conteudoPrincipal">
        <div id="divForm">
          <form action="redefinirSenhaC.php" method="POST" id="formRedefinir" onsubmit="return validarCampos()">
            <label class="campos" for="codigoIns">Insira o código </label><br>
            <input class="camposForm" type="text" name="codigoIns" id="codigoIns" placeholder="Ex: 0012345678"><br>
            <button type="submit" class="botoes">
              <img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
            </button>
          </form>
        </div>
<?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Email inválido!";
        include ("../alertas/erro.php");
      }elseif($_GET['retorno']==1){
        $msgPopup="Código inválido!";
        include ("../alertas/erro.php");
      }
    }
?>
</main>

<footer id="rodape">
<p id="copyright">Copyright SENAI &copy;</p>
</footer>

</body>
</html>
