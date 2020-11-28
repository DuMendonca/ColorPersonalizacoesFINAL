<style>
	#cabecalho{
	height: 10%;
	width: 100%;
	background-color: #102E51;
}

	#menuPrincipal li, #menuPrincipal a{
		list-style: none;
		text-decoration: none;
	}
	.submenu{
		display: none;
		position: absolute;
	}
	#menuPrincipal{
		float: left;
		font-size: 17px;
	}
	#menuPrincipal a{
		padding: 0px 20px;
		height: 45px;
		float: left;
		line-height: 45px;
		color: white;
	}
	#menuPrincipal li{
		display: inline-block;
		padding-top: 5px;
	}
	.submenu a{
		color: white;
		background-color: #102E51;
		width: 150px;
		margin-bottom: -10px;
	}
	#menuPrincipal li:hover > .submenu{
		display: block;
		top: 45px;
		width: 150px;
	}
	.submenu li:hover > a{
		background-color:  #FC7307;
	}
	#menuPrincipal li:hover > a{
		background-color:  #FC7307;
	}
	#menuLogin{
		margin-left: 835px;
	}	
</style>

<header id="cabecalho">
	<nav id="menu">
		<ul id="menuPrincipal">
			<li><a href="#" class="menuTexto"> Home</a></li>
			<li><a href="php/fundadores.php" class="menuTexto"> Fundadores</a></li>
			<li><a href="php/contatosForm.php" class="menuTexto"> Contatos</a></li>
			<li><a href="php/destaques.php" class="menuTexto"> Produtos</a>
				<ul class="submenu">
					<li><a href="php/destaques.php">Destaques</a></li>
					<?php
					  require_once("conexaoBanco.php");
				      $comando="SELECT codigo, nome FROM categorias";
				      $resultado= mysqli_query($conexao,$comando);
				      $categorias = array();
				      while ($cadaCategoria = mysqli_fetch_assoc($resultado)){
				        array_push($categorias, $cadaCategoria);
				      }
				        foreach ($categorias as $cadaCategoria) {
							$comando2="SELECT codigo FROM produtos WHERE categorias_codigo=".$cadaCategoria['codigo'];
							$resultado2 = mysqli_query($conexao,$comando2);
							$linhas=mysqli_num_rows($resultado2);
							if ($linhas != 0){
								?>
									<li><a href="php/carrossel.php?retorno=<?=$cadaCategoria['codigo'];?>"><?=$cadaCategoria['nome'];?></a></li>
								<?php
							}
				        }
				    ?>
				</ul>
			</li>
			<li id="menuLogin"><a href="php/login.php"> Login</a></li>
		</ul>
	</nav>
</header>