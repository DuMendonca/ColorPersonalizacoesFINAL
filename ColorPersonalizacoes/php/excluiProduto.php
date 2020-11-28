<?php
function formataString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    return $str;
}
require_once("conexaoBanco.php");
$codigo = $_POST['codigoProduto'];
$comando = "SELECT codigo FROM produtos WHERE codigo=".$codigo;
$resultado = mysqli_query($conexao, $comando);
$linhas = mysqli_num_rows($resultado);
if($linhas==0){
  header("Location: registroProdutoForm.php?retorno=0");
}else {
	$comando2 = "SELECT imagem, categorias_codigo FROM produtos WHERE codigo = ".$codigo;
	$resultado2 = mysqli_query($conexao, $comando2);
	$produtoInfos = mysqli_fetch_assoc($resultado2);

	$comando3 = "SELECT nome FROM categorias WHERE codigo=".$produtoInfos['categorias_codigo'];
	$resultado3 = mysqli_query($conexao,$comando3);
	$nomeCat = mysqli_fetch_assoc($resultado3);
	$categoriaNome = strtolower(formataString($nomeCat['nome']));

	$comando4 = "DELETE FROM produtos WHERE codigo =".$codigo;
	$resultado4 = mysqli_query($conexao, $comando4);
	$erro4=mysqli_errno($conexao);
	if($resultado4){
		unlink("../imgs/".$categoriaNome."/".$produtoInfos['imagem']);
		$pasta = '../imgs/'.$categoriaNome;
		$arquivos = glob("$pasta{*.jpg,*.JPG,*.png,*.gif,*.bmp}", GLOB_BRACE);
		$i = 0;
		foreach($arquivos as $img){
		    $i++;
		}
		if ($i==0){
			rmdir($pasta);
		}
		header("Location: registroProdutoForm.php?retorno=1");
	}else {
		if ($erro4==1451){
			header("Location: registroProdutoForm.php?retorno=2");
		}else{
			header("Location: registroProdutoForm.php?retorno=0");
		}
	}
}
 ?>
