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
  <h3>Crie uma nova senha!</h3>
</section>

<main id="conteudoPrincipal">
        <div id="divForm">
          <form action="redefinirSenhas.php" method="POST" id="formRedefinir" onsubmit="return validarCampos()">
            <label class="campos" for="senhaNova">Nova Senha </label><br>
            <input class="camposForm" type="password" name="senhaNova" id="senhaNova" placeholder="Insira uma nova senha"><br>

            <label class="campos" for="senhaConfirma">Confirme a senha </label><br>
            <input class="camposForm" type="password" name="senhaConfirma" id="senhaConfirma" placeholder="Insira a senha novamente"><br>
            <button type="submit" class="botoes">
            <img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
          </button>
          </form>
        </div>
</main>
<?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro ao atualizar senha!";
        include ("../alertas/erro.php");
      }elseif($_GET['retorno']==1){
        $msgPopup="Senhas diferentes! Por favor insira senhas iguais!";
        include ("../alertas/erro.php");
      }
    }
?>
<footer id="rodape">
<p id="copyright">Copyright SENAI &copy;</p>
</footer>

</body>
</html>
