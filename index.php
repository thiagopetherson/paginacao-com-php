<?php
	
	try
	{
		//Fazendo a Conexão com o banco de dados
		$dsn = "mysql:dbname=blog;host=localhost";
		$dbuser = "root";
		$dbpass = "";
		$pdo = new PDO($dsn, $dbuser, $dbpass);
	}
	catch(PDOException $e)
	{
		echo "FALHOU: " . $e->getMessage();
	}
	
	$qt_por_pagina = 10; //Nessa variável definimos a quantidade de registros por página que será mostrado
	
	//Pegando o total de registros que nós temos na nossa tabela
	$total = 0;
	$sql = "SELECT COUNT(*) AS c FROM posts";
	$sql = $pdo->query($sql);
	$sql = $sql->fetch();
	$total = $sql['c'];
	$paginas = $total / $qt_por_pagina; //O 10 é o número de páginas que vamos exibir por tela. 
	
	//Realizando a consulta que busca os registros de acordo com a página selecionada no link
	$pg = 1; // Essa variável vai ser a que vem do GET e vai definir a Página Inicial
	if(isset($_GET['p']) && !empty($_GET['p']))
	{
		$pg = $_GET['p']; //Pegando o valor que é passado via GET (da URL)
	}
	
	$p = ($pg - 1) * $qt_por_pagina; //Definindo a partida da busca do registro (vai ser de onde o select começará a mostrar o registro)
	
	$sql = "SELECT * FROM posts LIMIT $p, $qt_por_pagina";
	$sql = $pdo->query($sql);
	
	if($sql->rowCount() > 0)
	{
		foreach($sql->fetchAll() as $item)
		{
			echo $item['id'] . ' - ' . $item['titulo']. "<br>";			
		}		
	}
	
	//Exibindo os links <a> para as páginas da paginação
	echo "<hr>";
	for($q = 1; $q <= $paginas; $q++)
	{
		echo '<a href="index.php?p='.($q).'">[ '.($q).' ]</a>';
	}
	//OBS: Quando clicamos no link <a>, abrimos a página index.php passando um parâmetro pra ela