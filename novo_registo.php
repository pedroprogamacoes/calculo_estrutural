<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Registo de Utilizador</title>
<link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

</head>
<body>
<?php
    // Cria a conexão e as credenciais de acesso
    $servidor = "localhost";
    $utilizador = "root";
    $password = "";
    $basedados = "u784567453_db_bravoscap";
     
	$ligacao = mysqli_connect($servidor, $utilizador, $password, $basedados) or exit ('Erro de ligação à bd');
	mysqli_select_db($ligacao, $basedados);
	mysqli_set_charset($ligacao, "utf8");
     
    //recolher dados do formulário
     $username = mysqli_real_escape_string($ligacao, $_POST['username']);
     $password = mysqli_real_escape_string($ligacao, $_POST['password']);
     $password = md5($password);
  
   // Inserir registo de users no login
     $query    = "INSERT INTO users (username, password) 
             VALUES('$username', '$password')";
     
var_dump($query);

     $resultado = mysqli_query($ligacao, $query);
	 $linhas = mysqli_num_rows($resultado);
    
   var_dump($linhas);

     if(($linhas) !=0) {
       die('Erro na inserção: ' . mysqli_error());
       exit();
      }
      else {
              mysqli_close($ligacao);
              // adiciona uma janela de informação com JQuery
              // e redirecciona para  a página de login
      ?>
                <script type="text/javascript">
                   $(function() 
                      {
                     $( "#dialog" ).dialog();
                     var delay = 3000; //tempo em milisegundos 
                     setTimeout(function() {window.location = "index.php"}, delay);
                   });
                 </script>
                 <div id="dialog" title="Registo de login">
                     <p>Registo adicionado com sucesso</p>
                     <hr>
                     <p>Redirecionado para login</p>
                 </div>
                 
     <?php 
	 };  
?>            
</body>
</html>