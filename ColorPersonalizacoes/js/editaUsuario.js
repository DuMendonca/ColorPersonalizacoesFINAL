function validarCampos(){
	var email = document.getElementById("email").value;
	var nome = document.getElementById("nome").value;
	var nivel = document.getElementById("nivel").value;
	var msg = "";
	if (email=="" || email.indexOf("@")==-1 || email.indexOf(".")==-1){
		msg = msg + "Email \n";
	}
	if (nome==""){
		msg = msg + "Nome\n";
	}
	if (nivel=="0"){
		msg = msg + "Nível de usuário\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}else {
	}
}
