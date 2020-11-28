var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

$('#telefone').mask(SPMaskBehavior, spOptions);
function validarCampos(){
	var nome = document.getElementById("nome").value;
	var email = document.getElementById("email").value;
	var telefone = document.getElementById("telefone").value;
	var radio1 = document.getElementById("radio1").checked;
	var radio2 = document.getElementById("radio2").checked;
	var radio3 = document.getElementById("radio3").checked;
  var radio4 = document.getElementById("radio4").checked;
	var mensagem = document.getElementById("mensagem").value;
	var msg = "";
	if (nome==""){
		msg = msg + "Nome \n";
	}
	if (email=="" || email.indexOf("@")==-1 || email.indexOf(".")==-1){
		msg = msg + "Email \n";
	}
	if (telefone.length!=14 && telefone.length!=15){
		msg = msg + "Telefone \n";
	}
	if (radio1==false && radio2 ==false && radio3==false && radio4==false){
		msg = msg + "Tema da mensagem \n";
	}
	if (mensagem==""){
		msg = msg + "Mensagem \n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}
