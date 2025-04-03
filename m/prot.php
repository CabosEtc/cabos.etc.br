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
		<title>Produtos Rotinas</title>
		<meta http-equiv= "Content-Type" content= "text/html; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="manutencao.css">
		<? IF(!$logado){	echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";} ?>
	</head>
	<body>
		<?
			//Recebe variaveis
			$token=$_REQUEST["token"];
			$depuracao=$_REQUEST["depuracao"];

			// Mostra depuracao
			//include("depuracao.php"); 

			// Ativa a exibição de erros
			//ini_set('display_errors', 1);
			//ini_set('display_startup_errors', 1);
			//error_reporting(E_ALL);
		
		?> 


		<script src="banner.js"></script>
		<script src="javascript.js"></script>


		<div id="wrapper" class="wrapper">

			<!-- Espacamento superior -->
			<div id="topo" class="topo"></div>

			<!-- Inclui banner -->
			<? //include("banner.php"); ?>
				
			<!-- Inclui o menu -->
			<? include("mmenu.php"); ?>    

			<!-- Conteudo principal -->
			<div id="corpo" class="corpo">
				<?
					// recebe os dados 

					$modo=$_REQUEST["modo"];
					$cdproduto=$_REQUEST["cdproduto"];
					$nome=$_REQUEST["nome"];
					$cdfabricante=$_REQUEST["cdfabricante"];
					$modelo=$_REQUEST["modelo"];
					$garantia=$_REQUEST["garantia"];
					IF($garantia==''){
						$garantia=90;
					}
					$cdsubcategoria=$_REQUEST["cdsubcategoria"];
					$descricao=str_replace("\"","'",$_REQUEST["descricao"]);
					$caracteristicas=$_REQUEST["caracteristicas"];
					$compatibilidade=$_REQUEST["compatibilidade"];
					$peso=$_REQUEST["peso"];
					IF($peso==''){
						$peso=0;
					}
					$comp=$_REQUEST["comp"];
					IF($comp==''){
						$comp=0;
					}
					$larg=$_REQUEST["larg"];
					IF($larg==''){
						$larg=0;
					}
					$alt=$_REQUEST["alt"];
					IF($alt==''){
						$alt=0;
					}
					$ean=$_REQUEST["ean"];
					$emb_peso=$_REQUEST["emb_peso"];
					IF($emb_peso==''){
						$emb_peso=0;
					}
					$emb_comp=$_REQUEST["emb_comp"];
					IF($emb_comp==''){
						$emb_comp=0;
					}
					$emb_larg=$_REQUEST["emb_larg"];
					IF($emb_larg==''){
						$emb_larg=0;
					}
					$emb_alt=$_REQUEST["emb_alt"];
					IF($emb_alt==''){
						$emb_alt=0;
					}

					
					if (isset($_REQUEST["vlvenda"])) {
						$vlvenda=$_REQUEST["vlvenda"]; // Atribui o valor do dado à variável
					} else {
						$vlvenda=0; // Define um valor padrão caso o dado não exista
					}
					$vlvenda = str_replace(",",".", $vlvenda);
					$vlVendaLoja=$_REQUEST["vlVendaLoja"];
					if ($vlVendaLoja==""){
						$vlVendaLoja=0;
					}
					$vlVendaLoja = str_replace(",",".", $vlVendaLoja);


					$vlVendaSite=$_REQUEST["vlVendaSite"];
					if ($vlVendaSite==""){
						$vlVendaSite=0;
					}
					$vlVendaSite = str_replace(",",".", $vlVendaSite);

					$status=$_REQUEST["status"];
					$img_a=$_REQUEST["img_a"];
					$img_b=$_REQUEST["img_b"];
					$img_c=$_REQUEST["img_c"];
					$img_d=$_REQUEST["img_d"];
					$pendencias=$_REQUEST["pendencias"];
					$modo=$_REQUEST["modo"];
					$vlCompra=$_REQUEST["vlCompra"];
					if ($vlCompra==""){
						$vlCompra=0;
					}
					$vlCompra = str_replace(",",".", $vlCompra);
					
					if (isset($_REQUEST["idlog"])) {
						$idLog=$_REQUEST["idlog"]; // Atribui o valor do dado à variável
					} else {
						$idLog=null; // Define um valor padrão caso o dado não exista
					}
					//SEO

					$urlProduto=$_REQUEST["url"];
					$titleProduto=$_REQUEST["title"];
					$descriptionProduto=$_REQUEST["description"];
					$keywordsProduto=$_REQUEST["keywords"];
					$estoqueIdeal=intval($_REQUEST["estoque_ideal"]); //retorna zero se não for um numero
					$estoqueMinimo=intval($_REQUEST["estoque_minimo"]);

					$flagSerial=intval($_REQUEST["flagserial"]);
					$flagAtivo=$_REQUEST["flagAtivo"];
					//echo "flagAtivo: $flagAtivo<br>";
					if($flagAtivo=="on"){
						$flagAtivo=1;
					}
					else{
						$flagAtivo=0;
					}

					/* Adicionado em 29Ag24*/
					
					$flagAtivoSite=$_REQUEST["flagAtivoSite"];
					echo "flagAtivoSite: $flagAtivoSite<br>";
					if($flagAtivoSite=="on"){
						$flagAtivoSite=1;
					}
					else{
						$flagAtivoSite=0;
					}


					$query="SELECT cdcategoria, descricao 
							FROM `subcategoria` 
							where cdsubcategoria='$cdsubcategoria'  
							AND cdloja='1' ";
					//echo "$query<br>";
					$resultado = mysql_query($query,$conexao);
					$acheiSubcategoria=mysql_num_rows($resultado);
					echo "achei $acheiSubcategoria resultados para o código de subcategoria<br>";
					$cdcategoria=mysql_result($resultado,0,0);
					$descricaosubcategoria=mysql_result($resultado,0,1);

					$query="SELECT vlvenda 
							FROM precos 
							where cdproduto='$cdproduto'  
							AND cdloja=1 ";
					//echo "$query<br>";
					$resultado = mysql_query($query,$conexao);
					$vlVendaLojaBD=mysql_result($resultado,0,0);
					
					$query="SELECT status, vlvenda 
							FROM `pvenda` 
							WHERE `cdproduto`=$cdproduto 
							AND idloja=$cdloja 
							ORDER BY `dt` DESC limit 1";
					//echo "$query<br>";
					$resultado = mysql_query($query,$conexao);
					$statusBD=mysql_result($resultado,0,0);
					$vlvendaBD=mysql_result($resultado,0,1);

					if ($modo=="incluir"){
						switch ($cdcategoria) {
							case 2: 
								$faixa="20000 AND 29999";
								$codigoinicial=20000;
							break;
							case 3:
								$faixa="30000 AND 39999";
								$codigoinicial=30000;
							break;
							case 4:
								$faixa="40000 AND 49999";
								$codigoinicial=40000;
							break;
							case 5:
								$faixa="50000 AND 59999";
								$codigoinicial=50000;
							break;
							case 6:
								$faixa="60000 AND 69999";
								$codigoinicial=60000;
							break;
							case 7:
								$faixa="70000 AND 79999";
								$codigoinicial=70000;
							break;
							case 8:
								$faixa="80000 AND 80999";
								$codigoinicial=80000;
							break;
							case 9: 
								$faixa="81000 AND 81999";
								$codigoinicial=81000;
							break;
							case 10:
								$faixa="82000 AND 83999";
								$codigoinicial=82000;
							break;
							case 11:
								$faixa="84000 AND 84999";
								$codigoinicial=84000;
							break;
							case 12:
								$faixa="85000 AND 85999";
								$codigoinicial=85000;
							break;
							case 1: // Não existe mais categoria 13 foi para 1 - Outros
								$faixa="86000 AND 86999";
								$codigoinicial=86000;
							break;
							default: // Incluido em 06Dez24
							$faixa="90000 AND 99998";
							$codigoinicial=90000;
							break;
						}

						$query="SELECT cdproduto 
								FROM `produtos` 
								WHERE `cdproduto` 
								BETWEEN ".$faixa." ORDER BY `cdproduto` DESC limit 1";
						//echo "$query<br>";
						$resultado = mysql_query($query,$conexao);
						$cdproduto=mysql_result($resultado,0,0)+1;
						IF ($cdproduto==1){
							$cdproduto=$codigoinicial;
						}

						//ECHO "O proximo codigo sera $cdproduto<br>";
						// seleciona o produto no banco de dados
						$queryProdutos="INSERT INTO `produtos`(`cdproduto`, `nome`, `cdfabricante`, `modelo`, `garantia`, `cdsubcategoria`, `descricao`, `caracteristicas`, `compatibilidade`, `peso`, `comp`,`larg`, `alt`, `ean`, 
						`emb_peso`, `emb_comp`, `emb_larg`, `emb_alt`, `img_a`, `img_b`, `img_c`, `img_d`, `pendencias`, `url`, `title`, `description`, `keywords`,`flagserial`) 
						VALUES ('$cdproduto', '$nome', $cdfabricante, '$modelo', '$garantia', $cdsubcategoria, \"$descricao\", \"$caracteristicas\", '$compatibilidade', $peso, $comp, $larg, 
						$alt, '$ean', $emb_peso, $emb_comp, $emb_larg, $emb_alt, '$img_a', '$img_b', '$img_c', '$img_d', '$pendencias','$urlProduto','$titleProduto','$descriptionProduto','$keywordsProduto',$flagSerial)";
						$resultadoProdutos = mysql_query($queryProdutos,$conexao);
						echo "<div>QueryProdutos: $queryProdutos</div>";
						$linhasAfetadas=mysql_affected_rows();
						echo "Linhas afetadas: $linhasAfetadas<br>";

						$queryPrecos="INSERT INTO precos (idpreco,cdproduto, cdloja, cdsubcategoria, vlcompra, dtatualizacao, cdmoeda, vlvenda, 
						vlvendasite, quant_estoque_min, garantia, multiplicador3x, multiplicador6x, multiplicador9x, multiplicador12x, 
						ativo, siteflag)  
						VALUES (null, '$cdproduto', $cdloja, $cdsubcategoria, $vlCompra, CURRENT_TIMESTAMP, 'BRL', $vlVendaLoja, 
						$vlVendaSite, $estoqueMinimo, $garantia, 0, 0, 0, 0, $flagAtivo, $flagAtivoSite)"; // Corrigir esta ultima informação, vai dar sempre como inativo no site, ver como a rotina do site está programada
						echo "<div>Query Preços: $queryPrecos</div>";	
						$resultadoPrecos = mysql_query($queryPrecos,$conexao);
						$linhasAfetadas=mysql_affected_rows();
						echo "Linhas afetadas: $linhasAfetadas<br>";
						
						$queryProdutosComplemento="INSERT INTO produtos_complemento (id,cdproduto, cdloja, estoque_ideal, estoque_minimo)  
						VALUES (null, '$cdproduto', $cdloja, $estoqueIdeal, $estoqueMinimo)";
						$resultadoProdutosComplemento = mysql_query($queryProdutosComplemento,$conexao);
						echo "<div>queryProdutosComplemento: $queryProdutosComplemento</div>";
						$linhasAfetadas=mysql_affected_rows();
						echo "Linhas afetadas: $linhasAfetadas<br>";	
						
						echo "<h2>Produto inserido com sucesso</h2><br>";
						echo "<div>Produto: <a href='https://www.cabos.etc.br/m/pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'>$cdproduto</a> | $nome</div>";
						echo "<div><b>Categoria:</b> $cdcategoria / <b>Subcategoria:</b> $cdsubcategoria / <b>Descricao:</b> $descricaosubcategoria</div>";
					}


					IF ($modo=="editar"){
						$query="UPDATE `produtos` 
								SET `nome`='$nome',`cdfabricante`=$cdfabricante, `modelo`='$modelo', `garantia`=$garantia, `cdsubcategoria`=$cdsubcategoria, 
								`descricao`='$descricao' , `caracteristicas`='$caracteristicas', `compatibilidade`='$compatibilidade', 
								`peso`=$peso, `comp`=$comp, `larg`=$larg, `alt`=$alt, `ean`='$ean', `emb_peso`=$emb_peso, `emb_comp`=$emb_comp, 
								`emb_larg`=$emb_larg, `emb_alt`=$emb_alt, 
								`img_a`='$img_a', `img_b`='$img_b', `img_c`='$img_c', `img_d`='$img_d', `pendencias`='$pendencias', 
								`url`='$urlProduto', `title`='$titleProduto', `description`='$descriptionProduto', `keywords`='$keywordsProduto', `flagserial`=$flagSerial    
								WHERE `produtos`.`cdproduto`='$cdproduto'";

						$resultado = mysql_query($query,$conexao);
						echo "<div>QueryProdutos: $query</div>";
						$linhasAfetadas=mysql_affected_rows();
						echo "Linhas afetadas: $linhasAfetadas<br>";

						$query="UPDATE precos 
								SET vlvenda=$vlVendaLoja, vlcompra=$vlCompra, cdmoeda='BRL' , dtatualizacao='$dthoje_eua', vlvendasite=$vlVendaSite, ativo=$flagAtivo, siteflag=$flagAtivoSite      
								WHERE cdproduto='$cdproduto'  
								AND cdloja=$cdloja";
						echo "<div>QueryPrecos: $query</div>";
						$resultado = mysql_query($query,$conexao);
						$linhasAfetadas=mysql_affected_rows();
						echo "Linhas afetadas: $linhasAfetadas<br>";
						if($linhasAfetadas==0){
							$query="INSERT INTO precos (idpreco,cdproduto, cdloja, cdsubcategoria, vlcompra, dtatualizacao, cdmoeda, vlvenda, 
							vlvendasite, quant_estoque_min, garantia, multiplicador3x, multiplicador6x, multiplicador9x, multiplicador12x, 
							ativo, siteflag)  
							VALUES (null, '$cdproduto', $cdloja, $cdsubcategoria, $vlCompra, CURRENT_TIMESTAMP, 'BRL', $vlVendaLoja, 
							0, 0, $garantia, 0, 0, 0, 0, $flagAtivo, $flagAtivoSite)";
							/*
							INSERT INTO `precos` (`idpreco`, `cdproduto`, `cdloja`, `cdsubcategoria`, `vlcompra`, `dtatualizacao`, `cdmoeda`, `vlvenda`, `vlvendasite`, `quant_estoque_min`, `garantia`, `multiplicador3x`, `multiplicador6x`, `multiplicador9x`, `multiplicador12x`, `ativo`, `siteflag`) 
							VALUES (NULL, '30016', '1', '0', '28', '', 'BRL', '59', '', '0', '90', '', '', '', '', '1', '1');
							*/
							//echo "Query insert (se não achar dados anteriores): $query<br>";
							$resultado = mysql_query($query,$conexao);
						}

						
						// Teste se já existe um registro de complemento de informações para o codigo procurado
						$query="SELECT count(*) as totalRegistros FROM produtos_complemento WHERE cdloja=$cdloja AND cdproduto='$cdproduto'";
						//echo "$query<br>";
						$resultado=mysql_query($query, $conexao);
						$totalRegistros=mysql_result($resultado,0,0);
						if($totalRegistros==1){
							//echo "achei um registro";
							$query="UPDATE produtos_complemento  
									SET estoque_ideal=$estoqueIdeal, estoque_minimo=$estoqueMinimo     
									WHERE cdproduto='$cdproduto'  
									AND cdloja=$cdloja";
						}
						else{
							//echo "não achei nada...";
							$query="INSERT INTO produtos_complemento (id,cdproduto, cdloja, estoque_ideal, estoque_minimo)  
									VALUES (null, '$cdproduto', $cdloja, $estoqueIdeal, $estoqueMinimo)";
						}
						

						$resultado = mysql_query($query,$conexao);
						//echo "$query<br>";

						echo "<b>Modo editar</b><br>";


						echo "Registro alterado com sucesso<br><br><br>";
						//echo "<a href='../manutencao/estoque.php'>Voltar para a pagina do estoque</a>";
					}
					//echo $query;

					// Rotina comum aos dois modos
					if ($modo=='editar' or $modo=='incluir'){
						IF ($status<>$statusBD OR $vlvenda<>$vlvendaBD) {
							$query="INSERT INTO `pvenda` (`id`, `idloja`, `cdproduto`, `dt`, `local`, `status`, `vlvenda`, `idusuario`) 
							VALUES (NULL, '$cdloja', '$cdproduto', CURRENT_TIMESTAMP, 2, '$status', '$vlvenda', $idusuario);";
							$resultado = mysql_query($query,$conexao);
						}

						ECHO"<H2>Site</H2>";
						ECHO"Status Anterior: $statusBD / Valor anterior: $vlvendaBD<br>";
						ECHO"Status Atual: $status / Valor atual: $vlvenda<br>";

						IF ($vlVendaLojaBD<>$vlVendaLoja) {
							$query="INSERT INTO `log` (`idlog`, `data`, `loja`, `codigo`, `inf1`, `inf2`, `inf3`, `inf4`) 
							VALUES (NULL, CURRENT_TIMESTAMP, $cdloja, '5', '$cdproduto', '$idusuario', '$vlVendaLojaBD', '$vlVendaLoja');";
							$resultado = mysql_query($query,$conexao);
						}
						//echo $query;

						ECHO"<H2>Loja</H2>";
						ECHO"Valor anterior: $vlVendaLojaBD<br>";
						ECHO"Valor atual: $vlVendaLoja<br>";
						ECHO"<div>Abrir : <a href='https://www.cabos.etc.br/$cdproduto' target='_blank'>página</a> do produto</div>";



							//echo "$query<br><br>";
					}

					if ($modo=='ajustar_tabela_precos'){
						$query="SELECT pdproduto 
								FROM produtos 
								ORDER BY cdproduto";
						$resultado=mysql_query($query, $conexao);
						while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
							$cdProduto=$row[0];
							//echo "$cdProduto R$ ";
							$queryPrecoProduto="SELECT vlvenda 
												FROM precos
												WHERE precos.cdproduto='$cdProduto' 
												AND precos.cdloja=$cdLoja";
							//echo "$queryPrecoProduto";
							$resultadoPrecoProduto=mysql_query($queryPrecoProduto, $conexao);
							$vlVenda=mysql_result($resultadoPrecoProduto,0,0);
							if ($vlVenda==''){
								//echo "Não achei<br>";
								$queryInserePreco=" INSERT INTO precos (cdproduto, cdloja, cdsubcategoria, vlcompra, dtatualizacao, cdmoeda, vlvenda, quant_estoque_min, garantia, ativo, siteflag) 
													VALUES('$cdProduto',$cdLoja, 4, 0, '$dthoje_eua', 'BRL', 999.99, 0, 90, 1, 0)";
								$resultadoInserePreco=mysql_query($queryInserePreco, $conexao);
								//echo "$queryInserePreco<br>";
								echo "Inserido -> $cdProduto R$ 999.99<br>";
							}
							else{
								//echo "$vlVenda<br>";
							}
						}
					}
				?>

					<!--
					<div style="margin-top: 100px;">
						* Atenção: Você pode enviar imagens agora, o arquivo deve ser .PNG, quadrado e com os nomes <? echo $cdproduto.".png / ".$cdproduto."b.png / ".$cdproduto."c.png / ".$cdproduto."d.png";?>
					</div>
					<div>
						<h3>Upload Múltiplo de Imagens</h3>    
						<form action="upload.php" method="post" enctype="multipart/form-data">
							<input type="file" name="arquivos[]" multiple>
							<input name="cdproduto" type="hidden"  value="<?echo $cdproduto;?>" />
							<br>
							<input type="submit" value="Enviar">
						</form>
					</div>

							
					<div>
						Você pode visualizar a inclusão que acabou de efetuar clicando <a href='../produto.php?cd=<?echo $cdproduto; ?>' target='_blank'>aqui</a>
					</div>  
					-->
				<?
					if ($modo=="apagarLogProdutoNaoCadastrado"){
						$query="SELECT inf5 FROM log WHERE idlog=$idLog";
						$resultado=mysql_query($query, $conexao);
						$nomeProduto=mysql_result($resultado,0,0);
						// apaga custo do produto de item=iditem
						$query="DELETE FROM log WHERE idlog=$idLog";
						//echo $query;
						$resultado = mysql_query($query,$conexao);
						echo "<BR><BR><BR>Anúncio do produto <b>$nomeProduto</b> (id $idLog) da tabela log, codigo 301 (produtos não cadastrados) apagado.";
					}
				?>

					
			</div> <!--fim do conteudo principal -->

			<!-- Inicio do conteudo secundario -->
			<? //include("propaganda.php"); ?>

			<!-- Inicio do conteudo rodape -->
			<? //include("rodape.php"); ?>

		</div> <!--fim da div wrapper_site -->
	</body>
</html>
