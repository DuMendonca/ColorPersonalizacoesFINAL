<?php
function formataString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str);
    return $str;
}
require_once("conexaoBanco.php");
$nomeP=$_POST['nome'];
$cat=$_POST['categoria'];

$comando = "SELECT nome FROM categorias WHERE codigo=".$cat;
$resultado = mysqli_query($conexao,$comando);
$nomeCat = mysqli_fetch_assoc($resultado);
$nomeCat['nome'];
$categoriaNome = strtolower(formataString($nomeCat['nome']));
$desc=$_POST['descricao'];
$preco=$_POST['preco'];
$preco = preg_replace("/,/",".", $preco);
$caminhoImagem = "";
$novoNome = "";
if ( isset( $_FILES[ 'imagem' ][ 'name' ] ) && $_FILES[ 'imagem' ][ 'error' ] == 0 ) { // Verifica se o arquivo existe
 
    $arquivo_tmp = $_FILES[ 'imagem' ][ 'tmp_name' ];
    $nome = $_FILES[ 'imagem' ][ 'name' ];
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION ); // Pega a extensão
    $extensao = strtolower ( $extensao ); // Converte a extensão para minúsculo
    

    if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {    // Somente imagens, .jpg;.jpeg;.gif;.png
        $novoNome = uniqid ( time () ) . '.' . $extensao; // Cria um nome único para esta imagem
        $caminhoImagem = "../imgs/".$categoriaNome."/".$novoNome; // Concatena a pasta com o nome
        if (!is_dir("../imgs/".$categoriaNome)) { // Verifica se tem pasta da categoria
        	mkdir("../imgs/".$categoriaNome, 0777); //Cria pasta categoria
        }
        
        if ( @move_uploaded_file ( $arquivo_tmp, $caminhoImagem ) ) { 
            // tenta mover o arquivo para o destino
        }else{
            header("Location: registroProdutoForm.php?retorno=3");
        }
    }else{ // Se imagem não é .jpg;.jpeg;.gif;.png volta com erro
        header("Location: registroProdutoForm.php?retorno=3");
    }
}else{ // Se tiver passado a verificação de campo da imagem
    header("Location: registroProdutoForm.php?retorno=3");
}

$comando2="INSERT INTO produtos (nome, preco_unitario, descricao, categorias_codigo, imagem) VALUES ('".$nomeP."', ".$preco.", '".$desc."',".$cat.",'".$novoNome."')";
$resultado2=mysqli_query($conexao,$comando2);
if($resultado2){
	header("Location: registroProdutoForm.php?retorno=1");
    $extensao;
}else{
	header("Location: registroProdutoForm.php?retorno=0");
}
?>
