<?php
	//Mostra erros do php
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');	

	//Prepara conexao ao db
	include("../conectadb.php");

  	// Inicializa a sessão
	include("msession.php");
	IF(!$logado){	
		echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	} 
	//echo $nivelusuario;

	$queryCentroDeCustos="	SELECT cdloja_centro_custo  
							FROM lojas  	
							WHERE cdloja='".$cdloja."'";
	$resultadoCentroDeCustos = mysql_query($queryCentroDeCustos,$conexao);
	$centroDeCustos=mysql_result($resultadoCentroDeCustos,0,0);

	$queryCentroDePrecos="	SELECT cdloja_centro_precos  
							FROM lojas  	
							WHERE cdloja='".$cdloja."'";
	$resultadoCentroDePrecos = mysql_query($queryCentroDePrecos,$conexao);
	$centroDePrecos=mysql_result($resultadoCentroDePrecos,0,0);

	//Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
	$query="SELECT lojas_grupo   
			FROM lojas 
			WHERE cdloja='$cdloja'";
	$resultado = mysql_query($query,$conexao);
	$lojasGrupo=mysql_result($resultado,0,0);

	$arrayLojasGrupo=explode(',', $lojasGrupo);
	// Retira o código da loja da lista de destino (para não transferir para ela mesma)
	$arrayLojasGrupo=array_diff($arrayLojasGrupo, array($cdloja));

?>
<html>
	<head>
		<title>Pesquisar produtos</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="../bibliotecas/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../bibliotecas/datatables/dataTables.bootstrap4.css">
		<link rel="stylesheet" href="../css/sb-admin.min.css">
		<link rel="stylesheet" type="text/css" href="manutencao.css">
	</head>

	<body class="body">
		<?
			//Recebe variaveis
			$token=$_REQUEST["token"];
			$depuracao=$_REQUEST["depuracao"];
			$busca=$_REQUEST["busca"];
			$ArrayChave  = explode(' ', $busca);
			$chave1=$ArrayChave[0];
			$chave2=$ArrayChave[1];
			if ($chave2<>""){
				$condicaoChave2=" OR fabricantes.nome LIKE '%$chave2%' ";
			}

			$chave3=$ArrayChave[2];
			if ($chave3<>""){
				$condicaoChave3=" OR fabricantes.nome LIKE '%$chave3%' ";
			}
			//echo "<div>c1: $chave1, c2: $chave2 c3: $chave3</div>";
			// Mostra depuracao
			include("depuracao.php"); 
		?> 

		

			

				
		<div class="container mx-auto">

			<!-- Inclui o menu -->
			<? include("mmenu.php"); ?>    

			<div>
				Resultado da busca: <? echo "$busca"; ?>
			</div>
			<div>
				Centro de Custos: <? echo $centroDeCustos; ?>
			</div>
			<div>
				Centro de Preços: <? echo $centroDePrecos; ?>
			</div>	

		

			<?php

				IF ($busca<>""){
					$query="SELECT produtos.cdproduto, produtos.nome, produtos.cdsubcategoria, subcategoria.descricao, produtos.cdfabricante, 
					produtos.modelo, precos.vlvenda, precos.vlvendasite, produtos.cdbase, precos.ativo       
					FROM produtos, subcategoria, precos, fabricantes   
					WHERE produtos.cdsubcategoria=subcategoria.cdsubcategoria 
					AND precos.cdproduto=produtos.cdproduto 
					AND produtos.cdfabricante=fabricantes.cdfabricante 
					AND precos.cdloja=$centroDePrecos  
					AND (
					(produtos.nome LIKE '%$chave1%' AND  produtos.nome LIKE '%$chave2%' AND  produtos.nome LIKE '%$chave3%')  
					OR produtos.ean='$chave1'    
					OR produtos.cdproduto='$chave1'
					OR produtos.modelo LIKE '%$chave1%'  
					OR fabricantes.nome LIKE '%$chave1%' 
					$condicaoChave2 
					$condicaoChave3
					) 
					ORDER BY nome, cdfabricante";
					//echo "Query: $query<br>";
					$resultado = mysql_query($query,$conexao);
					$quantidadeRetornadaQuery=mysql_num_rows($resultado);
					IF($quantidadeRetornadaQuery==0){
						$query="SELECT produtos.cdproduto, produtos.nome, produtos.cdsubcategoria, subcategoria.descricao, produtos.cdfabricante, 
								produtos.modelo, 0 as vlvenda, 0 as vlvendasite, produtos.cdbase      
								FROM produtos, subcategoria, fabricantes   
								WHERE produtos.cdsubcategoria=subcategoria.cdsubcategoria 
								
								AND produtos.cdfabricante=fabricantes.cdfabricante 
								
								AND (
								(produtos.nome LIKE '%$chave1%' AND  produtos.nome LIKE '%$chave2%' AND  produtos.nome LIKE '%$chave3%')  
								OR produtos.ean='$chave1'    
								OR produtos.cdproduto='$chave1'
								OR produtos.modelo LIKE '%$chave1%'  
								OR fabricantes.nome LIKE '%$chave1%' 
								$condicaoChave2 
								$condicaoChave3
								) 
								ORDER BY nome, cdfabricante";
								//echo "Query: $query<br>";
								$resultado = mysql_query($query,$conexao);
					}
				}
			?>

			<div class='msearchCdproduto'>Código</div>
			<div class='msearchCdsubcategoria'>Cat</div>
			<div class='msearchImagem'>&nbsp</div>
			<div class='msearchFabricante'>Marca</div>
			<div class='msearchNome'>Nome</div>
			<div class='msearchModelo'>Modelo</div>
			<div class='msearchPreco'>Lojas</div>
			<div class='msearchPreco'>Site</div>
			<div class='msearchEstoque'>Estoque</div>
			<div class='msearchCompras'>Compras</div>
			<div class='msearchIcones'>&nbsp</div>
			<div class='msearchIcones'>&nbsp</div>
			<div class='msearchIcones'>&nbsp</div>
			<div class='msearchIcones'>&nbsp</div>
			<div class='msearchIcones'>&nbsp</div>
			<div class='msearchIcones'>&nbsp</div>

			<?

				WHILE ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
					$cdproduto=$row[0]; 
					$nome=$row[1];
					$cdsubcategoria=$row[2];
					$descricaosubcategoria=$row[3];
					$cdFabricante=$row[4];
					$modeloProduto=$row[5];
					$precoProduto=$row[6];
					if ($cdFabricante==0){
						$nomeFabricante="N/D";
					}
					else{
						$queryFabricante="SELECT nome FROM fabricantes WHERE cdfabricante=$cdFabricante";
						$resultadoFabricante = mysql_query($queryFabricante,$conexao);
						$nomeFabricante=mysql_result($resultadoFabricante,0,0);
					}
					$vlVendaSiteProduto=$row[7];
					$cdBaseProduto=$row[8];
					if($cdproduto==$cdBaseProduto){
						$corFonte="fonteAzul";
					}
					else{
						$corFonte="";
					}
					$cdProdutoAtivo=$row[9];
					if($cdProdutoAtivo==0){
						$iconeInformacaoProduto="informacaoRed.png";
					}
					else{
						$iconeInformacaoProduto="informacao.png";
					}
					$dadosEstoque=contaEstoque($cdproduto, $cdloja, $conexao);
					$quantEstoqueProduto=$dadosEstoque[0];

					/*
					Status das encomendas

					0- Comprado bandeira china
					1- Enviado aviao
					2- Recebido pelos Correios bandeira Brasil
					3- Fiscalização terminada Leãozinho
					4- Unidade de distribuição Caminhão
					5- Entregue check
					*/

					$queryComprasEfetuadas="SELECT sum(quantidade) 
											AS quantidade 
											FROM compras_detalhes, compras  
											WHERE compras_detalhes.idcompra=compras.idcompra  
											AND compras_detalhes.cdproduto ='$cdproduto' 
											AND compras.cdstatus<5 
											AND compras.cdloja='$cdLoja'"; // somente os 'A chegar...'
					//echo "Query Compras Efetuadas: $queryComprasEfetuadas<br>";
					$resultadoComprasEfetuadas = mysql_query($queryComprasEfetuadas,$conexao);
					$quantComprasEfetuadas=mysql_result($resultadoComprasEfetuadas,0,0);
					if ($quantComprasEfetuadas==""){
						$linkQuantComprasEfetuadas="<a href='cListagemProdutos?cdproduto=$cdproduto' target='_blank'>0</a>";
					}
					else{
						$linkQuantComprasEfetuadas="<a href='cListagemProdutos?cdproduto=$cdproduto' target='_blank'>$quantComprasEfetuadas</a>";
					}

					// Pesquisa do preços de custo
					$queryVlCompra="SELECT estoque.vlindividual, estoque.dtmovimento, fornecedor.apelido  
									FROM estoque, fornecedor 
									WHERE estoque.fornecedor=fornecedor.id 
									AND cdproduto='$cdproduto' 
									AND cdloja = '1' 
									AND historico = 51 
									ORDER BY dtmovimento DESC";
					$resultadoVlCompra = mysql_query($queryVlCompra,$conexao);
					$vlCompraConcatenado="";
					while ($row = mysql_fetch_array($resultadoVlCompra, MYSQL_NUM)) {
						$vlcompra=$row[0]; 

						$dtcompra=$row[1]; 
						//echo "dtCompraLoop $dtcompra<br>";
						$apelidoFornecedor=$row[2];
						$vlCompraConcatenado=$vlCompraConcatenado."$vlcompra $dtcompra $apelidoFornecedor\n";
					}
					
					$queryVendasUltimos7dias="SELECT SUM(quantidade) as quantidade_vendida  
												FROM notas_detalhes, notas  
												WHERE notas.idnota=notas_detalhes.idnota 
												AND notas.dtnota>(DATE_SUB(CURDATE(), INTERVAL 7 DAY)) 
												AND notas_detalhes.cdproduto ='$cdproduto'";
					$resultadoVendasUltimos7dias = mysql_query($queryVendasUltimos7dias,$conexao);
					$vendasUltimos7dias=mysql_result($resultadoVendasUltimos7dias,0,0);

						
					$queryVendasUltimos30dias="SELECT SUM(quantidade) as quantidade_vendida  
												FROM notas_detalhes, notas  
												WHERE notas.idnota=notas_detalhes.idnota 
												AND notas.dtnota>(DATE_SUB(CURDATE(), INTERVAL 30 DAY)) 
												AND notas_detalhes.cdproduto ='$cdproduto'";
					$resultadoVendasUltimos30dias = mysql_query($queryVendasUltimos30dias,$conexao);
					$vendasUltimos30dias=mysql_result($resultadoVendasUltimos30dias,0,0);

					$informacaoProduto="Valor de compra: \n$vlCompraConcatenado\n\nVendas últimos  7 dias = $vendasUltimos7dias\nVendas últimos 30 dias = $vendasUltimos30dias";

					
					$quantEstoqueTotalProdutoEmTodasAsLojas=$quantEstoqueProduto;
					//Rotina para contar o estoque de todas as lojas do grupo
					
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
							
					//ECHO "<div>>a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_self'>$cdproduto</a> - $nome<br>";
									ECHO"
									<div class='msearchCdproduto $corFonte'>
										$cdproduto
									</div>

									<div class='msearchCdsubcategoria' title='$descricaosubcategoria'>
										<a href='BDSubCat.php?cdsubcategoria=$cdsubcategoria'>$cdsubcategoria</a>
									</div>

									<div class='msearchImagem'>
										<img onmouseover='this.width=\"300\"; this.height=\"300\"' onmouseout='this.width=\"60\"; this.height=\"60\"' src='../imagens/produtos/$cdproduto.jpg' width='60' height='60'/>
									</div>

									<div class='msearchFabricante'>
										$nomeFabricante
									</div>

									<div class='msearchNome'>
										$nome
									</div>

									<div class='msearchModelo'>
										$modeloProduto
									</div>

									<div class='msearchPreco'>
										$precoProduto
									</div>

									<div class='msearchPreco'>
										$vlVendaSiteProduto
									</div>


									<div class='msearchEstoque' title='$titleQuantidadeEstoqueProdutoOutrasLojas'>
										$quantEstoqueProduto ($quantEstoqueTotalProdutoEmTodasAsLojas)
									</div>



									<div class='msearchCompras'>
										$linkQuantComprasEfetuadas
									</div>

									<div class='msearchIcones'>
										<img src='../imagens/$iconeInformacaoProduto' width='16' height='16'  title='$informacaoProduto' onclick='alert(\"Posição X: \"+event.clientX);'/>
									</div>

									<div class='msearchIcones'>
										<a href='BDProduto.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/toDo.png' width='16' height='16' /></a>
									</div>

									<div class='msearchIcones'>
										<a href='../m/clocal.php?idfornecedor=0&modo=incluirprodutonalista&cdproduto=$cdproduto' target='_blank'><img src='../imagens/lista_compras.png' width='16' height='16'  title='Exibir todos os preços do codigo $cdproduto'/></a>
									</div>
									
									<div class='msearchIcones'>
										<a href='einc.php?cdproduto=$cdproduto' target='_blank'><img src='../imagens/addEstoque.png' width='16' height='16' title='Incluir compra no estoque' /></a>
									</div>

									<div class='msearchIcones'>
										<a href='../$cdproduto' target='_blank'><img src='../imagens/www.png' title='Ver produto no site' width='16' height='16' /></a>
									</div>

									<div class='msearchIcones'>
										<a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a>
									</div>";
				}
			?>

		</div>
		<!-- Fim da div conteudo_principal -->
			
		<!-- Inicio do conteudo secundario -->
		<? include("propaganda.php"); ?>

		<!-- Inicio do conteudo rodape -->
		<? include("rodape.php"); ?>
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


		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="../bibliotecas/jquery-easing/jquery.easing.min.js"></script>

		<script src="../bibliotecas/datatables/jquery.dataTables.js"></script>
		<script src="../bibliotecas/datatables/dataTables.bootstrap4.js"></script>
		<script src="../js/sb-admin.min.js"></script>
		<script src="../js/sb-admin-datatables.min.js"></script>
	</body>
</html>