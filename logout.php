<?php

// aceder às sessões
session_start();
 
// para terminar uma sessão, apenas é necessário destruí-la
session_destroy();
 
// redirecionar o utilizador para outra página, index.php por exemplo
header('Location: index.php');


