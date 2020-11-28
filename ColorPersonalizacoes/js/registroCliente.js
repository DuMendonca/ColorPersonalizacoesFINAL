var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

$('#tel1').mask(SPMaskBehavior, spOptions);
$('#tel2').mask(SPMaskBehavior, spOptions);
function validarCampos(){
	var nome = document.getElementById("nome").value;
	var cpfCnpj = document.getElementById("cpfCnpj").value;
	var tel = document.getElementById("tel1").value;
	var rua = document.getElementById("rua").value;
	var bairro = document.getElementById("bairro").value;
	var numero = document.getElementById("numero").value;
	var cidade = document.getElementById("cidade").value;
	var estado = document.getElementById("estado").value;
	var cep = document.getElementById("cep").value;
	var msg = "";
	if (nome==""){
		msg = msg + "Nome\n";
	}
	if (cpfCnpj.length!=11 && cpfCnpj.length!=14){
		msg = msg + "Cpf/Cnpj\n";
	}
	if (tel.length!=14 && tel.length!=15){
		msg = msg + "Telefone 1\n";
	}
	if (rua==""){
		msg = msg + "Rua\n";
	}
	if (bairro==""){
		msg = msg + "Bairro\n";
	}
	if (numero==""){
		msg = msg + "Número\n";
	}
	if (cidade==""){
		msg = msg + "Cidade\n";
	}
	if (estado=="1"){
		msg = msg + "Estado\n";
	}
	if (cep == "" || cep.length != 8) {
		msg = msg + "Cep\n";
	}
	if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
	}
}
