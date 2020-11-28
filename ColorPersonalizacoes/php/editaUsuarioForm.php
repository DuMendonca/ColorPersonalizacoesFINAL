<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/registroUsuario.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="../js/editaUsuario.js"></script>
</head>
<body>

<?php include("menuAdm.php"); ?>

<section id="registroUsuario">
  <h1>Edição de Usuários</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Dados do usuários</legend>
      <?php
        require_once("conexaoBanco.php");
        $codigoUsuario = $_POST['editaUsuario'];
        $comando="SELECT * FROM usuarios WHERE codigo=".$codigoUsuario;
        $resultado=mysqli_query($conexao, $comando);
        $usuarios=mysqli_fetch_assoc($resultado);
      ?>
      <form action="editaUsuario.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">
        <input type="hidden" name="codigo" value="<?=$usuarios['codigo'];?>">
        <label class="campos" for="email">Email:</label>
        <input class="camposForm" maxlength="45" type="email" name="email" id="email" placeholder="Insira o email do usuário" value="<?=$usuarios['email'];?>">
        <label class="campos" for="senha">Senha:</label>
        <input class="camposForm" maxlength="15" type="text" name="senha" id="senha" placeholder="Insira a senha do usuário" >
        <br>

        <label class="campos" for="nome">Nome do funcionário:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira o nome do funcionário" value="<?=$usuarios['nome_func'];?>">

        <label class="campos" for="nivel">Nível de usuário:</label>
        <select name="nivel" id="nivel">
          <?php
            $nivel = $usuarios['nivel'];
            if($nivel==1){
          ?>
          <option value="0">Selecione...</option>
          <option value="1" selected>Atendente</option>
          <option value="2">Estampador</option>
          <option value="3">Gerente</option>
          <?php
            }else if($nivel==2){
          ?>
            <option value="0">Selecione...</option>
            <option value="1">Atendente</option>
            <option value="2" selected>Estampador</option>
            <option value="3">Gerente</option>
          <?php
            }else{
          ?>
            <option value="0">Selecione...</option>
            <option value="1">Atendente</option>
            <option value="2">Estampador</option>
            <option value="3" selected>Gerente</option>
          <?php
            }
          ?>

        </select>
        <br>
        <button type="reset" class="botoes">
          <img class="botoesImg" src="../imgs/buttonResetarCampos.png" alt="Botão limpa campos">
        </button>
        <button type="submit" class="botoes">
          <img class="botoesImg" src="../imgs/buttonEditar.png" alt="Botão enviar">
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