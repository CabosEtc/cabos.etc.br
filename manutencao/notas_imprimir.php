<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nota</title>
</head>
<link href="../cabos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link, a:visited {
text-decoration: none
}
a:hover {
text-decoration: underline;
color: #f00
}
a:active {
text-decoration: none
}
</style>
<body>

<p>
<?
//Prepara conexao ao db
include("../conectadb.php");

session_start();
$usuario=$_SESSION['usuario'];

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$query="SELECT nome_completo, endereco, bairro, cnpj, inscricao_estadual, telefone FROM parametros WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nome_completo_loja=mysql_result($resultado,0,0);
$endereco_loja=mysql_result($resultado,0,1);
$bairro_loja=mysql_result($resultado,0,2);
$cnpj=mysql_result($resultado,0,3);
$inscricao_estadual=mysql_result($resultado,0,4);
$telefone=mysql_result($resultado,0,5);

$nrnota=$_REQUEST["nrnota"];
$nrnota_formatado=substr($nrnota+1000000,1,6);

$query="SELECT dtnota, vlnota, desconto, garantia, formapagamento, idvendedor FROM notas WHERE nrnota='".$nrnota."' AND cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$dtnota=mysql_result($resultado,0,0);
$dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
$vlnota=mysql_result($resultado,0,1);
$desconto=mysql_result($resultado,0,2);
$desconto_formatado=number_format($desconto,2,",","");
$garantia=mysql_result($resultado,0,3);
$idformapagamento=mysql_result($resultado,0,4);
$idvendedor=mysql_result($resultado,0,5);


IF ($idvendedor==14){
  $nome_completo_loja="Cabos 2 Informatica MEI";
  $cnpj="34.247.140/0001-80";
  $endereco_loja="Av Rio Branco, 156 loja 212 stand 'H'";
  $telefone="(21) 99954-4973";
  $inscricao_estadual="ISENTO";
}

$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento=".$idformapagamento;
$resultado = mysql_query($query,$conexao);
$formapagamento=mysql_result($resultado,0,0);


/*
$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto1."'";
$resultado = mysql_query($query,$conexao);
$discriminacao1=mysql_result($resultado,0,0);
*/

?>
  
  
  



<?
echo "<table width='400' align='left'>";
echo "<tr><td align='center' colspan='4'>".$nome_completo_loja."</td></tr>";
echo "<tr><td align='center' colspan='4'>".$endereco_loja."</td></tr>";
echo "<tr><td align='center' colspan='4'>".$bairro_loja."</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";

echo "<tr><td align='left' colspan='4'>CNPJ: ".$cnpj."</td></tr>";
echo "<tr><td align='left' colspan='4'>IE  : ".$inscricao_estadual."</td></tr>";
echo "<tr><td align='left' colspan='4'>TEL : ".$telefone."</td></tr>";

echo "<tr><td colspan='4'>------------------------------------------------------------------------</td></tr>";

echo "<tr><td align='left'>Data: ".$dtnota."</td><td colspan='2'>&nbsp;</td><td align='right'>A".$nrnota_formatado."CE</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";


echo "<tr><td align='center'  colspan='4'>Nota de Garantia</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";
echo "<tr><td align='left'  colspan='4'>Garantia: ".$garantia." dias."."</td></tr>";
echo "<tr><td align='left'  colspan='4'>Forma pgto: ".$formapagamento."</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";


echo "<tr><td>Codigo</td><td>Descricao</td><td>Quant</td><td align='right'>Valor</td></tr>";
echo "<tr><td colspan='4'>------------------------------------------------------------------------</td></tr>";

$query="SELECT  notas_detalhes.quantidade, notas_detalhes.cdproduto, notas_detalhes.vlproduto, produtos.nome FROM notas_detalhes, notas, produtos WHERE notas_detalhes.cdproduto=produtos.cdproduto AND notas.nrnota=".$nrnota." AND notas.idnota=notas_detalhes.idnota AND notas.cdloja='".$cdloja."'ORDER BY notas_detalhes.iddetalhe";
	$resultado = mysql_query($query,$conexao);
    $contador_linhas=0;
	$total_compras=0;
	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$quantidade=$row[0]; // nome da categoria
		$cdproduto=$row[1]; // nome da categoria
		$vlproduto=$row[2]; // nome da categoria
		$discriminacao=$row[3]; // nome da categoria
		
		$vlproduto_formatado=number_format($vlproduto,2,",","");
		$total_linha=number_format($quantidade*$vlproduto,2,",","");
		
		$contador_linhas=$contador_linhas+1;
		$total_compras=$total_compras+($vlproduto*$quantidade);
		echo "<tr><td>".$cdproduto."</td><td>".$discriminacao."</td><td align='center'>".$quantidade."</td><td align='right'>".$vlproduto_formatado."</td></tr>";
	}
	
		$total_nota=$total_compras-$desconto;
		$total_nota_formatado=number_format($total_nota,2,",","");
	
	while ($contador_linhas<10) {
		$contador_linhas=$contador_linhas+1;
		// echo " "."<BR>";
	}
	

$vlnota=number_format(($quant1*$vlunitario1)+($quant2*$vlunitario2)+($quant3*$vlunitario3)+($quant4*$vlunitario4)+($quant5*$vlunitario5)+($quant6*$vlunitario6)+($quant7*$vlunitario7)+($quant8*$vlunitario8)+($quant9*$vlunitario9)+($quant10*$vlunitario10)-$desconto,2,",","");

echo "<tr><td colspan='4'>&nbsp;</td></tr>";
if ($desconto_formatado<>"0,00"){
echo "<tr><td colspan='4' align='right'>Descontos: R$ ".$desconto_formatado."</td></tr>"; 
}
//echo "------------------------------------------------------------"."<BR>";
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr><td colspan='4' align='right'><a href='javascript: window.print();'>Total: R$ ".$total_nota_formatado."</a></td></tr>"; 
//echo "<tr><td colspan='4' align='right'>"." Imprimir "."</td></tr>"; 
echo "<tr><td colspan='4'>&nbsp;</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";

echo "<tr><td colspan='4'>Obrigado por sua compra, por favor leia atentamente os itens abaixo:</td></tr>";
echo "<tr><td colspan='4'>O produto que o sr(a) acaba de comprar tem garantia oferecida por nossa empresa nos seguintes termos:</td></tr>";
echo "<tr><td colspan='4'>1- Os produtos por nos comercializados tem garantia de 90 (noventa) dias, contados a partir da data da aquisicao (salvo prazo diferente, assinalado no topo desta nota de garantia).</td></tr>";
echo "<tr><td colspan='4'>2- O material deve ser devolvido completo, c/ manuais, acessorios e caixa original do fabricante/distribuidor. O selo de garantia deve estar intacto.</td></tr>";
echo "<tr><td colspan='4'>3- A peca defeituosa, em garantia, nao deve apresentar arranhoes, partes quebradas ou danificadas por acao de produtos quimicos, como oleos, graxas, etc...</td></tr>";
echo "<tr><td colspan='4'>4- Nao trocamos mercadorias e nao efetuamos devolucao da quantia paga nos casos em que o produto foi comprado erroneamente, por nao atender suas necessidades ou por incompatibilidade com seu aparelho.</td></tr>";
echo "<tr><td colspan='4'>5- Ate 7 dias contados a partir da data da compra o produto pode ficar retido para analise por ate 48hrs, apos este prazo a mercadoria sera encaminhada para troca junto ao fornecedor, que tem o prazo por lei de ate 30 dias para troca (CDC artigo 18). Caso a troca nao seja possivel (falta de estoque, etc) eh facultado ao comprador, nos termos constantes do Codigo de Defesa do Consumidor:</td></tr>";
echo "<tr><td colspan='4'>a) A substituicao do produto por outro da mesma especie;</td></tr>";
echo "<tr><td colspan='4'>b) A restituicao da quantia paga;</td></tr>";
echo "<tr><td colspan='4'>c) O abatimento proporcional ao preco.</td></tr>";
echo "<tr><td colspan='4'>* Importante: Esta garantia nao cobre defeitos provocados por causas externas (agentes da natureza), tentativa de furto, acidentes, problemas com energia eletrica, mau uso por parte do comprador, negligencia, alteracoes, conserto ou tentativa de consertos realizadas por terceiros, instalacoes inadequadas ou testes mal realizados.</td></tr>";

echo "<tr><td colspan='4'>&nbsp;</td></tr>";
echo "<tr><td colspan='4'>&nbsp;</td></tr>";
echo "<tr><td colspan='4'>.</td></tr>";
echo "</table>";

// Rotinas de log: Registra a impressão no LOG do sistema:

$dthoje=date("Y-m-d",strtotime("now"));
//echo $dthoje;
$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) VALUES ('null', '$dthoje', '$cdloja', '1', '$nrnota', '$usuario','$dtnota', 'null')"; 
// codigo 1 = impressao da nota
	// echo $query;
	$resultado = mysql_query($query,$conexao);

?>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
