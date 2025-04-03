<?php 
	//Prepara conexao ao db
	include("../conectadb.php");

  	// Inicializa a sessão
	include("msession.php");
	IF(!$logado){	
		echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	} 
	//echo $nivelusuario;
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="manutencao.css">
		<?
			$data=$_REQUEST["data"];
			$data_eua=substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
			echo "<title>Notas - ".$data."</title>";
			//echo "Usuario: $nomeusuario ($idusuario)<br>";
			if ($idusuario==52){
				$clausulaIdVendedor=" 1 ";
			}
			else{
				//$clausulaIdVendedor=" idvendedor=$idusuario ";
				$clausulaIdVendedor=" 1 "; // vai listar todos os usuarios da loja 
			}
		?>
	</head>

<body>
	<!-- Inclui o menu -->
	<? 
		include("mmenu.php"); 
	
		$query="SELECT nrnota, vlnota, formapagamento, idvendedor, hrnota, cdorigem, vlpago, formapagamento2, vlpago2, vlfrete     
				FROM notas 
				WHERE dtnota='".$data_eua."' 
				AND cdloja=$cdloja  
				AND $clausulaIdVendedor 
				ORDER BY nrnota DESC";
		//echo "$query<br>";
		$resultado = mysql_query($query,$conexao);

		echo "<h1 style='margin-bottom: 20px;'>Listagem de notas do dia $data</h1>";
		
		echo "<table>";
		echo "	<tr>
					<td colspan='2' width='100'>Nº Nota</td>
					<td width='120' align='right'>Valor</td>
					<td width='150' align='right'>Pagamento</td>
					<td width='100' align='right'>Origem</td>
					<td>Loja</td>
					<td>Hora</td>
				</tr>";
		
		$valor_total_notas=0;
		$valor_total_notas_dinheiro=0;
		$valor_total_notas_outros=0;
		$vendedores_array=array();
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$nrnota=$row[0]; // nome da categoria
			$nrnota_formatado=substr(1000000+$nrnota,1,6);
			$vlnota=$row[1]+$row[9]; // valor do produtos + frete
			$vlnota_formatado=number_format($vlnota,2,",","");
			$idformapagamento=$row[2]; // nome da categoria
			$idvendedor=$row[3]; // vendedor
			$hrnota=$row[4]; // vendedor
			$cdOrigem=$row[5]; // vendedor
			switch ($cdOrigem){
				case 0:
					$origem="Balcão";
					break;				
				case 1:
					$origem="Boadica";
					break;
				case 2:
					$origem="Instagram";
					break;
			}
			$vlPago=$row[6];
			$idFormaPagamento2=$row[7];
			$vlPago2=$row[8];
			$vlFrete=$row[9];
			
			// cria uma matriz com todos os idvendedores.
				$vendedores_array[] = $idvendedor; // isto é igual a array_push (adiciona).
			
			if ($idformapagamento==1){
				$valor_total_notas_dinheiro=$valor_total_notas_dinheiro+$vlPago;
			}
			if ($idFormaPagamento2==1){
				$valor_total_notas_dinheiro=$valor_total_notas_dinheiro+$vlPago2;
			}

			if ($idformapagamento>1){
				$valor_total_notas_outros=$valor_total_notas_outros+$vlPago;
			}
			if($idFormaPagamento2>1){
				$valor_total_notas_outros=$valor_total_notas_outros+$vlPago2;
			}
			
			$query2="	SELECT formapagamento 
						FROM formas_pagamento 
						WHERE idformapagamento=".$idformapagamento;
			$resultado2 = mysql_query($query2,$conexao);
			$formapagamento=mysql_result($resultado2,0,0);
			if($vlPago2>0){
				$formapagamento="Misto";
			}

			$query3="	SELECT nomeusuario 
						FROM usuarios 
						WHERE idusuario=".$idvendedor;
			$resultado3 = mysql_query($query3,$conexao);
			$nomevendedor=mysql_result($resultado3,0,0);

			
			$valor_total_notas=$valor_total_notas+$vlnota;
			echo "<tr><td width='50'><a href='nimp.php?nrnota=".$nrnota."'>".$nrnota_formatado."</a></td>
			<td width='20'><a href='nedit.php?nrnota=$nrnota' target='_blank'><img src='../imagens/edit.png' width='16' height='16' /></a></td>
			<td width='50' align='right'>".$vlnota_formatado."</td>
			<td align='right'>".$formapagamento."</td>
			<td align='right'>".$origem."</td>
			<td align='left' style='padding-left:10px;'>".$nomevendedor."</td>
			<td align='left' style='padding-left:10px;'>".$hrnota."</td></tr>";
		} // fim while

			echo "</table>";
		
			$query3="	SELECT sum(vldevolucao) AS valor_devolucoes 
						FROM devolucao 
						WHERE dtdevolucao='".$data_eua."'";
			$resultado3 = mysql_query($query3,$conexao);
			$valor_devolucoes=mysql_result($resultado3,0,0);

			echo "<table>";
			echo "<tr><td colspan='2' align='right'>Total das notas: </td><td align='right'>".number_format($valor_total_notas,2,",","")."</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total das notas (em dinheiro): </td><td align='right'>".number_format($valor_total_notas_dinheiro,2,",","")."</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total das notas (outros): </td><td align='right'>".number_format($valor_total_notas_outros,2,",","")."</td></tr>";
			echo "<tr><td colspan='2' align='right'>Total das devoluções do dia: </td><td align='right'>".number_format($valor_devolucoes,2,",","")."</td></tr>";
			
			// retira os valores duplicados
			$unique_array = array_unique($vendedores_array);
			foreach ($unique_array as $pesquisa_vendedor){
				$query4="	SELECT nomeusuario 
							FROM usuarios 
							WHERE idusuario=".$pesquisa_vendedor;
				$resultado4 = mysql_query($query4,$conexao);
				$nomevendedor=mysql_result($resultado4,0,0);

				//Total das notas + frete
				$queryFrete=	"SELECT sum(vlfrete) as total_frete 
								FROM `notas` 
								WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."'";
				$resultadoFrete = mysql_query($queryFrete,$conexao);
				$totalFrete=mysql_result($resultadoFrete,0,0);
		
				$query5="	SELECT sum(vlnota) as total_venda 
							FROM `notas` 
							WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."'";
				$resultado5 = mysql_query($query5,$conexao);
				$total_vendedor=mysql_result($resultado5,0,0)+$totalFrete;


				//Total em dinheiro do vendedor
				$queryVlPagoEmDinheiro="	SELECT sum(vlpago) as total_venda  
											FROM `notas` 
											WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
											AND formapagamento='1'";
				//echo "queryVlPagoEmDinheiro: $queryVlPagoEmDinheiro<br>";
				$resultadoVlPagoEmDinheiro = mysql_query($queryVlPagoEmDinheiro,$conexao);
				$total_vendedor_dinheiro=mysql_result($resultadoVlPagoEmDinheiro,0,0);
				
				$queryVlPagoEmDinheiro2="	SELECT sum(vlpago2) as total_venda 
											FROM `notas` 
											WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
											AND formapagamento2='1'";
				$resultadoVlPagoEmDinheiro2 = mysql_query($queryVlPagoEmDinheiro2,$conexao);
				$total_vendedor_dinheiro2=mysql_result($resultadoVlPagoEmDinheiro2,0,0);
				
				$total_vendedor_dinheiro=$total_vendedor_dinheiro+$total_vendedor_dinheiro2;
				
				
				//Total em outras formas de pagamento do vendedor
				$queryOutrosPagamentos="	SELECT sum(vlpago) as total_venda 
											FROM `notas` 
											WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
											AND formapagamento<>'1'";
				$resultadoOutrosPagamentos = mysql_query($queryOutrosPagamentos,$conexao);
				$total_vendedor_outros=mysql_result($resultadoOutrosPagamentos,0,0);

				$queryOutrosPagamentos2="	SELECT sum(vlpago2) as total_venda 
											FROM `notas` 
											WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
											AND formapagamento2<>'1'";
				$resultadoOutrosPagamentos2 = mysql_query($queryOutrosPagamentos2,$conexao);
				$total_vendedor_outros2=mysql_result($resultadoOutrosPagamentos2,0,0);
				$total_vendedor_outros=$total_vendedor_outros+$total_vendedor_outros2;
				echo "<tr><td colspan='3'>&nbsp;</td></tr>";
				echo "<tr><td colspan='2' align='right'>Total do vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor."</td></tr>";
				echo "<tr><td colspan='2' align='right'>$ do vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor_dinheiro."</td></tr>";
				//echo "<tr><td colspan='2' align='right'>Total outros do vendedor ".$nomevendedor.":</td><td align='right'>".$total_vendedor_outros."</td></tr>";
				


				// Debito
				$queryDebito="	SELECT sum(vlpago) as total_venda 
								FROM `notas` 
								WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
								AND (formapagamento=2 OR formapagamento=4) ";
				$resultadoDebito = mysql_query($queryDebito,$conexao);
				$totalVendedorDebito=mysql_result($resultadoDebito,0,0);

				$queryDebito2="	SELECT sum(vlpago2) as total_venda 
								FROM `notas` 
								WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
								AND (formapagamento2=2 OR formapagamento2=4) ";
				$resultadoDebito2 = mysql_query($queryDebito2,$conexao);
				$totalVendedorDebito2=mysql_result($resultadoDebito2,0,0);

				$totalVendedorDebito=number_format(($totalVendedorDebito+$totalVendedorDebito2),2,",",".");
				echo "<tr><td colspan='2' align='right'>Débito do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorDebito."</td></tr>";


				// Credito
				$queryCredito="	SELECT sum(vlpago) as total_venda 
								FROM `notas` 
								WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
								AND (formapagamento=3 OR formapagamento=5)";
				$resultadoCredito = mysql_query($queryCredito,$conexao);
				$totalVendedorCredito=mysql_result($resultadoCredito,0,0);

				$queryCredito2="	SELECT sum(vlpago2) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND (formapagamento2=3 OR formapagamento2=5)";
				$resultadoCredito2 = mysql_query($queryCredito2,$conexao);
				$totalVendedorCredito2=mysql_result($resultadoCredito2,0,0);
				$totalVendedorCredito=number_format(($totalVendedorCredito+$totalVendedorCredito2),2,",",".");

				echo "<tr><td colspan='2' align='right'>Crédito do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorCredito."</td></tr>";

				// Deposito/Transferencia
				$queryDeposito="	SELECT sum(vlpago) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento=6";
				$resultadoDeposito = mysql_query($queryDeposito,$conexao);
				$totalVendedorDeposito=mysql_result($resultadoDeposito,0,0);
				
				$queryDeposito2="	SELECT sum(vlpago2) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento2=6";
				$resultadoDeposito2 = mysql_query($queryDeposito2,$conexao);
				$totalVendedorDeposito2=mysql_result($resultadoDeposito2,0,0);
				$totalVendedorDeposito=number_format(($totalVendedorDeposito+$totalVendedorDeposito2),2,",",".");
				echo "<tr><td colspan='2' align='right'>Deposito do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorDeposito."</td></tr>";


				// Pagseguro
				$queryPagSeguro="	SELECT sum(vlpago) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento=7";
				$resultadoPagSeguro = mysql_query($queryPagSeguro,$conexao);
				$totalVendedorPagSeguro=mysql_result($resultadoPagSeguro,0,0);

				$queryPagSeguro2="	SELECT sum(vlpago2) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento2=7";
				$resultadoPagSeguro2 = mysql_query($queryPagSeguro2,$conexao);
				$totalVendedorPagSeguro2=mysql_result($resultadoPagSeguro2,0,0);
				$totalVendedorPagSeguro=number_format(($totalVendedorPagSeguro+$totalVendedorPagSeguro2),2,",",".");
				echo "<tr><td colspan='2' align='right'>PagSeguro do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorPagSeguro."</td></tr>";



				// Pix
				$queryPix="	SELECT sum(vlpago) as total_venda 
							FROM `notas` 
							WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
							AND formapagamento=8";
				$resultadoPix = mysql_query($queryPix,$conexao);
				$totalVendedorPix=mysql_result($resultadoPix,0,0);

				$queryPix2="	SELECT sum(vlpago2) as total_venda 
								FROM `notas` 
								WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."'  
								AND formapagamento2=8";
				//echo"queryPix2: $queryPix2<br>";
				$resultadoPix2 = mysql_query($queryPix2,$conexao);
				$totalVendedorPix2=mysql_result($resultadoPix2,0,0);
				$totalVendedorPix=number_format(($totalVendedorPix+$totalVendedorPix2),2,",",".");
				echo "<tr><td colspan='2' align='right'>Pix do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorPix."</td></tr>";

				// Faturado
				$queryFaturado="	SELECT sum(vlpago) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento=9";
				$resultadoFaturado = mysql_query($queryFaturado,$conexao);
				$totalVendedorFaturado=mysql_result($resultadoFaturado,0,0);

				$queryFaturado2="	SELECT sum(vlpago2) as total_venda 
									FROM `notas` 
									WHERE cdloja='".$cdloja."' and dtnota='".$data_eua."' and idvendedor='".$pesquisa_vendedor."' 
									AND formapagamento2=9";
				$resultadoFaturado2 = mysql_query($queryFaturado2,$conexao);
				$totalVendedorFaturado2=mysql_result($resultadoFaturado2,0,0);
				$totalVendedorFaturado=number_format(($totalVendedorFaturado=$totalVendedorFaturado2),2,",",".");
				echo "<tr><td colspan='2' align='right'>Faturado do vendedor ".$nomevendedor.":</td><td align='right'>".$totalVendedorFaturado."</td></tr>";
				
			}
			echo "</table>";
	?>

</body>
</html>
