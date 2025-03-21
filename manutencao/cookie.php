<?php
session_start();

// estudar isto
//https://www.php.net/manual/pt_BR/function.session-save-path.php
//https://www.php.net/manual/pt_BR/function.session-regenerate-id.php


$cdcliente="20000";
$_SESSION["nome"]="Flavio";
setcookie('nome', 'Rafaela', (time() + (3 * 24 * 3600)));
setcookie('cdcliente', $cdcliente, (time() + (3 * 24 * 3600)));
setcookie('cep', '20397160', (time() + (3 * 24 * 3600)));
?>
<html>


<head>
    <title>3DCon</title>
    <link rel="stylesheet" type="text/css" href="3dcon.css">



</head>
<body>

Agora vai?
</body>
</html>
