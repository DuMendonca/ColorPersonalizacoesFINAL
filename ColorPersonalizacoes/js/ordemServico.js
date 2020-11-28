function validarCampos(){
  var func = document.getElementById("funcExecutor").value;
  var orc = document.getElementById("orcamento").value;
  var msg = "";

  if(func=="0"){
    msg = msg + "Funcionário Executor\n";
  }
  if(orc=="0"){
	msg = msg + "Código do orçamento\n";
  }

  if (msg!=""){
		alert("Por favor, preencha corretamente os campos: \n"+msg);
		return false;
  }else {
  }
}
