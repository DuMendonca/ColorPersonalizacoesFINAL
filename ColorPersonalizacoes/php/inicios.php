<?php
session_start();

if(isset($_SESSION['nivelLogado'])==true && $_SESSION['nivelLogado']==3 || $_SESSION['nivelLogado']==2 || $_SESSION['nivelLogado']==1){

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Color Personalizações</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/inicios.css">
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif|IBM+Plex+Sans&display=swap" rel="stylesheet">

</head>
<body>

<?php
    if($_SESSION['nivelLogado']==3){
    include ("menuAdm.php");
  }else if($_SESSION['nivelLogado']==2){
    include ("menuEstampador.php");
  }else if($_SESSION['nivelLogado']==1){
    include ("menuAtendente.php");
  }

?>

<section id="login">
</section>

<main id="conteudoPrincipal">
<h2>Bem-Vindo(a) <?=$_SESSION['nomeLogado']?> :)</h2>
</main>
</body>
</html>
<?php
}  //fechamento do IF
else{
  header("Location: login.php");
}
?>
