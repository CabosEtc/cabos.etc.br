<?php
$output = shell_exec('ulimit -f 256; curl -I http://www.cabos.etc.br/manutencao/index.php');
echo $output;

?>

