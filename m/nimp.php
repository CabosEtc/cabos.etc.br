<html>
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
<body onload="imprimirNota()">
	<?
		//Prepara conexao ao db
		include("../conectadb.php");

		  	// Inicializa a sessão
		include("msession.php");
		IF(!$logado){	
			echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
		} 
		//echo $nivelusuario;

		$query="SELECT nome_completo, endereco, bairro, cnpj, inscricao_estadual, telefone 
				FROM parametros 
				WHERE cdloja='".$cdloja."'";
		$resultado = mysql_query($query,$conexao);
		$nome_completo_loja=mysql_result($resultado,0,0);
		$endereco_loja=mysql_result($resultado,0,1);
		$bairro_loja=mysql_result($resultado,0,2);
		$cnpj=mysql_result($resultado,0,3);
		$inscricao_estadual=mysql_result($resultado,0,4);
		$telefone=mysql_result($resultado,0,5);

		$nrnota=$_REQUEST["nrnota"];
		$nrnota_formatado=substr($nrnota+1000000,1,6);

		$query="SELECT dtnota, vlnota, desconto, garantia, formapagamento, idvendedor, nrserial, cdcliente, idvendedor, 
						vlpago, formapagamento2, vlpago2, vlfrete        
				FROM notas 
				WHERE nrnota='$nrnota' 
				AND cdloja='$cdloja'";
		$resultado = mysql_query($query,$conexao);
		$dtnota=mysql_result($resultado,0,0);
		$dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
		$vlnota=mysql_result($resultado,0,1);
		$desconto=mysql_result($resultado,0,2);
		$desconto_formatado=number_format($desconto,2,",","");
		$garantia=mysql_result($resultado,0,3);
		$idformapagamento=mysql_result($resultado,0,4);
		$idvendedor=mysql_result($resultado,0,5);
		$queryNomeVendedor="SELECT nomeusuario 
							FROM usuarios 
							WHERE idusuario=$idvendedor";
		$resultadoNomeVendedor=mysql_query($queryNomeVendedor,$conexao);
		$nomeVendedor=mysql_result($resultadoNomeVendedor,0,0);
		$nrSerial=mysql_result($resultado,0,6);
		$cdCliente=mysql_result($resultado,0,7);
		$queryDadosCliente="SELECT nome, cpf_cnpj, telefone  
							FROM cadastro  
							WHERE cdcliente=$cdCliente";
		$resultadoDadosCliente=mysql_query($queryDadosCliente,$conexao);
		$nomeCliente=mysql_result($resultadoDadosCliente,0,0);
		$cpfCnpjCliente=mysql_result($resultadoDadosCliente,0,1);
		if(strlen($cpfCnpjCliente)==11){
			$cpfCnpjCliente=substr($cpfCnpjCliente,0,3).".".substr($cpfCnpjCliente,3,3).".".substr($cpfCnpjCliente,6,3)."-".substr($cpfCnpjCliente,9,2);
		}
		elseif(strlen($cpfCnpjCliente)==14){
			$cpfCnpjCliente=substr($cpfCnpjCliente,0,2).".".substr($cpfCnpjCliente,2,3).".".substr($cpfCnpjCliente,5,3)."/".substr($cpfCnpjCliente,8,4)."-".substr($cpfCnpjCliente,12,2);
		}
		$telefoneCliente=mysql_result($resultadoDadosCliente,0,2);
		$telefoneCliente="(".substr($telefoneCliente,0,2).") ".substr($telefoneCliente,2,-4)."-".substr($telefoneCliente,-4);
		$idVendedor=mysql_result($resultado,0,8);
		$vlpago=mysql_result($resultado,0,9);
		$idformapagamento2=mysql_result($resultado,0,10);
		$vlpago2=mysql_result($resultado,0,11);
		$vlFrete=mysql_result($resultado,0,12);

		IF ($idvendedor==14){
			$nome_completo_loja="Cabos 2 Informatica MEI";
			$cnpj="34.247.140/0001-80";
			$endereco_loja="Av Rio Branco, 156 loja 212 stand 'D'";
			$telefone="(21) 3420-3366";
			$inscricao_estadual="ISENTO";
		}

		$query="SELECT formapagamento 
				FROM formas_pagamento 
				WHERE idformapagamento=".$idformapagamento;
		$resultado = mysql_query($query,$conexao);
		$formapagamento=mysql_result($resultado,0,0);
		if($vlpago2>0){
			$descricaoFormaPagamentoGlobal="Misto";
		}
		else{
			$descricaoFormaPagamentoGlobal=$formapagamento;
		}

		$query="SELECT formapagamento 
				FROM formas_pagamento 
				WHERE idformapagamento=".$idformapagamento2;
		$resultado = mysql_query($query,$conexao);
		$formapagamento2=mysql_result($resultado,0,0);


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
		echo "<tr><td align='left'  colspan='4'>Forma pgto: ".$descricaoFormaPagamentoGlobal."</td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";


		echo "<tr><td>Codigo</td><td>Descricao</td><td>Quant</td><td align='right'>Valor</td></tr>";
		echo "<tr>&nbsp;<td></td><td>Marca</td><td>&nbsp;</td><td align='right'>Total</td></tr>";
		echo "<tr><td colspan='4'>------------------------------------------------------------------------</td></tr>";

		$query="SELECT  notas_detalhes.quantidade, notas_detalhes.cdproduto, notas_detalhes.vlproduto, 
				produtos.nome, fabricantes.nome, produtos.modelo  
				FROM notas_detalhes, notas, produtos, fabricantes  
				WHERE notas_detalhes.cdproduto=produtos.cdproduto 
				AND fabricantes.cdfabricante=produtos.cdfabricante 
				AND notas.nrnota=$nrnota 
				AND notas.idnota=notas_detalhes.idnota 
				AND notas.cdloja='$cdloja' 
				ORDER BY notas_detalhes.iddetalhe";
		//echo "$query<br>";

		$resultado = mysql_query($query,$conexao);
		$contador_linhas=0;
		$total_compras=0;
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$quantidade=$row[0]; // nome da categoria
			$cdproduto=$row[1]; // nome da categoria
			$vlproduto=$row[2]; // nome da categoria
			$discriminacao=$row[3]; // nome da categoria
			$nomeFabricante=$row[4];
			$modeloProduto=$row[5];
			if ($nomeFabricante=="Herdado"){
				$nomeFabricante="N/D";
			}
			
			$vlproduto_formatado=number_format($vlproduto,2,",","");
			$totalLinha=number_format($quantidade*$vlproduto,2,",","");
			
			$contador_linhas=$contador_linhas+1;
			$total_compras=$total_compras+($vlproduto*$quantidade);
			echo "<tr>
			<td>$cdproduto</td>
			<td>$discriminacao</td>
			<td align='center'>$quantidade</td>
			<td align='right'>$vlproduto_formatado</td>
			</tr>";
			echo "<tr>
			<td>&nbsp;</td>
			<td colspan='2'>$nomeFabricante - $modeloProduto</td>
			<td align='right'>$totalLinha</td>
			</tr>";
		}
			
		$total_nota=$total_compras-$desconto+$vlFrete;
		$total_nota_formatado=number_format($total_nota,2,",","");
			
		while ($contador_linhas<10) {
			$contador_linhas=$contador_linhas+1;
			// echo " "."<BR>";
		}
			

		$vlnota=number_format(($quant1*$vlunitario1)+($quant2*$vlunitario2)+($quant3*$vlunitario3)+($quant4*$vlunitario4)+($quant5*$vlunitario5)+($quant6*$vlunitario6)+($quant7*$vlunitario7)+($quant8*$vlunitario8)+($quant9*$vlunitario9)+($quant10*$vlunitario10)-$desconto,2,",","");

		//echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		if ($desconto_formatado<>"0,00"){
			echo "<tr><td colspan='4' align='right'>Descontos: R$ ".$desconto_formatado."</td></tr>"; 
		}
		if($vlFrete>0){
			echo "<tr><td colspan='4' align='right'>Frete: R$ ".$vlFrete."</td></tr>";
		}

		//echo "------------------------------------------------------------"."<BR>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td colspan='4' align='right'><a href='javascript: window.print();'>Total:</a> R$ $total_nota_formatado</td></tr>"; 
		//echo "<tr><td colspan='4' align='right'>"." Imprimir "."</td></tr>"; 
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		if($nrSerial<>""){
			echo "<tr><td colspan='4'>Seriais e/ou Selos:</td></tr>";
			echo "<tr><td colspan='4'>$nrSerial</td></tr>";
			echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		}
		echo "<tr><td colspan='4'>Vendedor: $idVendedor-$nomeVendedor</td></tr>";
		echo "<tr><td colspan='4'>Cliente: $nomeCliente ($cdCliente)</td></tr>";
		if ($cpfCnpjCliente<>''){
			echo "<tr><td colspan='4'>Cpf/Cnpj: $cpfCnpjCliente</td></tr>";
		}
		if($telefoneCliente<>''){
			echo "<tr><td colspan='4'>Telefone: $telefoneCliente</td></tr>";
		}
		echo "<tr><td colspan='4'>Pgto1 ($formapagamento): $vlpago</td></tr>";
		if($vlpago2>0){
			echo "<tr><td colspan='4'>Pgto2 ($formapagamento2): $vlpago2</td></tr>";
		}
			echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		if($idformapagamento==9){
			echo "	<tr>
						<td colspan='4'>
							Declaro que recebi as mercadorias acima descritas e que providenciarei o pagamento na data combinada
						</td>
					</tr>
					<tr>
						<td colspan='4'>
						Ass: ______________________________________________
						</td>
					</tr>";
			echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		}

		/*
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
		echo "<tr><td colspan='4'><img src='../imagens/whatsappBW.png' width='32' height='32'> (21) 99362-3164 (texto por favor)</td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr><td colspan='4'><b>Drivers e Instruções de instalação</b></td></tr>";
		echo "<tr><td colspan='4'>https://www.cabos.etc.br/drivers/</td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr><td colspan='4'>*Atenção: a barra no final do endereço, é importante!</td></tr>";
		echo "<tr><td colspan='4'>Se precisar de ajuda, por favor entre em contato com o whatsapp acima.</td></tr>";
		*/
		
		$queryTermosGarantia="	SELECT termos_garantia 
								FROM parametros 
								WHERE cdloja=$cdloja";
		$resultadoTermosGarantia=mysql_query($queryTermosGarantia,$conexao);
		$termoGarantia=mysql_result($resultadoTermosGarantia,0,0);
		echo "<tr><td colspan='4'>$termoGarantia</td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr><td colspan='4'>.</td></tr>";
		echo "</table>";

		// Rotinas de log: Registra a impress�o no LOG do sistema:

		$dthoje=$timestampSaoPaulo; // vem do conectadb.php
		//echo "$dthoje<br>";
		$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) 
				VALUES ('null', '$dthoje', '$cdloja', '1', '$nrnota', '$idusuario','$dtnota', 'null')"; 
		// codigo 1 = impressao da nota
		// echo $query;
		$resultado = mysql_query($query,$conexao);

	?>

	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	</form>
	<p>&nbsp;</p>
	<script>
   		function imprimirNota() {
			window.print();
       	}
	</script>
</body>
</html>
