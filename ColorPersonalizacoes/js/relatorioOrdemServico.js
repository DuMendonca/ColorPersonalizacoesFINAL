function validarCampos(){
	var cliente = document.getElementById("selectClientes").value;
	var func = document.getElementById("selectFuncionarios").value;
	var status = document.getElementById("selectStatus").value;
	if (cliente=="0" && func=="0" && status=="0"){
		alert("Por favor, preencha pelo menos 1 dos campos: \nCliente\nFuncionario\nStatus");
		return false;
	}
}