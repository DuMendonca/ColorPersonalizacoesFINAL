$("#preco").mask("000,00", {reverse:true});
function validarCampos(){
	var nome = document.getElementById("nome").value;
	var preco = document.getElementById("preco").value;
	var categoria = document.getElementById("categoria").value;
	var msg = "";
	if (nome==""){
		msg = msg + "Nome\n";
	}
	if (categoria=="0"){
		msg = msg + "Categoria\n";
	}
	if (preco==""){
		msg = msg + "Preço\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}