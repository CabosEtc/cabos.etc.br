<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>Exportacao de produtos</title>


</head>


<body>




<?

//Prepara conexao ao db
include("../conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
}
fclose ($ponteiro);



$query="SELECT produtos.nome, produtos.cdproduto FROM produtos WHERE cdproduto<10000 ORDER BY produtos.cdproduto";

$resultado = mysql_query($query,$conexao);

$name = 'produtos.txt';
$file = fopen($name, 'w'); // w zera o arquivo antes de comecar a escrever

/*
Layout:
Mercadoria: 50
Grupo: 20
Subgrupo: 30
Modelo: 20
Fabricante: 20
Garantia: 2 (ex: 2D, 7D, 1M, 2M, 3M, 6M, 1A, 2A, 3A, 4A, LT)
Preco de custo: ????
Preco de venda: ????
Especificacoes: 500
*/


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$mercadoria=$row[0];
  $mercadoria=str_pad($mercadoria,50," ",STR_PAD_LEFT);
  $grupo=str_pad("Cabos",20," ",STR_PAD_LEFT);
  $subgrupo=str_pad("Diversos",30," ",STR_PAD_LEFT);
	$cdproduto=$row[1];
  $modelo=str_pad($cdproduto,20," ",STR_PAD_LEFT);
  $fabricante=str_pad("ND",20," ",STR_PAD_LEFT);
	$garantia="3M";
  $precocusto="0000001000";
	$precovenda="0000002000";
	$especificacoes=str_pad("NULL",500," ",STR_PAD_LEFT);
  $texto=$mercadoria.";".$grupo.";".$subgrupo.";".$modelo.";".$fabricante.";".$garantia.";".$precocusto.";".$precovenda.";".$especificacoes."\n";
  fwrite($file, $texto);
	} // Fim da linha de exibicao do produto
  
fclose($file);
?>


</body>
</html>
