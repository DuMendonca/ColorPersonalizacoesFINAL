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

$codigo = $_POST['codigo'];
$nomeP = $_POST['nome'];
$categoria = $_POST['categoria'];
// Pega o nome da categoria e depois o id da antiga pra comparar
$comando = "SELECT nome FROM categorias WHERE codigo=".$categoria;
$resultado = mysqli_query($conexao,$comando);
$cat = mysqli_fetch_assoc($resultado);
$categoriaNome = formataString(strtolower($cat['nome']));
$comando2 = "SELECT categorias_codigo FROM produtos WHERE codigo=".$categoria;
$resultado2 = mysqli_query($conexao,$comando2);
$catAntiga = mysqli_fetch_assoc($resultado2);

$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$preco = preg_replace("/,/",".", $preco);
$preco = preg_replace("/[R$]/","", $preco);
$caminhoImagem = "";
$novoNome = "";

if ($catAntiga['categorias_codigo']!=$categoria && $_FILES[ 'imagem' ][ 'name' ]==""){
    $comando2 = "SELECT imagem, categorias_codigo FROM produtos WHERE codigo = ".$codigo;
    $resultado2 = mysqli_query($conexao, $comando2);
    $produtoInfos = mysqli_fetch_assoc($resultado2);

    $comando3 = "SELECT nome FROM categorias WHERE codigo=".$produtoInfos['categorias_codigo'];
    $resultado3 = mysqli_query($conexao,$comando3);
    $nomeCat = mysqli_fetch_assoc($resultado3);

    $caminhoAntigo=("../imgs/".$nomeCat['nome']."/".$produtoInfos['imagem']);
    $pasta = '../imgs/'.$nomeCat['nome'];

    $comando4 = "SELECT nome FROM categorias WHERE codigo=".$categoria;
    $resultado4 = mysqli_query($conexao,$comando4);
    $novaCat = mysqli_fetch_assoc($resultado4);
    $caminhoNovo = '../imgs/'.$novaCat['nome'].'/'.$produtoInfos['imagem'];
    if (!is_dir("../imgs/".$novaCat['nome'])) {
            mkdir("../imgs/".$novaCat['nome']);
        }
    rename($caminhoAntigo,$caminhoNovo);

    $arquivos = glob("$pasta/{*.jpg,*.JPG,*.png,*.gif,*.bmp}", GLOB_BRACE);
    if (count($arquivos)==0){
        rmdir($pasta);
    }
    $novoNome = $produtoInfos['imagem'];
}
if ( isset( $_FILES[ 'imagem' ][ 'name' ] ) && $_FILES[ 'imagem' ][ 'error' ] == 0 ) { // Verifica se o arquivo existe
 
    $arquivo_tmp = $_FILES[ 'imagem' ][ 'tmp_name' ];
    $nome = $_FILES[ 'imagem' ][ 'name' ];
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION ); // Pega a extensão
    $extensao = strtolower ( $extensao ); // Converte a extensão para minúsculo

    if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {    // Somente imagens, .jpg;.jpeg;.gif;.png
        $novoNome = uniqid ( time () ) . '.' . $extensao; // Cria um nome único para esta imagem
        $caminhoImagem = "../imgs/".$cat['nome']."/".$novoNome; // Concatena a pasta com o nome
        if (!is_dir("../imgs/".$cat['nome'])) {
        	mkdir("../imgs/".$cat['nome']);
        }


        if ( @move_uploaded_file ( $arquivo_tmp, $caminhoImagem ) ) {  // tenta mover o arquivo para o destino
            $comando2 = "SELECT imagem, categorias_codigo FROM produtos WHERE codigo = ".$codigo;
			$resultado2 = mysqli_query($conexao, $comando2);
			$produtoInfos = mysqli_fetch_assoc($resultado2);

			$comando3 = "SELECT nome FROM categorias WHERE codigo=".$produtoInfos['categorias_codigo'];
			$resultado3 = mysqli_query($conexao,$comando3);
			$nomeCat = mysqli_fetch_assoc($resultado3);
			unlink("../imgs/".$nomeCat['nome']."/".$produtoInfos['imagem']);
			$pasta = '../imgs/'.$nomeCat['nome'];
			$arquivos = glob("$pasta/{*.jpg,*.JPG,*.png,*.gif,*.bmp}", GLOB_BRACE);
            if (count($arquivos)==0){
                rmdir($pasta);
            }

        }else{
            header("Location: registroProdutoForm.php?retorno=0");
        }
        
    }else{ // Se imagem não é .jpg;.jpeg;.gif;.png volta com erro
        header("Location: registroProdutoForm.php?retorno=0");
    }
}else{ // Se tiver passado a verificação de campo da imagem
    $caminhoImagem = $_POST['nomeImagem'];
}
$comando = "UPDATE produtos SET nome = '".$nomeP."', categorias_codigo = ".$categoria.", descricao = '".$descricao."', preco_unitario = ".$preco.", imagem = '".$novoNome."' WHERE codigo = ".$codigo." ";
echo $comando;
// $resultado=mysqli_query($conexao,$comando);
// if($resultado==true){
//   header("location: registroProdutoForm.php?retorno=1");
// }else {
//   header("location: registroProdutoForm.php?retorno=0");
// }
?>
