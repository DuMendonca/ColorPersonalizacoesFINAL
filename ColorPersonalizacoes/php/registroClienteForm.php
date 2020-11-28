<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && ($_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1)){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/registroCliente.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="../js/registroCliente.js"></script>
</head>
<body>

<?php
if ($_SESSION['nivelLogado']==1){
  include("menuAtendente.php");
}elseif($_SESSION['nivelLogado']==3){
  include("menuAdm.php");
}
?>

<section id="registroCliente">
  <h1>Registro Clientes</h1>
</section>

<main id="conteudoPrincipal">
  <div class="divs" id="divCadastro">
    <fieldset id="fieldCadastro"> 
      <legend >Cadastro de clientes</legend>
      <form action="registroCliente.php" method="POST" id="formCadastro" onsubmit="return validarCampos()">
        
        <label class="campos" for="nome">*Nome completo:</label>
        <input class="camposForm" type="text" name="nome" id="nome" placeholder="Insira nome completo aqui">
        <label class="campos" for="cpfCnpj">*CPF/CNPJ:</label>
        <input class="camposForm" type="text" name="cpfCnpj" id="cpfCnpj" placeholder="Insira cpf ou cnpj">
        <br>

        <label class="campos" for="email">E-mail:</label>
        <input class="camposForm" type="email" name="email" id="email" placeholder="exemplo@email.com">
        <label class="campos" for="inscricaoEstadual">Inscrição Estadual</label>
        <input class="camposForm" type="text" name="inscricaoEstadual" id="inscricaoEstadual" placeholder="Insira a inscrição estadual"><br>

        <label class="campos" for="tel1">*Telefone 1:</label>
        <input class="camposForm" type="text" name="tel1" id="tel1" placeholder="(xx) xxxx-xxxx">
        <label class="campos" for="tel2">Telefone 2:</label>
        <input class="camposForm" type="text" name="tel2" id="tel2" placeholder="(xx) 9xxxx-xxxx"><br>

        <label class="campos" for="rua">*Rua:</label>
        <input class="camposForm" type="text" name="rua" id="rua" placeholder="Insira a rua do cliente">
        <label class="campos" for="bairro">*Bairro:</label>
        <input class="camposForm" type="text" name="bairro" id="bairro" placeholder="Insira o bairro do cliente">
        <label class="campos" for="numero">*Número:</label>
        <input class="camposForm" type="text" name="numero" id="numero" placeholder="Insira o numero do cliente"><br>

        <label class="campos" for="cidade">*Cidade</label>
        <input class="camposForm" type="text" name="cidade" id="cidade" placeholder="Insira a cidade do cliente">
        <label class="campos" for="estado">*Estado</label>
        <select id="estado" name="estado">
          <option value="1">Selecione...</option>
          <option value="AC">Acre</option>
          <option value="AL">Alagoas</option>
          <option value="AP">Amapá</option>
          <option value="AM">Amazonas</option>
          <option value="BA">Bahia</option>
          <option value="CE">Ceará</option>
          <option value="DF">Distrito Federal</option>
          <option value="ES">Espírito Santo</option>
          <option value="GO">Goiás</option>
          <option value="MA">Maranhão</option>
          <option value="MT">Mato Grosso</option>
          <option value="MS">Mato Grosso do Sul</option>
          <option value="MG">Mina Gerais</option>
          <option value="PA">Pará</option>
          <option value="PB">Paraíba</option>
          <option value="PR">Paraná</option>
          <option value="PE">Pernambuco</option>
          <option value="PI">Piauí</option>
          <option value="RJ">Rio de Janeiro</option>
          <option value="RN">Rio Grande do Norte</option>
          <option value="RS">Rio Grande do Sul</option>
          <option value="RO">Rondônia</option>
          <option value="RR">Roraima</option>
          <option value="SC">Santa Catarina</option>
          <option value="SP">São Paulo</option>
          <option value="SE">Sergipe</option>
          <option value="TO">Tocantins</option>
        </select>
        <label class="campos" for="cep">*CEP</label>
        <input class="camposForm" type="text" name="cep" id="cep" placeholder="Insira o CEP do cliente">
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
      <legend>Consulta de cliente</legend>
      <form action="#" method="POST" id="formConsulta">
        <label for="consultaNomeCliente" id="labelConsultaNome">Nome:</label>
        <input type="text" name="consultaNomeCliente" id="consultaNomeCliente">
        <button type="submit">Buscar</button>
      </form>

      <table>
        <tr>
          <th>Código</th>
          <th>Nome</th>
          <th>CPF/CNPJ</th>
          <th>Ações</th>
        </tr>
       <?php
       require_once("conexaoBanco.php");

       if (isset($_POST["consultaNomeCliente"]) == false) {
         $comando = "SELECT * FROM clientes";
       }elseif (isset($_POST["consultaNomeCliente"]) == true && $_POST["consultaNomeCliente"] == "") {
         $comando = "SELECT * FROM clientes";
       }elseif (isset($_POST["consultaNomeCliente"]) == true && $_POST["consultaNomeCliente"] != "") {
        $busca = $_POST["consultaNomeCliente"];
        $comando = "SELECT * FROM clientes WHERE nome LIKE '%".$busca."%'";
       }

       $resultado = mysqli_query($conexao, $comando);
       $linhas = mysqli_num_rows($resultado);

       if ($linhas == 0) { ?>
          <tr>
            <td colspan="4">Nenhum cliente encontrado!</td>
          </tr>



         <?php
       }else{

        $clientesRetornados = array();

        while ($cadaLinha = mysqli_fetch_assoc($resultado)) {
         array_push($clientesRetornados, $cadaLinha);
        }

          foreach ($clientesRetornados as $cadaCliente) {
            ?>



            <tr>
              <td> <?php echo $cadaCliente['id']?></td>
              <td> <?php echo $cadaCliente['nome']?></td>
              <td> <?php
                if ($cadaCliente['cpf'] == "") {
                  echo $cadaCliente['cnpj'];
                }else{
                  echo $cadaCliente['cpf'];
                }

              ?></td>
              <td> 

            <form class="formBotao" action="editaClienteForm.php" method="post">
              <input type="hidden" name="editaCliente" value="<?=$cadaCliente['id']; ?>">
              <button class="botoesAcao" type="submit"><img src="../imgs/pencil.png"></button>
            </form>

            <form class="formBotao" action="excluiCliente.php" method="post">
              <input type="hidden" name="excluiCliente" value="<?=$cadaCliente['id']; ?>">
              <button class="botoesAcao" type="submit"><img src="../imgs/trash.png"></button>
            </form>

              </td> 
            </tr>
            <?php
          }
       }

      ?>
      
      </table>

    </fieldset>
  </div>
  <?php
    if(isset($_GET['retorno'])==true){
      if($_GET['retorno']==0){
        $msgPopup="Erro ao realizar a operação!";
        include ("../alertas/erro.php");
      }else if($_GET['retorno']==1){
        $msgPopup="Operação realizada com sucesso!";
        include ("../alertas/sucesso.php");
      }else if($_GET['retorno']==2){
        $msgPopup="Não é possível excluir cliente que está em algum orçamento!";
        include ("../alertas/erro.php");
      }
    }
  ?>
</main>
</body>
</html>
<?php
    }  
else{
  header("Location: login.php");
}
?>