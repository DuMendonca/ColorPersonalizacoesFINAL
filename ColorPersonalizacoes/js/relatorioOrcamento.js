function validarCampos(){
	var cliente = document.getElementById("cliente").value;
	var status = document.getElementById("status").value;
	if (cliente=="0" && status=="0"){
		alert("Por favor, preencha pelo menos 1 dos campos: \nCliente\nStatus");
		return false;
	}
}