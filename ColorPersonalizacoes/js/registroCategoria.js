function validarCampos(){
	var nome = document.getElementById("nome").value;
	var descricao = document.getElementById("descricao").value;
	var msg = "";
	if (nome==""){
		msg = msg + "Nome\n";
	}
	if (descricao==""){
		msg = msg + "Descrição\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}