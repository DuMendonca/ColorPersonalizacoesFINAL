<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==1){
require_once("conexaoBanco.php");
?>
<?php
//Salvar os produtos nas variaveis pah
function mostraProdutos($conexao){
    $comandoMostrarProdutos = "SELECT * FROM produtos";
    $resultadoMostrarProdutos=mysqli_query($conexao, $comandoMostrarProdutos);
    $produtosMostrar=array();

    while($cadaProdutoMostrar = mysqli_fetch_assoc($resultadoMostrarProdutos)) {
       array_push($produtosMostrar, $cadaProdutoMostrar);
    }
    $options="<option value='0'>Selecione...</option>";
    foreach ($produtosMostrar as $cadaProdutoMostrar) {

        $options.="<option value='".$cadaProdutoMostrar['codigo']."'>".$cadaProdutoMostrar['nome']."</option>";
    }
    return $options;
}
 ?>
<input id="todosOsProdutos" type="hidden" value="<?=mostraProdutos($conexao);?>">
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Color Personalizações</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/orcamento.css">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/funcoesOrcamentoEdicao.js"></script>
  </head>
  <body>

      <?php
      //Parada dos menus la
      if ($_SESSION['nivelLogado']==1){
      include("menuAtendente.php");
      }else if ($_SESSION['nivelLogado']==3){
      include("menuAdm.php");
      }
      ?>

      <section id="registroOrcamento">
        <h1>Edição de Orçamentos</h1>
      </section>

      <?php
      $idOrcamento = $_POST['editaOrcamento'];

      $comando = "SELECT orca.codigo, orca.parcelas, orca.local_entrega,
      orca.desconto, orca.clientes_id, orca.valor_total, prodorca.produtos_codigo,
      prodorca.preco_atual, prodorca.quantidade, prodorca.especificacao
      FROM orcamentos AS orca INNER JOIN orcamentos_tem_produtos AS prodorca
      ON prodorca.orcamentos_codigo = orca.codigo WHERE orca.codigo=".$idOrcamento.";";
      $resultado = mysqli_query($conexao, $comando);

      $comando2 = "SELECT valor_total, data_emissao, parcelas, desconto, local_entrega FROM orcamentos WHERE codigo=".$idOrcamento.";";
      $resultado2 = mysqli_query($conexao, $comando2);
      $outraInfos = mysqli_fetch_assoc($resultado2);

      $itensOrcamento = array();
      while ($cadaOrca = mysqli_fetch_assoc($resultado)){
        array_push($itensOrcamento, $cadaOrca);
        $codigoUsuario = $cadaOrca['clientes_id'];
      }

       ?>
      <main>
        <div class="divs" id="divCadastro">
          <fieldset id="fieldCadastro">
            <legend >Dados do gerais:</legend>
              <form action="editaOrcamento.php" method="POST" id="formCadastro" onsubmit="return validaCampos()">
                <input type="hidden" value="<?=$idOrcamento?>" id="idDoOrcamento" name="idDoOrcamento">
                <label class="campos" for="clientes">Cliente:</label>
                  <select id="clientes" name="clientes">
                    <option value="0">Selecione...</option>
                    <?php
                      $comandoCliente = "SELECT id, nome FROM clientes";
                      $resultadoCliente =mysqli_query($conexao,$comandoCliente);
                			$clientes = array();
                      while ($cadaCliente = mysqli_fetch_assoc($resultadoCliente)){
                            array_push($clientes, $cadaCliente);
                      }
                      foreach ($clientes as $cadaCliente) {
                    if($cadaCliente['id']==$codigoUsuario){
                    ?>
                    <option value="<?=$cadaCliente['id'];?>" selected="selected">
                      <?=$cadaCliente['nome'];?>
                    </option>
                    <?php
                  }else{
                    ?>
                    <option value="<?=$cadaOrca['id'];?>">
                      <?=$cadaCliente['nome'];?>
                    </option>
                    <?php
                  }
                      }
                     ?>
                  </select>
                <label class="campos" for="parcelas">Parcelas:</label>
                <input class="camposForm" type="number" name="parcelas" id="parcelas" value="<?=$outraInfos['parcelas']?>" min="0" placeholder="Insira o número de parcelas...">
                <br>
                <label class="campos" for="localEntrega">Local de Entrega:</label>
                <input class="camposForm" type="text" name="localEntrega" id="localEntrega" value="<?=$outraInfos['local_entrega']?>" placeholder="Insira o local de entrega...">
                <label class="campos" for="desconto">Desconto:</label>
                <input class="camposForm" type="text" name="desconto" id="desconto" value="<?=$outraInfos['desconto']?>"
                placeholder="Insira o desconto (Se tiver)...">
                <br>
                <label class="campos" for="valorTotal">Valor total</label>
                <input class="camposForm" type="text" id="valorTotal" step="any" value="<?=$outraInfos['valor_total']?>" name="valorTotal" readonly="readonly" required><br>
                <button type="reset" onclick="location.reload();" class="botoes">
                  <img class="botoesImg" src="../imgs/buttonResetarCampos.png" alt="Botão para limpar os campos">
                </button>
                <button type="submit" class="botoes">
                  <img class="botoesImg" src="../imgs/buttonEditar.png" alt="Botão para gerar um orçamento">
                </button>

                <?php
                $cont=0;
                foreach($itensOrcamento as $cadaItem){
                //BAAAAAAAAAAAAH
                ?>

                <div id="<?="div".$cont;?>">
                    <label class="campos">Produtos*:</label>
                    <select class="camposForm" name="produtos[]" onchange="retornaValorUnitarioProduto(0)" id="<?="produtos".$cont;?>?" required>
                        <?php
                        $comando3 = "SELECT * FROM produtos";
                        $resultado3 = mysqli_query($conexao, $comando3);
                        $produtos = array();

                        while ($cadaProduto = mysqli_fetch_assoc($resultado3)) {
                          array_push($produtos, $cadaProduto);
                        }
                        foreach($produtos as $cadaProduto){
                          if($cadaItem['produtos_codigo']==$cadaProduto['codigo']){
                          ?>
                            <option selected value="<?=$cadaProduto['codigo'];?>">
                              <?=$cadaProduto['nome'];?>
                            </option>
                          <?php
                        }else{
                          ?>
                          <option  value="<?=$cadaProduto['codigo'];?>">
                            <?=$cadaProduto['nome'];?>
                          </option>
                          <?php
                        }
                        }
                        ?>
                    </select>
                    <label class="campos">Especificação da Estampa*:</label>
                    <input class="camposForm" type="text" name="especifica[]" placeholder="Insira a especificação..." value="<?=$cadaItem['especificacao']?>" required>

                    <label class="campos">Valor unitário*:</label>
                    <input class="camposForm" type="text" id="<?="vlUnitario".$cont;?>" name="valoresUnitarios[]" required value="<?=$cadaItem['preco_atual']?>" readonly="readonly">

                    <label class="campos">Quantidade*:</label>
                    <input class="camposForm" type="number" name="qtdeProduto[]" value="<?=$cadaItem['quantidade']?>" min="1" onblur="atualizaValorTotal(this.value,<?=$cont;?>)" id="<?="qtde".$cont;?>" required>
                    <button type="button" onclick="adicionaProduto()" class="botoes"><img src="../imgs/plus.png" alt="Botão de mais"></button>

                    <?php
                    if($cont>0){
                      ?>

                    <button type="button" onclick="removeProduto(<?=$cont;?>)" class="botoes"><img src="../imgs/minus.png" alt="Botão de menos"></button>
                    <?php
                  }
                    ?>
                </div>
                <?php
                $cont=$cont+1;
              }
                ?>
                </form>
          </fieldset>
        </div>
      </main>

  </body>
</html>
<?php
}//Fechamento do if la de cimao
else{
  header("Location: login.php");
}
?>
