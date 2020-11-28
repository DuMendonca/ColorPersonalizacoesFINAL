
var cont=1;
var produtos = $("#todosOsProdutos").val();
var valoresJaAdicionadosAoTotal = []; //vamos usar depois!
function adicionaProduto(){
    $("#formCadastro").append(
    '<div id="div'+cont+'">'+
        '<label class="campos">Produtos:</label>'+
        '<select class="camposForm" id="produtos'+cont+'" name="produtos[]" onchange="retornaValorUnitarioProduto('+cont+')" required>'+produtos+'</select>'+

        '<label class="campos">Especificação da Estampa:</label>'+
        '<input class="camposForm" type="text" name="especifica[]" placeholder="Insira a especificação..." required>'+

        '<label class="campos">Valor unitário:</label>'+
        '<input class="camposForm" type="text" name="valoresUnitarios[]" id="vlUnitario'+cont+'" readonly="readonly" required>'+

        '<label class="campos">Quantidade:</label>'+
        '<input class="camposForm" type="number" name="qtdeProduto[]" min="1" onblur="atualizaValorTotal(this.value,'+cont+')" id="qtde'+cont+'" required>'+



        '<button type="button" onclick="adicionaProduto()" class="botoes"> <img src="../imgs/plus.png" alt="Botão de mais"> </button>'+
        '<button type="button" onclick="removeProduto('+cont+')" class="botoes"> <img src="../imgs/minus.png" alt="Botão de menos"> </button>'+
    '</div>'

    );

    cont=cont+1;
}

function removeProduto(cont){
  var valorTotalAtualPedido = $("#valorTotal").val();
  var produtoSelecionado = $("#produtos"+cont).val();

  if((valorTotalAtualPedido != 0.00) && (produtoSelecionado != 0)){
      var valorUnitario = $("#vlUnitario"+cont).val();
      var qtde = $("#qtde"+cont).val();
      var valorAReduzir = parseFloat(valorUnitario) * parseInt (qtde);
      $("#valorTotal").val(valorTotalAtualPedido-valorAReduzir);
  }
  $("#div"+cont).remove();
}

function atualizaValorTotal(qtde,cont){
  var produtoSelecionado = $("#produtos"+cont).val();
  var valorJaAdicionado = valoresJaAdicionadosAoTotal[cont];
  var valorTotalAtual = document.getElementById("valorTotal").value;
  var valorUnitarioProduto = document.getElementById("vlUnitario"+cont).value;
  if((produtoSelecionado != 0) && (valorJaAdicionado == null)) {
      valorTotalAtual = parseFloat(valorTotalAtual);
      valorUnitarioProduto = parseFloat(valorUnitarioProduto);
      var valorAtualizado = (valorUnitarioProduto * qtde)+valorTotalAtual;
      $("#valorTotal").val(valorAtualizado);
  }else if((produtoSelecionado != 0) && (valorJaAdicionado != null)) {

    valorTotalAtual = parseFloat(valorTotalAtual);
    valorUnitarioProduto = parseFloat(valorUnitarioProduto);
    $("#valorTotal").val((valorTotalAtual-valorJaAdicionado)+valorUnitarioProduto * qtde);
  }
  valoresJaAdicionadosAoTotal[cont]=(valorUnitarioProduto * qtde);
}



function retornaValorUnitarioProduto(cont){

    var campo= "#produtos"+cont;
    var codigoProduto=document.getElementById("produtos"+cont).value;
    var pagina="retornaValorUnitario.php"

    if(codigoProduto!=0){
      $.ajax({
        type:'POST',
        dataType:'html',
        url: pagina,
        data: {id:codigoProduto},
        success: function(valorUnitario){
          var inputVlUnitario = ("#vlUnitario"+cont);
          $(inputVlUnitario).val(valorUnitario);
        }//fechamento da função do SUCCESS
      });//FECHAMENTO DO AJAX
    }//FECHAMENTO DO IF

}//FECHAMENTO DA FUNCAO

function validaCampos(){
	var cliente = document.getElementById("clientes").value;
	var localEntrega = document.getElementById("localEntrega").value;
	var valorTotal = document.getElementById("valorTotal").value;
  var produtos = document.getElementById("produtos0").value;
	var msg = "";

	if (cliente=="0"){
		msg = msg + "Cliente\n";
	}
  if(localEntrega==""){
    msg = msg + "Local de Entrega\n";
  }
  if(valorTotal=="0.00"){
    msg = msg + "Valor Total\n";
  }
	if (produtos=="0"){
		msg = msg + "Produtos\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}
