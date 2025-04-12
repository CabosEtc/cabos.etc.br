<?php
//Prepara conexao ao db
include("conectadbmysqli.php");

$result = mysql_query($conexao, "SELECT nome FROM cadastro");
printf("Select returned %d rows.\n", mysqli_num_rows($result));


?>