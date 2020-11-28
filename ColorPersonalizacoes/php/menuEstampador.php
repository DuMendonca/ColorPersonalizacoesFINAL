<style>
	#cabecalho{
	height: 60px;
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
		border-radius: 5px;
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
	#menuBv{
		margin-left: 800px;
	}
</style>
<header id="cabecalho">
	<nav id="menu">
		<ul id="menuPrincipal">
			<li><a href="consultaOrdemServico.php" class="menuTexto"> Consulta de Ordem de serviço</a></li>
			<li id="menuBv"><a href="inicios.php">Bem vindo(a) <?php
      if (strstr($_SESSION['nomeLogado'], ' ', true)==true){
        echo strstr($_SESSION['nomeLogado'], ' ', true);
      }else{
        echo $_SESSION['nomeLogado'];
      }
      ?></a></li>
      		<li><a href="efetuaLogout.php">Logout</a></li>

		</ul>
	</nav>
</header>
