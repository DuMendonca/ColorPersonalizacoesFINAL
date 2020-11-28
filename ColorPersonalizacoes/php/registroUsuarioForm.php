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
  <script src="../js/registroUsuario.js"></script>
</head>
<body>

<?php include("menuAdm.php"); ?>

<section id="registroUsuario">
  <h1>Registro de Usuários</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Cadastro de usuários</legend>
      <form action="registroUsuario.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">

        <label class="campos" for="email">*Email:</label>
        <input class="camposForm" maxlength="45" type="email" name="email" id="email" placeholder="Insira o email do usuário">
        <label class="campos" for="senha">*Senha:</label>
        <input class="camposForm" maxlength="15" type="password" name="senha" id="senha" placeholder="Insira a senha do usuário">
        <br>

        <label class="campos" for="nome">*Nome do funcionário:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira o nome do funcionário">

        <label class="campos" for="nivel">*Nível de usuário:</label>
        <select name="nivel" id="nivel">
          <option value="0" selected>Selecione...</option>
          <option value="1">Atendente</option>
          <option value="2">Estampador</option>
          <option value="3">Gerente</option>
        </select>
        <br>
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
      <legend>Consulta de usuário</legend>
      <form action="registroUsuarioForm.php" method="GET">
        <label for="consultaNomeUsuario" id="labelConsultaUsuario">Nome do funcionario:</label>
        <input type="text" name="consultaNomeUsuario" id="consultaNomeUsuario" placeholder="Procure pelo nome do usuário">
        <button type="submit">Buscar</button>
      </form>

      <table>
        <tr>
          <th>Email</th>
          <th>Nome do Funcionário</th>
          <th>Nível</th>
          <th>Ações</th>
        </tr>
        <?php
          require_once("conexaoBanco.php");
          if (isset($_GET["consultaNomeUsuario"])==false) {
            $comando1= "SELECT * FROM usuarios";
          }
          elseif (isset($_GET["consultaNomeUsuario"])==true && $_GET["consultaNomeUsuario"]=="") {
            $comando1= "SELECT * FROM usuarios";
          }elseif (isset($_GET["consultaNomeUsuario"])==true && $_GET["consultaNomeUsuario"]!="") {
            $busca  = $_GET["consultaNomeUsuario"];
            $comando1= "SELECT * FROM usuarios WHERE nome_func LIKE '".$busca."%'";
          }
          $resultado1 = mysqli_query($conexao, $comando1);
          $linhas = mysqli_num_rows($resultado1);
          if($linhas==0){
            ?>
            <tr>
              <td colspan=4>Nenhum usuário com esse nome encontrado</td>
            </tr>
            <?php

          }else{
        $usuariosRetorno = array();
        while($cadaRow = mysqli_fetch_assoc($resultado1)){
            array_push($usuariosRetorno, $cadaRow);
        }
        foreach ($usuariosRetorno as $cadaUsuario) {
          ?>
          <tr>
            <td> <?php echo $cadaUsuario["email"] ?></td>
            <td> <?php echo $cadaUsuario["nome_func"] ?></td>
            <td> <?php
                if($cadaUsuario['nivel']==1){
                  echo "Atendente";
                }else if($cadaUsuario['nivel']==2){
                  echo "Estampador";
                }else{
                  echo "Gerente";
                }
            ?></td>
            <td>
              <form action="editaUsuarioForm.php" method="POST" class="formBotao">
                <input type="hidden" name="editaUsuario" value="<?=$cadaUsuario["codigo"];?>" id="editaUsuario">
                <button type="submit"><img src="../imgs/pencil.png" alt="Botão lápis"></button>
              </form>
              <form action="excluiUsuario.php" method="POST" class="formBotao">
                <input type="hidden" name="excluiUsuario" value="<?=$cadaUsuario["codigo"];?>" id="excluirUsuario">
                <button type="submit"><img src="../imgs/trash.png" alt="Botão lixeiro"></button>
              </form>
            </td>
          </tr>
          <?php

            }//Fechamento do foreach
             }//Fechamento else
        ?>



      </table>

    </fieldset>
  </div>
</main>
  <?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro ao realizar a operação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Operação realizada com sucesso!";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==2){
        $msgPopup="Não é possível excluir usuário que está em algum orçamento!";
        include ("../alertas/erro.php");
      }
    }
  ?>
</body>
</html>
<?php
  }  //fechamento do IF
  else{
    header("Location: login.php");
  }
?>