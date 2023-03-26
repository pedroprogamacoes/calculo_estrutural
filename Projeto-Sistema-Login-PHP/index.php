<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>Exemplo Login PHP</title>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>

<body>
<div class="container">
	<section id="content">
		<form method="post" action="liga.php">
			<h1>Login</h1>
			<div>
				<input type="text" placeholder="Utilizador" name="username" />
			</div>
			<div>
				<input type="password" placeholder="Palavra passe" name="password"  />
			</div>
			<div>
				<input type="submit" value="Log in" />
				<a href="registar.php">Registar novo utilizador</a>
                                <a href="protegido.php">Aceder a conteúdo protegido</a>
			</div>
		</form>
	
	</section>
</div>
</body>
</html
