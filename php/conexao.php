<!-- Conexão com o banco de dados -->
  <?php
		$servidor = '192.168.1.10';
		$usuario = 'DevUser2';
		$senha = 'BV!A2k1$e61ms#yeQpE4j';
		$dbname = 'DevPortalCop';
		
		//Criar a conexão
		$con= new PDO("mysql:host=$servidor;dbname=$dbname", $usuario, $senha);

		//$conn = mysqli_connect(192.168.1.10:3306, DevUser2, BV!A2k1$e61ms#yeQpE4j, DevPortalCop);
		$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	?>
	<!-- Início da sessão e confirmação de que o usuário está logado -->
	<?php
		session_start();
		$usuario = $_SESSION['Usuario'];
		if (!isset($_SESSION['Usuario'])) {
			header("Location: ../../index.html");
			exit;
		}
	?>