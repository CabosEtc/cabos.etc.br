<html>
	<head>
		<title>Relatórios</title>
        <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="manutencao.css">
	</head>
	<body class="body">
		<?
			//Prepara conexao ao db
			include("../conectadb.php");

			// Inicializa a sessão
			include("msession.php");
			IF(!$logado){	
				echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
			} 
			//echo $nivelusuario;

			//Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
			$token=$_REQUEST["token"];
			$depuracao=$_REQUEST["depuracao"];

			// Mostra depuracao
			//include("depuracao.php"); 
		?> 

		<!-- Envoltorio -->
		<div id="wrapper" class="wrapper">

			<!-- Espacamento superior -->
			<div id="topo" class="topo">
				&nbsp;
			</div>

			
			<!-- Inclui o menu -->
			<? include("mmenu.php"); ?>    

			<!-- Conteudo principal -->
			<div id="corpo" class="corpo">
				<?
					// recebe os dados 

					$modo=$_REQUEST["modo"];
					$iditem=$_REQUEST["iditem"];
					$quantidade=$_REQUEST["quantidade"];
					$cdproduto=$_REQUEST["cdproduto"];
					$dtchegada=$_REQUEST["dtchegada"];
					$dtchegada_eua=substr($dtchegada,6,4)."-".substr($dtchegada,3,2)."-".substr($dtchegada,0,2);
					$dtentrada=$_REQUEST["dtentrada"]; // usado no modo de inclusão manual
					$dtentrada_eua=substr($dtentrada,6,4)."-".substr($dtentrada,3,2)."-".substr($dtentrada,0,2);
					$fornecedor=$_REQUEST["fornecedor"];
					$valor=$_REQUEST["valor"];
					if($valor==""){
						$valor=0;
					}
					$valor=str_replace(',','.',$valor);
					$valor=number_format($valor,2,'.','');
					$link=$_REQUEST["link"];

					// Variaveis da rotina de ajuste da quantidade de produtos no sistema

					$diferenca1=abs($_REQUEST["diferenca1"]); // torna ele positivo
					$diferenca2=abs($_REQUEST["diferenca2"]); 
					$diferenca3=abs($_REQUEST["diferenca3"]); 
					$diferenca4=abs($_REQUEST["diferenca4"]); 
					$diferenca5=abs($_REQUEST["diferenca5"]); 
					$acao1=$_REQUEST["acao1"];
					$acao2=$_REQUEST["acao2"];
					$acao3=$_REQUEST["acao3"];
					$acao4=$_REQUEST["acao4"];
					$acao5=$_REQUEST["acao5"];
					$cdproduto1=$_REQUEST["cdproduto1"];
					$cdproduto2=$_REQUEST["cdproduto2"];
					$cdproduto3=$_REQUEST["cdproduto3"];
					$cdproduto4=$_REQUEST["cdproduto4"];
					$cdproduto5=$_REQUEST["cdproduto5"];


					// Módulo etransferencia.php
					$origem1=$_REQUEST["origem1"];

					//cdproduto1,2,3,4,5 recebe acima

					$quantidade1=$_REQUEST["quantidade1"];
					$quantidade2=$_REQUEST["quantidade2"];
					$quantidade3=$_REQUEST["quantidade3"];
					$quantidade4=$_REQUEST["quantidade4"];
					$quantidade5=$_REQUEST["quantidade5"];

					$destino1=$_REQUEST["destino1"];



					if ($modo=="incluir"){
						echo "<h3>Incluindo no estoque o pedido de compras ".$iditem."</h3>";
						echo "Código do produto: ".$cdproduto."<br>";
						echo "Quantidade: ".$quantidade."<br>";
						echo "Data da chegada: ".$dtchegada."<br>";
						
						// incluir o produto no banco de dados do estoque
						$query="INSERT INTO estoque(iditem, cdproduto, historico, dtmovimento, quantidade, idcompra, cdloja, link) 
						VALUES ('null', '$cdproduto', '51', '$dtchegada_eua', '$quantidade', '$iditem', '$cdloja', '$link')";
						// echo $query;
						$resultado = mysql_query($query,$conexao);

						$query="UPDATE compras SET cdstatus='1', dtchegada='".$dtchegada_eua."' WHERE iditem='".$iditem."'";
						$resultado = mysql_query($query,$conexao);
						echo "<a href='../manutencao/estoque_selecionarproduto.php'>Incluir </a> novo produto no sistema a partir de compra anterior.";
					}

					if ($modo=="editar"){
						$query="UPDATE compras SET cdproduto='".$cdproduto."', cdstatus='".$cdstatus."', dtcompra='".$dtcompra."' , dtchegada='".$dtchegada."', cdrastreamento='".$cdrastreamento."', quantidade='".$quantidade."', custo_lote_us='".$custo_lote_us."', cotacao_us='".$cotacao_us."', taxa_lote_rs=".$taxa_lote_rs.", custo_total_individual_rs='".$custo_total_individual_rs."', idpaypal='".$idpaypal."', cartao='".$cartao."', observacao='".$observacao."' WHERE iditem='".$iditem."'";
						$resultado = mysql_query($query,$conexao);
						echo "Registro alterado com sucesso";
					}
					//echo $query;

					if ($modo=="incluir_manual"){
						echo "<h3>Incluindo no estoque o produto</h3>";
						echo "Codigo do produto: ".$cdproduto."<br>";
					
						echo "Fornecedor: ".$fornecedor."<br>";
					
						echo "Valor: ".$valor."<br>";
					
						echo "Quantidade: ".$quantidade."<br>";
					
						echo "Data da chegada: ".$dtentrada."<br>";
						
						// incluir o produto no banco de dados do estoque
						$query="INSERT INTO estoque(iditem, cdproduto, historico, fornecedor, dtmovimento, quantidade, idcompra, cdloja, vlindividual, link) 
						VALUES ('null', '$cdproduto', '51', '$fornecedor', '$dtentrada_eua', '$quantidade', '0', '$cdloja', $valor, '$link')";
						//echo $query;
						$resultado = mysql_query($query,$conexao);
						echo "<BR><BR><BR><a href='einc.php'>Incluir </a> novo produto no sistema.";
					}

					if ($modo=="apagar_custo"){
						/*
						echo "Incluindo no estoque o produto<br><br>";
						echo "Codigo do produto: ".$cdproduto."<br>";
					
						echo "Fornecedor: ".$fornecedor."<br>";
					
						echo "Valor: ".$valor."<br>";
					
						echo "Quantidade: ".$quantidade."<br>";
					
						echo "Data da chegada: ".$dtentrada."<br>";
						*/

						// apaga custo do produto de item=iditem
						$query="DELETE FROM estoque WHERE iditem=$iditem";
						//echo $query;
						$resultado = mysql_query($query,$conexao);
						echo "<BR><BR><BR>Registro $iditem apagado.";
					}

					if ($modo=="ajustar_estoque"){
						if((strlen($cdproduto1)==5) AND $acao1>0){ // se for zero não faz nada, está batido.
							switch ($acao1) {
								case 1: // estoque atual menor que a contagem 
									$historico=55; // codigo 55=Acrescentado durante contagem de material
									break;
								case 2: // estoque maior que a contagem
									$historico=5;  // codigo 5=Diminuido durante contagem de material
									break;
							}
							$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) 
									VALUES (null, $cdloja, '$cdproduto1', '$dthoje_eua', $historico, $diferenca1, 0)";
							$resultado = mysql_query($query,$conexao);
							echo "$cdloja | $cdproduto1 | $historico | $diferenca1<br>";
						}
						else{
							echo "$cdproduto1 | Nada a fazer<br>";
						}

						if((strlen($cdproduto2)==5) AND $acao2>0){ // se for zero não faz nada, está batido.
							switch ($acao2) {
								case 1: // estoque atual menor que a contagem 
									$historico=55; // codigo 55=Acrescentado durante contagem de material
									break;
								case 2: // estoque maior que a contagem
									$historico=5;  // codigo 5=Diminuido durante contagem de material
									break;
							}
							$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) 
									VALUES (null, $cdloja, '$cdproduto2', '$dthoje_eua', $historico, $diferenca2, 0)";
							$resultado = mysql_query($query,$conexao);
							echo "$cdloja | $cdproduto2 | $historico | $diferenca2<br>";
						}
						else{
							echo "$cdproduto2 | Nada a fazer<br>";
						}

						if((strlen($cdproduto3)==5) AND $acao3>0){ // se for zero não faz nada, está batido.
							switch ($acao2) {
								case 1: // estoque atual menor que a contagem 
									$historico=55; // codigo 55=Acrescentado durante contagem de material
									break;
								case 2: // estoque maior que a contagem
									$historico=5;  // codigo 5=Diminuido durante contagem de material
									break;
							}
							$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) 
									VALUES (null, $cdloja, '$cdproduto3', '$dthoje_eua', $historico, $diferenca3, 0)";
							$resultado = mysql_query($query,$conexao);
							echo "$cdloja | $cdproduto3 | $historico | $diferenca3<br>";
						}
						else{
							echo "$cdproduto3 | Nada a fazer<br>";
						}

						if((strlen($cdproduto4)==5) AND $acao4>0){ // se for zero não faz nada, está batido.
							switch ($acao2) {
								case 1: // estoque atual menor que a contagem 
									$historico=55; // codigo 55=Acrescentado durante contagem de material
									break;
								case 2: // estoque maior que a contagem
									$historico=5;  // codigo 5=Diminuido durante contagem de material
									break;
							}
							$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) 
									VALUES (null, $cdloja, '$cdproduto4', '$dthoje_eua', $historico, $diferenca4, 0)";
							$resultado = mysql_query($query,$conexao);
							echo "$cdloja | $cdproduto4 | $historico | $diferenca4<br>";
						}
						else{
							echo "$cdproduto4 | Nada a fazer<br>";
						}

						if((strlen($cdproduto5)==5) AND $acao5>0){ // se for zero não faz nada, está batido.
							switch ($acao2) {
								case 1: // estoque atual menor que a contagem 
									$historico=55; // codigo 55=Acrescentado durante contagem de material
									break;
								case 2: // estoque maior que a contagem
									$historico=5;  // codigo 5=Diminuido durante contagem de material
									break;
							}
							$query="INSERT INTO estoque(iditem, cdloja, cdproduto, dtmovimento, historico, quantidade, idcompra) 
									VALUES (null, $cdloja, '$cdproduto5', '$dthoje_eua', $historico, $diferenca5, 0)";
							$resultado = mysql_query($query,$conexao);
							echo "$cdloja | $cdproduto5 | $historico | $diferenca5<br>";
						}
						else{
							echo "$cdproduto5 | Nada a fazer<br>";
						}
					}

					if ($modo=="transferencia_material_entre_lojas"){
						echo "	<h3 style='margin-top: 30px;'>  
									Transferência entre lojas
								</h3>";
						echo "Origem: $origem1<br>";
						echo "Destino: $destino1<br>";

						echo "<table class='mt-2'>";

						echo "	<tr>
									<td class='ml-1'>
										Código
									</td>
									<td class='ml-1'>
										Produto
									</td>
									<td class='ml-1'>
										Quantidade
									</td>
								</tr>";
						
						// Verifica se o código do produto1 é valido (existe na tabela produtos), captura o nome do produto e faz as inclusões na tabela estoque
						$queryNomeProduto1=" SELECT nome 
											FROM produtos 
											WHERE cdproduto='$cdproduto1'";
						$resultadoNomeProduto1= mysql_query($queryNomeProduto1,$conexao);
						$nomeProduto1=mysql_result($resultadoNomeProduto1,0,0);
						$flagProduto1=mysql_num_rows($resultadoNomeProduto1);

						IF($quantidade1>0 AND $flagProduto1>0){
							//echo "achei e vou incluir<br>";
							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$destino1', '$cdproduto1', '52', '$dtchegada_eua', '$quantidade1', 'null', '', '$origem1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);

							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$origem1', '$cdproduto1', '2', '$dtchegada_eua', '$quantidade1', 'null', '', '$destino1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);
							echo "	<tr>
										<td class='ml-1'>
											$cdproduto1
										</td>
										<td class='ml-1'>
											$nomeProduto1
										</td>
										<td class='ml-1 text-right'>
											$quantidade1
										</td>
									</tr>";
						}


						// Verifica se o código do produto2 é valido (existe na tabela produtos), captura o nome do produto e faz as inclusões na tabela estoque
						$queryNomeProduto2=" SELECT nome 
											FROM produtos 
											WHERE cdproduto='$cdproduto2'";
						$resultadoNomeProduto2= mysql_query($queryNomeProduto2,$conexao);
						$nomeProduto2=mysql_result($resultadoNomeProduto2,0,0);
						$flagProduto2=mysql_num_rows($resultadoNomeProduto2);

						IF($quantidade2>0 AND $flagProduto2>0){
							//echo "achei e vou incluir<br>";
							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$destino1', '$cdproduto2', '52', '$dtchegada_eua', '$quantidade2', 'null', '', '$origem1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);

							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$origem1', '$cdproduto2', '2', '$dtchegada_eua', '$quantidade2', 'null', '', '$destino1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);
							echo "	<tr>
										<td class='ml-1'>
											$cdproduto2
										</td>
										<td class='ml-1'>
											$nomeProduto2
										</td>
										<td class='ml-1 text-right'>
											$quantidade2
										</td>
									</tr>";
						}

						// Verifica se o código do produto3 é valido (existe na tabela produtos), captura o nome do produto e faz as inclusões na tabela estoque
						$queryNomeProduto3=" SELECT nome 
											FROM produtos 
											WHERE cdproduto='$cdproduto3'";
						$resultadoNomeProduto3= mysql_query($queryNomeProduto3,$conexao);
						$nomeProduto3=mysql_result($resultadoNomeProduto3,0,0);
						$flagProduto3=mysql_num_rows($resultadoNomeProduto3);

						IF($quantidade3>0 AND $flagProduto3>0){
							//echo "achei e vou incluir<br>";
							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$destino1', '$cdproduto3', '52', '$dtchegada_eua', '$quantidade3', 'null', '', '$origem1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);

							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$origem1', '$cdproduto3', '2', '$dtchegada_eua', '$quantidade3', 'null', '', '$destino1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);
							echo "	<tr>
										<td class='ml-1'>
											$cdproduto3
										</td>
										<td class='ml-1'>
											$nomeProduto3
										</td>
										<td class='ml-1 text-right'>
											$quantidade3
										</td>
									</tr>";
						}

						// Verifica se o código do produto1 é valido (existe na tabela produtos), captura o nome do produto e faz as inclusões na tabela estoque
						$queryNomeProduto4=" SELECT nome 
											FROM produtos 
											WHERE cdproduto='$cdproduto4'";
						$resultadoNomeProduto4= mysql_query($queryNomeProduto4,$conexao);
						$nomeProduto4=mysql_result($resultadoNomeProduto4,0,0);
						$flagProduto4=mysql_num_rows($resultadoNomeProduto4);

						IF($quantidade4>0 AND $flagProduto4>0){
							//echo "achei e vou incluir<br>";
							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$destino1', '$cdproduto4', '52', '$dtchegada_eua', '$quantidade4', 'null', '', '$origem1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);

							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$origem1', '$cdproduto4', '2', '$dtchegada_eua', '$quantidade4', 'null', '', '$destino1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);
							echo "	<tr>
										<td class='ml-1'>
											$cdproduto4
										</td>
										<td class='ml-1'>
											$nomeProduto4
										</td>
										<td class='ml-1 text-right'>
											$quantidade4
										</td>
									</tr>";
						}

						// Verifica se o código do produto5 é valido (existe na tabela produtos), captura o nome do produto e faz as inclusões na tabela estoque
						$queryNomeProduto5=" SELECT nome 
											FROM produtos 
											WHERE cdproduto='$cdproduto5'";
						$resultadoNomeProduto5= mysql_query($queryNomeProduto5,$conexao);
						$nomeProduto5=mysql_result($resultadoNomeProduto5,0,0);
						$flagProduto5=mysql_num_rows($resultadoNomeProduto5);

						IF($quantidade5>0 AND $flagProduto5>0){
							//echo "achei e vou incluir<br>";
							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$destino1', '$cdproduto5', '52', '$dtchegada_eua', '$quantidade5', 'null', '', '$origem1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);

							$queryInserir="	INSERT INTO estoque(iditem, cdloja, cdproduto, historico, dtmovimento, quantidade, idcompra,  link, dados, observacao) 
											VALUES ('null', '$origem1', '$cdproduto5', '2', '$dtchegada_eua', '$quantidade5', 'null', '', '$destino1','')";
							// echo $query;
							$resultadoInserir = mysql_query($queryInserir,$conexao);
							echo "	<tr>
										<td class='ml-1'>
											$cdproduto5
										</td>
										<td class='ml-1'>
											$nomeProduto5
										</td>
										<td class='ml-1 text-right'>
											$quantidade5
										</td>
									</tr>";
						}



						echo "</table>";
					}

				?>
			</div> <!-- Fim da div conteudo_principal -->
		</div> <!--fim da div wrapper -->
	</body>
</html>