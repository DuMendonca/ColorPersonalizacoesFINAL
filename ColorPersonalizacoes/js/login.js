function validarCampos(){
	var email = document.getElementById("email").value;
	var senha = document.getElementById("senha").value;
	var msg = "";
	if (email=="" || email.indexOf("@")==-1 || email.indexOf(".")==-1){
		msg = msg + "Email \n";
	}
	if (senha==""){
		msg = msg + "Senha\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}
