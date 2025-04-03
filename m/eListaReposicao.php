<html>
	<head>
		<?
            //Mostra os erros da pagína
            /*
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            */
            //Esta rotina foi baseada no arquivo nResumoDia.php
			// Recebe dados
			//$dtmovimento=$_REQUEST["dtmovimento"];
			$dtMovimentoInicialEua=$_REQUEST["dtMovimentoInicial"];
            //echo "dtMovimentoInicialcdLoja recebido: $dtMovimentoInicial<br>";
			$dtMovimentoFinalEua=$_REQUEST["dtMovimentoFinal"];
            $cdLojaX=$_REQUEST["cdLojaX"];
            //echo "cdLoja x recebida: $cdLojaX<br>";

			//$dtMovimentoInicial='24/04/23';
			//$dtMovimentoFinal='25/04/23';
			

			$flagLojas=$_REQUEST["flagLojas"];
			echo ("<title>Reposição de material</title>");
		?>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="manutencao.css"/>
	</head>
	<body>
		<?
			//Prepara conexao ao db
			include("../conectadb.php");

			// Inicializa a sessão
			include("msession.php");
			IF(!$logado){	
				echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
			} 
			//echo "Nivel usuario: $nivelusuario<br>";

            $cdloja=$cdLojaX; //Faz assumir o codigo da loja passado por referencia a pagina.
            $cdLoja=$cdLojaX;
            //echo "cdLoja: $cdloja<br>";

			// Continuação dos dados
            /*
			$dia=substr($dtMovimentoInicial,0,2);
			$mes=substr($dtMovimentoInicial,3,2);
			$ano=substr($dtMovimentoInicial,6,4);
			$dtMovimentoInicialEua=$ano."/".$mes."/".$dia;

			$dia=substr($dtMovimentoFinal,0,2);
			$mes=substr($dtMovimentoFinal,3,2);
			$ano=substr($dtMovimentoFinal,6,4);
			$dtMovimentoFinalEua=$ano."/".$mes."/".$dia;
            */

			$query="SELECT cotacao_us 
					FROM parametros 
					WHERE cdloja='".$cdloja."'";
			//echo "$query<br>";
			$resultado = mysql_query($query,$conexao);
			$cotacao_dolar=mysql_result($resultado,0,0);

			$query="SELECT moeda_compra 
					FROM parametros 
					WHERE cdloja='".$cdloja."'";
			$resultado = mysql_query($query,$conexao);
			$moeda_compra=mysql_result($resultado,0,0);

			$queryCentroDeCustos="SELECT cdloja_centro_custo  
					FROM lojas  	
					WHERE cdloja='".$cdloja."'";
			$resultadoCentroDeCustos = mysql_query($queryCentroDeCustos,$conexao);
			$centroDeCustos=mysql_result($resultadoCentroDeCustos,0,0);

			$queryNomeLoja="SELECT nomeloja  
							FROM lojas  	
							WHERE cdloja='".$cdloja."'";
			$resultadoNomeLoja = mysql_query($queryNomeLoja,$conexao);
			$nomeLoja=mysql_result($resultadoNomeLoja,0,0);

			//Inclui o menu
			include("mmenu.php");  

			echo "<h3>Listagem para reposição de Produtos vendidos entre $dtMovimentoInicialEua / $dtMovimentoFinalEua</h3>";
			echo "<div>Loja: $nomeLoja | $cdloja</div>";
			if ($moeda_compra=="US"){
				echo "Moeda de compra: Dolar, cotação utilizada: ".$cotacao_dolar."<br><br>";
			} 
			else {
					echo 	"<div>
								Moeda de compra: Reais
							</div>";
			}
            /*
            echo "	<div class='MB1'>
                        <a href='https://www.cabos.etc.br/m/nResumoDia.php?dtmovimento=$dtmovimento&flagLojas=todas'>Listar movimento de todas as lojas</a>
                    </div>";
            */
			echo "<div>Centro de Custos: $centroDeCustos</div>";
			



			// seleciona o produto no banco de dados

			if ($flagLojas==''){
				$lojasSelecionadas=$cdLoja;
			}
			else{
				$queryLojasGrupo="	SELECT lojas_grupo 
									FROM lojas 
									WHERE cdloja='$cdLoja'";
				$resultadoLojasGrupo=mysql_query($queryLojasGrupo,$conexao);
				$lojasSelecionadas=mysql_result($resultadoLojasGrupo,0,0);
			}

			//$lojasSelecionadas=$cdLojaX;

			$queryProdutoVendidos="SELECT notas_detalhes.cdproduto, produtos.nome, produtos.favorito  
					FROM notas_detalhes, produtos, precos, notas, fabricantes 
					WHERE produtos.cdproduto = notas_detalhes.cdproduto
					AND precos.cdproduto=produtos.cdproduto
					AND notas_detalhes.idnota = notas.idnota
					AND notas.cdloja IN ($lojasSelecionadas) 
					AND notas.dtnota BETWEEN '$dtMovimentoInicialEua' AND '$dtMovimentoFinalEua'   
					GROUP BY produtos.nome, produtos.cdproduto";



		    //echo "Query lojas selecionadas: $queryProdutoVendidos<br>";
			
			$resultadoProdutoVendidos = mysql_query($queryProdutoVendidos,$conexao);
			//	$valor_total_compras=0;
			$query2="	SELECT SUM(notas.vlnota) 
						AS valor_total 
						FROM notas 
						WHERE notas.dtnota  BETWEEN '$dtMovimentoInicialEua' AND '$dtMovimentoFinalEua'   
						AND notas.cdloja IN ($lojasSelecionadas) ";
			//echo "Query das somas: $query2<BR>";
			$resultado2 = mysql_query($query2,$conexao);
			$valor_total=mysql_result($resultado2,0,0);
			
			echo "<table>";
            $backGroundTR="style=\"background-color:$corLoja\"";
			echo "  <tr $backGroundTR>
                        <td width='60'>Código</td>
                        <td width='60'>Marca</td>
                        <td width='300'>Nome do produto</td>
                        <td width='60' colspan='5'>&nbsp;</td>
                        <td width='30'>Vendas</td>
                        <td colspan='4' align='center'>Estoque</td>
                    </tr>
                    <tr $backGroundTR>
                        <td colspan='9'>&nbsp</td>
                        <td width='120' align='center' title='Total em estoque na loja'>Loja</td>
                        <td width='60' align='center' title='Quantidade considerada ideal para a loja'>Ideal</td>
                        <td width='60' align='center' title='Total em estoque em todas as lojas'>Total</td>
                        <td width='60' align='center' title='Quantidade sugerida para reposição'>Repor</td>
                    </tr>";
            /*
			<td>Custo</td>
			<td>Venda</td>
			<td width='40' colspan='2'>&nbsp;</td>";
			if (($nivelusuario>=4)){
				echo "	<td>Moeda</td>
						<td>Custo BRL</td>
						<td>Custo total</td>";
			}
			
			echo"<td>Total Venda</td>";
			if (($nivelusuario>=4)){
				echo"<td>Lucro total</td>";
			}
            */
			echo "</tr>";

			$queryCentroDeCustos="	SELECT cdloja_centro_custo  
									FROM lojas  	
									WHERE cdloja='".$cdloja."'";
			$resultadoCentroDeCustos = mysql_query($queryCentroDeCustos,$conexao);
			$centroDeCustos=mysql_result($resultadoCentroDeCustos,0,0);

			$valor_total_custo=0;
			while ($row = mysql_fetch_array($resultadoProdutoVendidos, MYSQL_NUM)) {
				$cdproduto=$row[0]; // nome da categoria
				$nome=$row[1]; // nome da categoria
				$favorito=$row[2]; // flag de favorito 
				if ($favorito==1){
					$cdProdutoFormatado="<b>$cdproduto</b>";
				}
				else{
					$cdProdutoFormatado=$cdproduto;
				}

				$queryMarcaProduto="SELECT fabricantes.nome   
									FROM fabricantes, produtos   
									WHERE fabricantes.cdfabricante=produtos.cdfabricante 
									AND produtos.cdproduto='$cdproduto'";
				//echo "$queryMarcaProduto<br>";
				$resultadoMarcaProduto = mysql_query($queryMarcaProduto,$conexao);
				$marcaProduto=mysql_result($resultadoMarcaProduto,0,0);






				/*
				
				$query4="	SELECT vlcompra, cdmoeda, vlvenda  
							FROM precos 
							WHERE cdproduto='$cdproduto' 
							AND cdloja = $centroDeCustos";
				//echo "$query4<br>";
				$resultado4 = mysql_query($query4,$conexao);
				$vlcompra=mysql_result($resultado4,0,0);
				$cdmoeda=mysql_result($resultado4,0,1);
				$vlvenda=mysql_result($resultado4,0,2);

				$vlcusto_do_produto=number_format($vlcompra,2,".",""); // nome da categoria
				if ($cdmoeda=="USD"){
					$vlcusto_do_produto_brl=number_format($vlcompra*$cotacao_dolar,2,".",""); // nome da categoria
				}
					else {
						$vlcusto_do_produto_brl=$vlcusto_do_produto;
				}

				//echo "$vlcusto_do_produto_brl<br>";
				
				
				
				//$quantidade_total=$row[0]; // nome da categoria
				
                */
				$query3="	SELECT SUM(notas_detalhes.quantidade) as quantidade_total 
							FROM notas_detalhes, notas 
							WHERE cdproduto='".$cdproduto."' 
							AND notas.idnota=notas_detalhes.idnota 
							AND notas.dtnota BETWEEN '$dtMovimentoInicialEua' AND '$dtMovimentoFinalEua'  
							AND notas.cdloja IN ($lojasSelecionadas)";
				//echo $query3;
				$resultado3 = mysql_query($query3,$conexao);
				$quantidade_total=mysql_result($resultado3,0,0);
				

                /*
				$query4="	SELECT SUM(notas_detalhes.quantidade*notas_detalhes.vlproduto) as vlvendatotaldoproduto 
							FROM notas_detalhes, notas 
							WHERE cdproduto='$cdproduto' 
							AND notas.idnota=notas_detalhes.idnota 
							AND notas.dtnota='$dtmovimento_eua' 
							AND notas.cdloja IN ($lojasSelecionadas)";
				//echo $query4;
				$resultado4 = mysql_query($query4,$conexao);
				$vltotaldoproduto=mysql_result($resultado4,0,0);
				$vlvendatotaldoproduto=number_format($vltotaldoproduto,2,".","");
				$vlcustototaldoproduto=number_format($vlcusto_do_produto_brl*$quantidade_total,2,".","");
				$vllucrototaldoproduto=number_format($vlvendatotaldoproduto-$vlcustototaldoproduto,2,".","");
				$valor_total_custo=$valor_total_custo+$vlcustototaldoproduto;






				// Pesquisa do preços de custo
				$queryVlCompra="SELECT estoque.vlindividual, estoque.dtmovimento  
								FROM estoque
								WHERE cdproduto='$cdproduto' 
								AND cdloja = $cdLoja  
								AND historico=51 
								ORDER BY dtmovimento DESC";
				//echo $query4;
				$resultadoVlCompra = mysql_query($queryVlCompra,$conexao);

				$dtmovimento=mysql_result($resultadoVlCompra,0,1);
				IF($dtmovimento==''){
					$dtmovimento='2001-01-01';
				}
				$dtPreco=new DateTime($dtmovimento);
				$dtHoje=new DateTime($dthoje_eua);
				//echo "Dtmovimento $dtmovimento<br>";
				// Resgata diferença entre as datas
				$dateInterval = $dtPreco->diff($dtHoje);
				$diasDecorridos=$dateInterval->days;
				if ($diasDecorridos>30){
					$iconePrecoAntigo="<img title='Produto sem atualização a $diasDecorridos dias' 
										src='../imagens/warning.png' width='16' height='16'/>";
				}
				else{
					$iconePrecoAntigo="&nbsp";
				}

				
					//$dtatualizacao=date("d/m/Y",strtotime($dtmovimento));



				$queryVendasUltimos7dias="	SELECT SUM(quantidade) as quantidade_vendida  
											FROM notas_detalhes, notas  
											WHERE notas.idnota=notas_detalhes.idnota 
											AND notas.dtnota>(DATE_SUB(CURDATE(), INTERVAL 7 DAY)) 
											AND notas_detalhes.cdproduto ='$cdproduto'";
				$resultadoVendasUltimos7dias = mysql_query($queryVendasUltimos7dias,$conexao);
				$vendasUltimos7dias=mysql_result($resultadoVendasUltimos7dias,0,0);
			
					
				$queryVendasUltimos30dias="	SELECT SUM(quantidade) as quantidade_vendida  
											FROM notas_detalhes, notas  
											WHERE notas.idnota=notas_detalhes.idnota 
											AND notas.dtnota>(DATE_SUB(CURDATE(), INTERVAL 30 DAY)) 
											AND notas_detalhes.cdproduto ='$cdproduto'";
				$resultadoVendasUltimos30dias = mysql_query($queryVendasUltimos30dias,$conexao);
				$vendasUltimos30dias=mysql_result($resultadoVendasUltimos30dias,0,0);
			
				$informacaoProduto="Vendas últimos  7 dias = $vendasUltimos7dias\nVendas últimos 30 dias = $vendasUltimos30dias";
                */




				// Exibição dos dados
				echo   "<tr>
						<td>$cdProdutoFormatado</td>
						<td>$marcaProduto</td>
						<td>$nome</td>
						<td><a href='' target='_blank'><img src='../imagens/informacao.png' width='16' height='16' title='$informacaoProduto'/></a></td>
						<td><a href='../t/BDJavascript.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/target.png' width='16' height='16' /></a></td>";
						

				echo "<td>
							<img src='../imagens/lista.png' 
							onclick=\"window.open('elisthistorico.php?cdproduto=$cdproduto','popup','status=no,scrollbars=no,width=600,height=500,top='+(window.innerHeight-600)/2+',left='+(window.innerWidth-900)/2+'')\" 
							width='16' height='16'/>
					</td>";
				//<td><a href='elisthistorico.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/lista.png' width='16' height='16' title='Ver valor de compra' /></a></td>
				echo "	<td>
							<a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a>
						</td>
						<td>
							<a href='BDProduto.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/boia.png' width='16' height='16' title='Listagem manual Links Boadica'/></a>
						</td>
						<td align='right'>
							$quantidade_total
						</td>";



                /*
				//if (($nivelusuario>=4)){
				echo "<td align='right'>".$vlcusto_do_produto."</td>";
				
				
				echo "<td align='right'>".$vlvenda."</td>";


				echo "<td><a href='einc.php?cdproduto=$cdproduto' target='_blank'>
				<img style='padding-left: 5px;' src='../imagens/addEstoque.png' title='Editar o produto' width='16' height='16' /></a></td>
				<td>$iconePrecoAntigo</td>";

				//	}
				//	else
				//		{
				//		echo "<td>&nbsp;</td>"; //Custo
				//		echo "<td><a href='einc.php?cdproduto=$cdproduto' target='_blank'><img style='padding-left: 5px;' src='../imagens/addEstoque.png' title='Editar o produto' width='16' height='16' /></a></td>
				//		<td>&nbsp;</td>";	
				//		}
				
				
					
					
				
					if (($nivelusuario>=4)){
						echo "	<td align='right'>$cdmoeda</td>		
								<td align='right'>$vlcusto_do_produto_brl</td>
								<td align='right'>$vlcustototaldoproduto</td>";
					}
					else{
						echo "<td colspan='3'>&nbsp</td>";
					}
					
					echo "<td align='right'>$vltotaldoproduto</td>";
					if (($nivelusuario>=4)){
						echo" <td align='right'>$vllucrototaldoproduto</td>";	
					}
					else{
						echo "<td>&nbsp</td>";
					}
					echo "</tr>";
				
				// echo "<tr><td colspan='7'>".$valor_total_custo."</td></tr>";
                */

                //$quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueProduto;
                //Rotina para contar o estoque de todas as lojas do grupo
                
                $dadosEstoque=contaEstoque($cdproduto, $cdloja, $conexao);
                $quantEstoqueProduto=$dadosEstoque[0];
                
                //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
                $query="SELECT lojas_grupo   
                        FROM lojas 
                        WHERE cdloja='$cdloja'";
                $resultado = mysql_query($query,$conexao);
                $lojasGrupo=mysql_result($resultado,0,0);

                $arrayLojasGrupo=explode(',', $lojasGrupo);
                // Retira o código da loja da lista de destino (para não transferir para ela mesma)
                $arrayLojasGrupo=array_diff($arrayLojasGrupo, array($cdloja));

                $quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueProduto;

                //Apaga o conteudo do title anterior
                $titleQuantidadeEstoqueProdutoOutrasLojas="";
                foreach ($arrayLojasGrupo as $cdLojaContandoEstoque) {
                    $queryApelidoLoja="	SELECT apelido 
                                        FROM lojas 
                                        WHERE cdloja=$cdLojaContandoEstoque";
                    $resultadoApelidoLoja = mysql_query($queryApelidoLoja,$conexao);
                    $apelidoLoja=mysql_result($resultadoApelidoLoja,0,0);
                    //echo "<option value='$item' selected>
                    //		$apelidoLoja
                    //	</option>";
                    $dadosEstoque=contaEstoque($cdproduto, $cdLojaContandoEstoque, $conexao);
                    $quantEstoqueProdutoOutraLoja=$dadosEstoque[0];
                    $quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueTotalProdutoEmTodasAsLojas+$quantEstoqueProdutoOutraLoja;
                    $titleQuantidadeEstoqueProdutoOutrasLojas=$titleQuantidadeEstoqueProdutoOutrasLojas."$apelidoLoja | $quantEstoqueProdutoOutraLoja\n";
                }

                $queryEstoqueIdeal="SELECT produtos_complemento.estoque_ideal    
                                    FROM  produtos_complemento  
                                    WHERE produtos_complemento.cdproduto='$cdproduto'  
                                    AND cdloja='$centroDeCustos'";
                //echo "$queryEstoqueIdeal<br>";
                $resultadoEstoqueIdeal = mysql_query($queryEstoqueIdeal,$conexao);
                $estoqueIdeal=mysql_result($resultadoEstoqueIdeal,0,0);

                /*
                if($estoqueIdeal==0 OR $estoqueIdeal==''){
                    $estoqueIdeal="<a href='pinc.php?cdproduto=$cdProduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a>";
                }
                */


                // Adicionado em 26Mar23 para fechar a TR

              if($quantEstoqueProduto<$estoqueIdeal AND $estoqueIdeal>0 AND $estoqueIdeal<>''){
                $backGroundColor="style=\"background-color:$corMarcaTexto\""; // vem da tabela parametros
              }
              else{
                $backGroundColor="";
              }

              if($quantEstoqueProduto>0){
                $quantidadeRepor=$estoqueIdeal-$quantEstoqueProduto;
              }
              else{
                $quantidadeRepor=$estoqueIdeal;
              }
                echo "      <td width='120'  $backGroundColor align='right'>
                                $quantEstoqueProduto
                            </td>";
                if($estoqueIdeal>0 AND $estoqueIdeal!=''){   
                        echo"       <td width='60'  align='right'>
                                        $estoqueIdeal
                                    </td>";
                }
                else{
                        echo"       <td width='60'  align='right'>
                                        <a href='pinc.php?cdproduto=$cdProduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a>
                                    </td>";

                }
                echo"       <td width='60'  align='right'  title='$titleQuantidadeEstoqueProdutoOutrasLojas'>
                                $quantEstoqueTotalProdutoEmTodasAsLojas
                            </td>
                            <td align='right'>
                                $quantidadeRepor
                            </td>";
                echo "</tr>";

			}
            /*
			echo "<tr><td colspan='10'>&nbsp;</td><td colspan='2'> Valor das vendas: </td><td  colspan='2' align='right'>".number_format($valor_total,2,".","")."</td></tr>";

			if (($nivelusuario>=4)){
				echo "	<tr>
							<td colspan='10'>&nbsp;</td>
							<td colspan='2'> Valor dos custos: </td>
							<td  colspan='2' align='right'>".number_format($valor_total_custo,2,".","")."</td>
						</tr>";
			}
			if (($nivelusuario>=4)){
				echo "	<tr>
							<td colspan='10'>&nbsp;</td>
							<td colspan='2'> Lucro presumido no dia: </td>
							<td  colspan='2' align='right'>".number_format($valor_total-$valor_total_custo,2,",","")."</td>
						</tr>";
			}
            */
		
			echo "</table>";
		?>

        		<!-- Funções da página -->
		<? 
				function contaEstoque($cdproduto, $cdLojaParaContarEstoque, $conexao){
					// Entradas
					$query="SELECT sum(quantidade) as quantidade_entrada 
							FROM estoque 
							WHERE cdloja='".$cdLojaParaContarEstoque."' AND historico>=50 AND cdproduto='$cdproduto'";
					$resultado = mysql_query($query,$conexao);
					$quantidadeEntrada=mysql_result($resultado,0,0);
					//echo "$query<br>";
		
					// Vendas
					$query="SELECT sum(notas_detalhes.quantidade) as quantidade_vendida 
							FROM notas_detalhes, notas 
							WHERE notas.cdloja='$cdLojaParaContarEstoque' AND notas.idnota=notas_detalhes.idnota AND cdproduto='$cdproduto'";
					$resultado = mysql_query($query,$conexao);
					$quantidadeVendida=mysql_result($resultado,0,0);
		
					// Saidas diversas 
					$query="SELECT sum(quantidade) as quantidade_saida 
							FROM estoque 
							WHERE cdloja='$cdLojaParaContarEstoque' AND historico<50 AND cdproduto='$cdproduto'";
					$resultado = mysql_query($query,$conexao);
					$quantidadeSaida=mysql_result($resultado,0,0);
		
					$estoqueAtual=$quantidadeEntrada-$quantidadeSaida-$quantidadeVendida; // Indice 0
		

					// Metodo padrão para retornar mais de um valor em uma função
					$dadosEstoque=array($estoqueAtual);
					return $dadosEstoque;
				}
        ?>

	</body>
</html>
