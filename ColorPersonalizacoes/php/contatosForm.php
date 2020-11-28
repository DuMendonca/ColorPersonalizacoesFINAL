<?php
 session_start();
 // if(isset($_SESSION['nivel'])==true && $_SESSION['nivel']==2){
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/contatos.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="../js/contatos.js"></script>
</head>
<body>
<?php include("menuVisita2.php"); ?>

<section id="contatos">
  <h1 id="contatosTexto">Contatos</h1>
  <p id="mensagContatos">Mande sua mensagem para nós!</p>
</section>

<main id="conteudoPrincipal">

  <div id="informacoes">
	<form action="contatos.php" method="POST" id="formContato" onsubmit="return validarCampos()">

			<label class="campos" for="nome">Nome completo</label><br>
			<input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira nome completo aqui"><br>

			<label class="campos" for="email">E-mail</label><br>
			<input class="camposForm" type="email" name="email" id="email" placeholder="Exemplo@email.com"><br>

			<label class="campos" for="telefone">Telefone</label><br>
			<input class="camposForm" type="tel" name="telefone" id="telefone" placeholder="(xx)xxxx-xxxx" maxlength="14"><br><br>

				<input type="radio" name="radio" id="radio1" value="1"><label class="radioTexto">Crítica</label>
				<input type="radio" name="radio" id="radio2" value="2"><label class="radioTexto">Dúvida</label>
				<input type="radio" name="radio" id="radio3" value="3"><label class="radioTexto">Sugestão</label>
				<input type="radio" name="radio" id="radio4" value="4"><label class="radioTexto">Orçamento</label>
				<br>

			<label class="campos" for="mensagem">Mensagem</label><br>
			<textarea class="camposForm" name="mensagem" id="mensagem" placeholder="Insira texto aqui"></textarea><br>

			<button type="reset" class="botoes">
				<img class="botoesImg" src="../imgs/buttonLimpar.png" alt="Botão limpa campos">
			</button>
			<button type="submit" class="botoes">
				<img class="botoesImg" src="../imgs/buttonEnviar.png" alt="Botão enviar">
			</button>


		</form>
    </div>


    <div id="imagem">
      <img src="../imgs/logoCores.png" id="imagemLogo" alt="Logo da empresa Color Personalizações">
    </div>

    <div id="mapa">
      <p id="contatoTexto">Empresa Color Personalizações</p>
      <p class="dadoEmpresa">Telefone: (47) XXXX-XXXX</p>
      <p class="dadoEmpresa">Email: colorPersonaliza2019@gmail.com</p>
	  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28623.65282149928!2d-48.86540085749801!3d-26.263071841410515!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94deafbe3ebf0c05%3A0x624c0303ba7bf8a7!2sSENAI+Joinville+Norte+I!5e0!3m2!1spt-BR!2sbr!4v1559063839445!5m2!1spt-BR!2sbr" id=mapaLocal></iframe>
      <p id="localTexto">Localizado em: <br>
                Rua Arno Waldemar Dohler,957 - Zona Industrial Norte <br>
                Joinville - SC , 89218-155</p>
    </div>
    <?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==1){
        $msgPopup="Sucesso ao enviar e-mail.";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==0){
        $msgPopup="Erro ao enviar e-mail.";
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
<?php
// }else{
//   header("Location: ../index.php");
// }

 ?>
