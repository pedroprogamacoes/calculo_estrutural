<?php

header('Content-Type: text/html; charset=utf-8');
session_start();
if (!empty($_POST)) {

    // Cria a conexão
	//credenciais de acesso
	$servidor = "localhost";
	$utilizador = "root";
	$password = "root";
	$basedados = "psim19db";

    //$link = mysql_connect("localhost", "root", "root");
    //mysql_select_db("psim19");
    //mysql_set_charset('utf8', $link);
	
	$ligacao = mysqli_connect($servidor, $utilizador, $password, $basedados) or exit ('Erro de ligação à bd');
	mysqli_select_db($ligacao, $basedados);
	mysqli_set_charset($ligacao, "utf8");

    // verifica a conexão
    if (!$ligacao) {
        die('Problemas de Ligação: ' . mysqli_error());
    } else {
        $username = mysqli_real_escape_string($ligacao, $_POST['username']);
        $password = sha1($_POST['password']);
        // define o query para verificar se o user está registado e com os dados corretos
		$consulta = "SELECT userid, username FROM users WHERE username = '$username' AND password = '$password' ";
        $login = mysqli_query($ligacao, $consulta);
        if ($login && mysqli_num_rows($login) == 1) {
            // o utilizador está correctamente validado
			// guardamos temporariamente os dados encontados na variável $registo
			$registo = mysqli_fetch_array($login, MYSQLI_ASSOC);
			
			// guardamos as suas informações numa sessão
			$_SESSION['id'] = $registo['userid'];
			$_SESSION['username'] = $registo['username'];
			
            //$_SESSION['id'] = mysql_result($login, 0, 0);
            //$_SESSION['username'] = mysql_result($login, 0, 1);
			
			mysqli_free_result($login);
			mysqli_close($ligacao);
		
            echo "<p>Sessão iniciada com sucesso como {$_SESSION['username']}</p>";
        } else {
            // utilizador não validade... remete novamente para página de Login
            echo "<p>Utilizador ou password inválidos. <a href=\"index.php\">Tente novamente</a></p>";
        }
    }
}





 


    
    
    
    





