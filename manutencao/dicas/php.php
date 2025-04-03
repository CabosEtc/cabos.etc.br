<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>PHP</title>
</head>
<body>
<style type="text/css">
a { 
border: none;
text-decoration: none;
COLOR:#0000FF; 
FONT-FAMILY: verdana; 
}
</style>
<div id="menu">
| <a href="index.php" >Dicas</a> 
| <a href="https://www.php.net/manual/pt_BR/langref.php" >Fonte</a> 
| <a href="#fluxo">Fluxo</a> 
| <a href="#bd">Manipulando BD</a> 
| <a href="https://www.php.net/manual/pt_BR/function.session-reset.php">Sessoes PHP</a> | 
| <a href="#"></a> 
|</div>

<div>Para aprender mais ainda...</div>
<div>
| <a href="https://www.php.net/manual/pt_BR/language.basic-syntax.php" >Sintaxe básica</a> 
| <a href="https://www.php.net/manual/pt_BR/language.types.php" >Tipos</a> 
| <a href="https://www.php.net/manual/pt_BR/language.operators.php" >Operadores</a> 
| <a href="https://www.php.net/manual/pt_BR/control-structures.if.php" >Estruturas de controle</a> 
| <a href="https://www.php.net/manual/pt_BR/language.functions.php" >Funções</a> 
| <a href="https://www.php.net/manual/pt_BR/language.oop5.php" >Classes e objetos</a> 
| <a href="https://www.php.net/manual/pt_BR/language.errors.php" >Erros</a> 
| <a href="https://www.php.net/manual/pt_BR/reserved.variables.php" >Variáveis pré-definidas</a> 
| <a href="https://www.php.net/manual/pt_BR/context.php" >Opções de contexto (curl, etc)</a> 
</div>

<h2 id="fluxo" title="Voltar ao topo"><a href="#menu" >Fluxo</a></h2>
<PRE>
<b><h3>switch/case</h3></b>
switch ($contador) {
		case 1:
			$cdproduto_a=$cdproduto;
			break;
		case 2:
			$cdproduto_b=$cdproduto;	
			break;
		case 3:
			$cdproduto_c=$cdproduto;	
			break;
	}
	
</PRE>

<h2 id="array" title="Voltar ao topo"><a href="#menu" >Array</a></h2>
<PRE>
	https://www.php.net/manual/pt_BR/ref.array.php

	https://medium.com/weyes/trabalhando-e-manipulando-arrays-no-php-a705eb9fc63e



	<B>Criar:</B>

	$array=array(1,2,3);

	<B>Incluir elemento:</B>

	array_push($array,4);

	<B>Varrer elementos da array:</B>
	foreach ($myArray as $keyItem => $itemValue) {
	echo 'Item índice: ' . $keyItem . ', Valor: ' . $itemValue . PHP_EOL;
	}


	<B>Contar elementos da array:</B>

	echo count($array); (irá printar 4)

	<B>Procurar elemento na array</B>

	$key = array_search('green', $array); // $key = 2;

	<B>Verificar se existe o elemento na array</B>

	$os = array("Mac", "NT", "Irix", "Linux"); 
	if (in_array("Irix", $os)) { 
		echo "Tem Irix";
	}
	if (in_array("mac", $os)) { 
		echo "Tem mac";
	}

	<B>Excluir um elemento de um array</B>

	$input = array("item 1", "item2", "item3", "item4");
	$remover = array("item2");
	$resultado = array_diff($input, $remover)
</PRE>



<h2 id="bd" title="Voltar ao topo"><a href="#menu">Manipulando BD</a></h2>
<PRE>
<b><h3>Selecionar primeiro elemento de uma pesquisa</h3></b>

$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='".$id_loja."' AND id_produto='".$id."' 
ORDER BY data DESC limit 1";
$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
				
if(mysql_num_rows($resultado_ultima_alteracao)>0){
	$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
}
</PRE>

<pre>
Quantidade de itens retornados:
$quant=mysql_num_rows($resultado);

Passear pelo recordset:
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$cdproduto=$row[0];
		$quantidade=$row[1];
}

</pre>

</body>
</html>