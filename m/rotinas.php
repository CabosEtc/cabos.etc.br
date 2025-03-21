<?

// Rotinas de arquivo
$arquivo="BDRotinasJson.txt";

//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
$fp=fopen($arquivo, "w+"); //w+ apaga o conteudo anterior, para somar usar a+

$msg="Isto é apenas um teste - linha 1\n";

//Escreve no arquivo aberto.
fwrite($fp, $msg);

$msg="Isto é apenas um teste - linha 2";
fwrite($fp, $msg);
//Fecha o arquivo.
fclose($fp);
?>