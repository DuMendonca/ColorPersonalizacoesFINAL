<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && ($_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1)){

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
  <h1>Edição de Cliente</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro">
      <legend >Dados do clinete</legend>
      <?php
        require_once("conexaoBanco.php");
        $idCliente = $_POST['editaCliente'];
        $comando="SELECT * FROM clientes WHERE id=".$idCliente;
        $resultado=mysqli_query($conexao, $comando);
        $cliente=mysqli_fetch_assoc($resultado);
      ?>
      <form action="editaCliente.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">
        <input type="hidden" name="id" value="<?= $cliente['id']?>">

        <label class="campos" for="nome">*Nome completo:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira nome completo aqui" value="<?= $cliente['nome']?>">

        <label class="campos" for="cpfCnpj">*CPF/CNPJ:</label>
        <input class="camposForm" type="text" name="cpfCnpj" id="cpfCnpj" placeholder="Insira cpf ou cnpj" value="<?php
          if($cliente['cpf'] == ''){
            echo $cliente['cnpj'];
          }else{
            echo $cliente['cpf'];
          }
        ?>">
        <br>

        <label class="campos" for="email">E-mail:</label>
        <input class="camposForm" type="email" name="email" id="email" placeholder="exemplo@email.com" value="<?= $cliente['email']?>">
        <label class="campos" for="inscricaoEstadual">Inscrição Estadual</label>
        <input class="camposForm" type="text" name="inscricaoEstadual" id="inscricaoEstadual" placeholder="Insira a inscrição estadual" value="<?= $cliente['inscricao_estadual']?>"><br>

        <label class="campos" for="tel1">*Telefone 1:</label>
        <input class="camposForm" type="text" name="tel1" id="tel1" placeholder="(xx) xxxx-xxxx" value="<?= $cliente['tel1']?>">
        <label class="campos" for="tel2">Telefone 2:</label>
        <input class="camposForm" type="text" name="tel2" id="tel2" placeholder="(xx) 9xxxx-xxxx" value="<?= $cliente['tel2']?>"><br>

        <label class="campos" for="rua">*Rua:</label>
        <input class="camposForm" type="text" name="rua" id="rua" placeholder="Insira a rua do cliente" value="<?= $cliente['rua']?>">
        <label class="campos" for="bairro">*Bairro:</label>
        <input class="camposForm" type="text" name="bairro" id="bairro" placeholder="Insira o bairro do cliente" value="<?= $cliente['bairro']?>">
        <label class="campos" for="numero">*Número:</label>
        <input class="camposForm" type="text" name="numero" id="numero" placeholder="Insira o numero do cliente" value="<?= $cliente['numero']?>"><br>

        <label class="campos" for="cidade">*Cidade</label>
        <input class="camposForm" type="text" name="cidade" id="cidade" placeholder="Insira a cidade do cliente" value="<?= $cliente['cidade']?>">
        <label class="campos" for="estado">*Estado</label>
        <select id="estado" name="estado">
          <option value="1">Selecione...</option>
          <option value="AC" <?=($cliente['estado'] == 'AC')? 'selected' : ''?> >Acre</option>
          <option value="AL" <?=($cliente['estado'] == 'AL')? 'selected' : ''?> >Alagoas</option>
          <option value="AP" <?=($cliente['estado'] == 'AP')? 'selected' : ''?> >Amapá</option>
          <option value="AM" <?=($cliente['estado'] == 'AM')? 'selected' : ''?> >Amazonas</option>
          <option value="BA" <?=($cliente['estado'] == 'BA')? 'selected' : ''?> >Bahia</option>
          <option value="CE" <?=($cliente['estado'] == 'CE')? 'selected' : ''?> >Ceará</option>
          <option value="DF" <?=($cliente['estado'] == 'DF')? 'selected' : ''?> >Distrito Federal</option>
          <option value="ES" <?=($cliente['estado'] == 'ES')? 'selected' : ''?> >Espírito Santo</option>
          <option value="GO" <?=($cliente['estado'] == 'GO')? 'selected' : ''?> >Goiás</option>
          <option value="MA" <?=($cliente['estado'] == 'MA')? 'selected' : ''?> >Maranhão</option>
          <option value="MT" <?=($cliente['estado'] == 'MT')? 'selected' : ''?> >Mato Grosso</option>
          <option value="MS" <?=($cliente['estado'] == 'MS')? 'selected' : ''?> >Mato Grosso do Sul</option>
          <option value="MG" <?=($cliente['estado'] == 'MG')? 'selected' : ''?> >Mina Gerais</option>
          <option value="PA" <?=($cliente['estado'] == 'PA')? 'selected' : ''?> >Pará</option>
          <option value="PB" <?=($cliente['estado'] == 'PB')? 'selected' : ''?> >Paraíba</option>
          <option value="PR" <?=($cliente['estado'] == 'PR')? 'selected' : ''?> >Paraná</option>
          <option value="PE" <?=($cliente['estado'] == 'PE')? 'selected' : ''?> >Pernambuco</option>
          <option value="PI" <?=($cliente['estado'] == 'PI')? 'selected' : ''?> >Piauí</option>
          <option value="RJ" <?=($cliente['estado'] == 'RJ')? 'selected' : ''?> >Rio de Janeiro</option>
          <option value="RN" <?=($cliente['estado'] == 'RN')? 'selected' : ''?> >Rio Grande do Norte</option>
          <option value="RS" <?=($cliente['estado'] == 'RS')? 'selected' : ''?> >Rio Grande do Sul</option>
          <option value="RO" <?=($cliente['estado'] == 'RO')? 'selected' : ''?> >Rondônia</option>
          <option value="RR" <?=($cliente['estado'] == 'RR')? 'selected' : ''?> >Roraima</option>
          <option value="SC" <?=($cliente['estado'] == 'SC')? 'selected' : ''?> >Santa Catarina</option>
          <option value="SP" <?=($cliente['estado'] == 'SP')? 'selected' : ''?> >São Paulo</option>
          <option value="SE" <?=($cliente['estado'] == 'SE')? 'selected' : ''?> >Sergipe</option>
          <option value="TO" <?=($cliente['estado'] == 'TO')? 'selected' : ''?> >Tocantins</option>
        </select>
        <label class="campos" for="cep">CEP</label>
        <input class="camposForm" type="text" name="cep" id="cep" placeholder="Insira o CEP do cliente" value="<?= $cliente['cep']?>">
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
</main>
</body>
</html>
<?php
    }  
else{
  header("Location: login.php");
}
?>