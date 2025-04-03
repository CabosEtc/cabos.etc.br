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
		<title>Incluir/Editar produtos</title>
		<!-- Incluido em 25Ago24 -->
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="../bibliotecas/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../bibliotecas/datatables/dataTables.bootstrap4.css">
		<link rel="stylesheet" href="../css/sb-admin.min.css">
		<link rel="stylesheet" type="text/css" href="manutencao.css"/>
		<!-- <script type="text/javascript" src="js/ajax2020.js"></script> -->

		<style>
        	.dadosProduto-layer {
            	display: block;
        	}
			.SEO-layer {
            	display: none;
        	}
		</style>
  	</head>

	<body>
		<?php
			//Recebe variaveis
			$token=$_REQUEST["token"];
			$depuracao=$_REQUEST["depuracao"];

			// Outras variaveis
			$modo=$_REQUEST["modo"];
			$cdproduto=$_REQUEST["cdproduto"];

			//Mostra depuracao
			//include("depuracao.php"); 
		?>

		<script src="js/javascript.js"></script>
		<script>
			function MudaStatus(status){
						//alert(status);
						if (status==1) {
						document.getElementById("img_status").src="../imagens/on.png";
						document.getElementById("img_status").title="Clique aqui para desativar no site";
						img_status.setAttribute('onclick',"MudaStatus(0)");
						}
						else {
						document.getElementById("img_status").src="../imagens/off.png";
						document.getElementById("img_status").title="Clique aqui para ativar no site";
						img_status.setAttribute('onclick',"MudaStatus(1)");
						}	
						
						document.getElementById("status").value=status;
						//alert(document.getElementById("img_status").onclick);
			}
			function mostra(aba){
						//alert(aba);
						if (aba=='dados'){
						document.getElementById("dadosProduto-layer").style.display="block";
						document.getElementById("SEO-layer").style.display="none";
						}
						if (aba=='seo'){
						document.getElementById("dadosProduto-layer").style.display="none";
						document.getElementById("SEO-layer").style.display="block";
						}
			}

		</script>


			<!-- Espacamento superior -->
			<div id="topo" class="topo">
				&nbsp;
			</div>
				
			<!-- Inclui o menu -->
			<? 
				include("mmenu.php");
			?>    

				<?
					$query="SELECT cotacao_us FROM parametros";
					$resultado = mysql_query($query,$conexao);
					$cotacao_us=mysql_result($resultado,0,0);

					if($modo==""){
						$flagSerial="1"; // Marca como ativo caso seja modo inclusão ("<>editar")
						$cdfabricante=""; //Se não for informado, é vazio
					}

					if($modo<>"") {
						// Seleciona os dados
						$query="SELECT cdfabricante, nome, modelo, descricao, caracteristicas, cdsubcategoria, peso, comp, larg, alt, ean, 
								emb_peso, emb_comp, emb_larg, emb_alt, img_a, img_b, img_c, img_d, garantia, pendencias, url, keywords, title, description, flagserial, compatibilidade   
								FROM produtos 
								WHERE cdproduto='$cdproduto'";
						//echo $query;
						$resultado = mysql_query($query,$conexao);
						$cdfabricante=mysql_result($resultado,0,0);
						//echo "<div>cdfabricante: $cdfabricante</div>";
						$nome=mysql_result($resultado,0,1);
						$modelo=mysql_result($resultado,0,2);
						$descricao=mysql_result($resultado,0,3);
						$caracteristicas=mysql_result($resultado,0,4);
						$cdsubcategoria=mysql_result($resultado,0,5);
						$peso=mysql_result($resultado,0,6);
						$comp=mysql_result($resultado,0,7);
						$larg=mysql_result($resultado,0,8);
						$alt=mysql_result($resultado,0,9);
						$ean=mysql_result($resultado,0,10);
						$emb_peso=mysql_result($resultado,0,11);
						$emb_comp=mysql_result($resultado,0,12);
						$emb_larg=mysql_result($resultado,0,13);
						$emb_alt=mysql_result($resultado,0,14);
						$img_a=mysql_result($resultado,0,15);
						$img_b=mysql_result($resultado,0,16);
						$img_c=mysql_result($resultado,0,17);
						$img_d=mysql_result($resultado,0,18);
						$garantia=mysql_result($resultado,0,19);
						$pendencias=mysql_result($resultado,0,20);
						$urlProduto=mysql_result($resultado,0,"url");
						$keywordsProduto=mysql_result($resultado,0,"keywords");
						$titleProduto=mysql_result($resultado,0,"title");
						$descriptionProduto=mysql_result($resultado,0,"description");
						$flagSerial=mysql_result($resultado,0,"flagserial");
						$compatibilidade=mysql_result($resultado,0,"compatibilidade");
						

						// Seleciona valor de venda na loja
						$query="SELECT vlvenda, vlcompra, vlvendasite, ativo, siteflag     
								FROM precos  
								WHERE cdproduto='$cdproduto'  
								AND cdloja=$cdloja";
						//echo "$query<br>";
						$resultado = mysql_query($query,$conexao);
						$acheiVlvenda=mysql_num_rows($resultado);
						IF($acheiVlvenda){
							$vlVendaLoja=mysql_result($resultado,0,0);
						}
						else{
							$vlVendaLoja=0;
						}

						$vlCompra=mysql_result($resultado,0,1);
						$vlVendaSite=mysql_result($resultado,0,2);
						$flagProdutoAtivo=mysql_result($resultado,0,3);
						if($flagProdutoAtivo){
							$flagAtivoChecked="checked='checked'";
						}
						else{
							$flagAtivoChecked="";
						}

						$flagProdutoAtivoSite=mysql_result($resultado,0,4);
						if($flagProdutoAtivoSite){
							$flagAtivoSiteChecked="checked='checked'";
						}
						else{
							$flagAtivoSiteChecked="";
						}

						// Seleciona os dados complementares (configuravel por loja)
						$query="SELECT estoque_ideal, estoque_minimo    
						FROM produtos_complemento   
						WHERE cdproduto=$cdproduto 
						AND cdloja=$cdloja";
						//echo $query;
						$resultado = mysql_query($query,$conexao);
						$estoque_ideal=mysql_result($resultado,0,0);
						$estoque_minimo=mysql_result($resultado,0,1);
					}
				?>

				<form action="prot.php" method="post">
					<!-- Alterações de 26Ago24-->

					<div class="container-fluid text-left pt-4">
						<div class="row justify-content-left">
							<!-- Camada 1: Dados principais do Produto -->
							<div class="col-1" onclick="mostra('dados');">
								Dados
							</div>
							<div class="col-3" onclick="mostra('seo');">
								SEO
							</div>
							<div class="col-1">
								<button class="btn btn-primary">Enviar</button>
							</div>
						</div>
					</div>
					<!-- Camada 1: Dados principais do Produto -->		
					<div class="container-fluid text-left dadosProduto-layer active" id="dadosProduto-layer">

						<div class="row py-1">
							<div class="col-1">
								Codigo
							</div>
							<div class="col-3">
								<input name="cdproduto" type="text" id="cdproduto" readonly=“true”  placeholder="Automático" maxlength="5" value="<? echo $cdproduto; ?>"/>
							</div>
							<div class="col-1">
								Nome
							</div>
							<div class="col-3">
								<input name="nome" type="text" id="nome" size="40" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> maxlength="40" value='<?echo $nome;?>'/>
							</div>
							<div class="col-1">
								Categoria
							</div>
							<div class="col-3">
								<?
									echo "<select name='cdsubcategoria' id='cdsubcategoria'>";
									$query="SELECT cdsubcategoria, descricao 
									FROM `subcategoria` 
									where cdloja=1 
									AND flagativo=1 
									order by descricao";
									$resultado = mysql_query($query,$conexao);
									while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
										$cdsubcategoriabd=$row[0]; // codigo da subcategoria
										$descricaosubcategoria=$row[1]; // nome da subcategoria
										
										
										
										IF($cdsubcategoriabd==$cdsubcategoria){
											echo "<option selected value='".$cdsubcategoriabd."' >".$descricaosubcategoria."</option>";
										}
										ELSE{
												echo "<option value='".$cdsubcategoriabd."'>".$descricaosubcategoria."</option>";
										}	
									}
									echo "</select>";
								?>
							</div>


						</div>


						<div class="row py-1">
							<div class="col-1">
								Custo
							</div>
							<div class="col-3">
								<input name="vlCompra" type="text" id="vlCompra"  placeholder="R$ preço" maxlength="8" size="10" <?IF(($nivelusuario<4) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> value="<? echo $vlCompra; ?>"/>
							</div>
							<div class="col-1">
								Loja
							</div>
							
							<div class="col-1">
								<input name="vlVendaLoja" type="text" id="vlVendaLoja"  placeholder="R$ preço" maxlength="8" size="10" value="<? echo $vlVendaLoja; ?>"/>
							</div>
							<div class="col-2">
								<input type='checkbox' id='flagAtivo' name='flagAtivo' data-id='' <?IF(($nivelusuario<4) AND ($modo=="editar")){ECHO "onclick='return false;' ";}?><? echo $flagAtivoChecked; ?>>Ativo
							</div>

							<div class="col-1">
								Site
							</div>
							<div class="col-1">
								<input name="vlVendaSite" type="text" id="vlVendaSite"  placeholder="R$ preço" maxlength="8" size="10" value="<? echo $vlVendaSite; ?>"/>
								<input type='hidden' id='status' name='status' value='<? echo $status;?>'>
							</div>
							<div class="col-2">
								

								<!--
									IF($status=="1"){
										ECHO  "<img id='img_status' src='../imagens/on.png' onclick='MudaStatus(0)' title='Clique para desativar no Site'  />";
									}
									ELSEIF ($status==""){
										ECHO  "<img id='img_status' src='../imagens/warning.png'  onclick='MudaStatus(1)' title='Clique para ativar no Site'/>";
									}
									ELSE {
										ECHO  "<img id='img_status' src='../imagens/off.png'  onclick='MudaStatus(1)'  title='Clique para ativar no Site'/>";
									}
								-->
									<input type='checkbox' id='flagAtivoSite' name='flagAtivoSite' data-id='' <?IF(($nivelusuario<4) AND ($modo=="editar")){ECHO "onclick='return false;' ";}?><? echo $flagAtivoSiteChecked; ?>>Ativo
								
								
							</div>

						</div>

					






						<div class="row py-1">
							<div class="col-1">
								Fabricante
							</div>
							<div class="col-3">
								<?
									echo "<select name='cdfabricante' id='cdfabricante'>";
									$query="SELECT cdfabricante, nome 
											FROM fabricantes 
											ORDER BY nome					";
									$resultado = mysql_query($query,$conexao);
									while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
										$cdfabricantebd=$row[0]; // nome da categoria
										$nome=$row[1]; // nome da categoria
										IF($cdfabricantebd==$cdfabricante){
											//echo "<script>alert('$cdfabricantebd | $cdfabricante | $modo');</script>";
											echo "<option selected value='".$cdfabricante."' >".$nome."</option>";
										}
										ELSE{
											if($cdfabricantebd=="38" and $modo==""){
												echo "<option selected value='".$cdfabricantebd."' >".$nome."</option>";
											}
											else{
												echo "<option value='".$cdfabricantebd."' >".$nome."</option>";
											}
											

												/*
												if($cdfabricantebd=="38" and $modo==""){ // 38 Código do N/D, somente no modelo de inclusao

													//echo "<script>alert('Passei aqui!');</script>";
													echo "<option selected value='".$cdfabricantebd."'>".$nome."</option>";													echo "<option selected value='".$cdfabricantebd."'>".$nome."</option>";
												}
												if($cdfabricantebd<>"38" and $modo==""){
													echo "<option value='".$cdfabricantebd."'>".$nome."</option>";
												}
												if($cdfabricantebd<>"38" and $modo=="editar"){
													echo "<option value='".$cdfabricantebd."'>".$nome."</option>";
												}
												*/
										}
									}
									echo "</select>";
								?>
							</div>
							<div class="col-1">
								Modelo
							</div>
							<div class="col-3">
								<input name="modelo" type="text" id="modelo"  maxlength="20"  value='<? echo $modelo; ?>'/>
							</div>
							<div class="col-1">
								Garantia
							</div>
							<div class="col-1">
								<input name="garantia" type="text" id="garantia"  maxlength="3"  value='<? echo $garantia; ?>' size="6" />
							</div>
							<div class="col-1">
								Dias
							</div>
						</div>







						<div class="row py-1">
							<div class="col-1">
								Descrição
							</div>
							<div class="col-3">
								<textarea name="descricao" cols="60" rows="6" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> id="descricao" type="text" /><? echo $descricao; ?></textarea>
							</div>
							<div class="col-1">
								Caracteristicas
							</div>
							<div class="col-3">
								<textarea name="caracteristicas" cols="60" rows="6" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> id="caracteristicas" type="text" /><? echo $caracteristicas; ?></textarea>
							</div>					
							<div class="col-1">
								Compatibilidade
							</div>
							<div class="col-3">
								<textarea name="compatibilidade" cols="60" rows="6" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> id="compatibilidade" type="text" /><? echo $compatibilidade; ?></textarea>
							</div>
						</div>



						<div class="row py-1">
							<div class="col-1">
								Peso
							</div>
							<div class="col-1">
								<input name="peso" type="text" id="peso"  placeholder="Peso em gramas" maxlength="6" value="<? echo $peso; ?>" size="6" />
							</div>
							<div class="col-2">
								(gramas)
							</div>

							<div class="col-1">
								Dimensoes
							</div>
							<div class="col-1">
								<input name="comp" type="text" id="comp"  placeholder="C cm" maxlength="4" size="4" value="<? echo $comp; ?>"/>
							</div>
							<div class="col-1">
								<input name="larg" type="text" id="larg"  placeholder="L cm" maxlength="4" size="4"  value="<? echo $larg; ?>"/>
							</div>
							<div class="col-1">
								<input name="alt" type="text" id="alt"  placeholder="A cm" maxlength="4"  size="4"  value="<? echo $alt; ?>"/>
							</div>
							<div class="col-4">
								Comprimento x Largura x Altura (cm)
								<input name="modo" type="hidden" id="modo" value="<? IF($modo=="editar"){echo "editar";}ELSE {echo "incluir";}?>" />
							</div>
						</div>


						<div class="row py-1">
							<div class="col-1">
								Estoque Ideal
							</div>
							<div class="col-3">
								<input name="estoque_ideal" type="text" id="estoque_ideal"  placeholder="Quant" maxlength="3" size="5" value="<? echo $estoque_ideal; ?>"/>
							</div>
							<div class="col-1">
								Estoque Minimo
							</div>
							<div class="col-3">
								<input name="estoque_minimo" type="text" id="estoque_minimo"  placeholder="Quant" maxlength="3" size="5" value="<? echo $estoque_minimo; ?>"/>
							</div>
							<div class="col-1">
								Serial na nota:
							</div>
							<div class="col-3">
								<input name="flagserial" type="text" id="flagserial"  placeholder="0/1" maxlength="1" size="5" value="<? echo $flagSerial; ?>"/>
							</div>
						</div>





	



						<?
							$raiz_site=$_SERVER['DOCUMENT_ROOT'];
								
							$img1=$raiz_site."/imagens/produtos/".$cdproduto.".jpg";
							$img1temppng=$raiz_site."/imagens/produtos/uploads/".$cdproduto.".png";
							$img1tempjpg=$raiz_site."/imagens/produtos/uploads/".$cdproduto.".jpg";
							
							$img2=$raiz_site."/imagens/produtos/".$cdproduto."b.png";
							$img2temppng=$raiz_site."/imagens/produtos/uploads/".$cdproduto."b.png";
							$img2tempjpg=$raiz_site."/imagens/produtos/uploads/".$cdproduto."b.jpg";
							
							$img3=$raiz_site."/imagens/produtos/".$cdproduto."c.png";
							$img3temppng=$raiz_site."/imagens/produtos/uploads/".$cdproduto."c.png";
							$img3tempjpg=$raiz_site."/imagens/produtos/uploads/".$cdproduto."c.jpg";
							
							$img4=$raiz_site."/imagens/produtos/".$cdproduto."d.png";
							$img4temppng=$raiz_site."/imagens/produtos/uploads/".$cdproduto."d.png";
							$img4tempjpg=$raiz_site."/imagens/produtos/uploads/".$cdproduto."d.jpg";
								
							IF (file_exists($img1)){
								$fonte_imagem1="/imagens/produtos/".$cdproduto.".jpg";
							} 
							ELSEIF ($img_a<>""){
								$fonte_imagem1="../imagens/produtos/".$img_a.".png";
							}
							
							ELSEIF (file_exists($img1temppng)){
								$fonte_imagem1="/imagens/produtos/uploads/".$cdproduto.".png";
							}
							
							ELSEIF (file_exists($img1tempjpg)){
								$fonte_imagem1="/imagens/produtos/uploads/".$cdproduto.".jpg";
							}
							
							ELSE {
								$fonte_imagem1="../imagens/produtos/00000.png";
							}	
								
								
							IF (file_exists($img2)){
								$fonte_imagem2="/imagens/produtos/".$cdproduto."b.png";
							} 
							ELSEIF ($img_b<>""){
								$fonte_imagem2="../imagens/produtos/".$img_b.".png";
							}
							
							ELSEIF (file_exists($img2temppng)){
								$fonte_imagem2="/imagens/produtos/uploads/".$cdproduto."b.png";
							}
							
							ELSEIF (file_exists($img2tempjpg)){
								$fonte_imagem2="/imagens/produtos/uploads/".$cdproduto."b.jpg";
							}
							
							ELSE {
								$fonte_imagem2="../imagens/produtos/00000.png";
							}	
								
								
							IF (file_exists($img3)){
								$fonte_imagem3="/imagens/produtos/".$cdproduto."c.png";
							} 
							ELSEIF ($img_c<>""){
								$fonte_imagem3="../imagens/produtos/".$img_c.".png";
							}
							
							ELSEIF (file_exists($img3temppng)){
								$fonte_imagem3="/imagens/produtos/uploads/".$cdproduto."c.png";
							}
							
							ELSEIF (file_exists($img3tempjpg)){
								$fonte_imagem3="/imagens/produtos/uploads/".$cdproduto."c.jpg";
							}
							
							ELSE {
								$fonte_imagem3="../imagens/produtos/00000.png";
							}	
								
								
							IF (file_exists($img4)){
								$fonte_imagem4="/imagens/produtos/".$cdproduto."d.png";
							} 
							ELSEIF ($img_d<>""){
								$fonte_imagem4="../imagens/produtos/".$img_d.".png";
							}
							
							ELSEIF (file_exists($img4temppng)){
								$fonte_imagem4="/imagens/produtos/uploads/".$cdproduto."d.png";
							}
							
							ELSEIF (file_exists($img4tempjpg)){
								$fonte_imagem4="/imagens/produtos/uploads/".$cdproduto."d.jpg";
							}
							
							ELSE {
								$fonte_imagem4="../imagens/produtos/00000.png";
							}	
						?>	

						<div class="row py-1">
							<div class="col-1">
								<img id="pinc_img1" src="<? echo $fonte_imagem1;?>" />
							</div>
							<div class="col-1">
								<img id="pinc_img2" src="<? echo $fonte_imagem2;?>" />
							</div>
							<div class="col-1">
								<img id="pinc_img3" src="<? echo $fonte_imagem3;?>" />
							</div>
							<div class="col-1">
								<img id="pinc_img4" src="<? echo $fonte_imagem4;?>" />
							</div>
						</div>


						<div class="row py-1">
							<div class="col-1">
								<input name="img_a" type="text" id="img_a"  placeholder="Coringa A" maxlength="5" size="6" value="<? echo $img_a; ?>"/>
							</div>
							<div class="col-1">
								<input name="img_b" type="text" id="img_b"  placeholder="Coringa B" maxlength="5" size="6" value="<? echo $img_b; ?>"/>
							</div>
							<div class="col-1">
								<input name="img_c" type="text" id="img_c"  placeholder="Coringa C" maxlength="5" size="6" value="<? echo $img_c; ?>"/>
							</div>
							<div class="col-1">
								<input name="img_d" type="text" id="img_d"  placeholder="Coringa D" maxlength="5" size="6" value="<? echo $img_d; ?>"/>
							</div>
						</div>


						<div class="row py-1">
							<div class="col-1">
								<img id="joker_img" src="../imagens/joker.png" onclick="window.open('joker.php','_blank')" title="Mostrar imagens coringa"/>
							</div>
						</div>


						<div class="row py-1">
							<div class="col-12">
								<b>Embalagem</b>
							</div>
						</div>

						<div class="row py-1">
							<div class="col-1">
								Peso
							</div>
							<div class="col-1">
								<input name="emb_peso" type="text" id="emb_peso"  placeholder="Peso em gramas" maxlength="6"  value="<? echo $emb_peso; ?>" size="6" />
							</div>
							<div class="col-1">
								(gramas)
							</div>
						</div>
	
						<div class="row py-1">
							<div class="col-1">
								Dimensoes
							</div>
							<div class="col-1">
								<input name="emb_comp" type="text" id="emb_comp"  placeholder="C cm" maxlength="4" size="4" value="<? echo $emb_comp; ?>"/>
							</div>
							<div class="col-1">
								<input name="emb_larg" type="text" id="emb_larg"  placeholder="L cm" maxlength="4" size="4"  value="<? echo $emb_larg; ?>"/>
							</div>
							<div class="col-1">
								<input name="emb_alt" type="text" id="emb_alt"  placeholder="A cm" maxlength="4" size="4" value="<? echo $emb_alt; ?>"/>
							</div>
							<div class="col-8">
								Comprimento x Largura x Altura (cm)
							</div>
						</div>







						<div class="row py-1">
							<div class="col-1">
								Pendências
							</div>
							<div class="col-11">
								<input name="pendencias" type="text" id="pendencias"  placeholder="Pendencias" maxlength="40" size="30" value="<? echo $pendencias; ?>"/>
							</div>
						</div>		

					</div> 

					<!-- Camada 2: SEO -->
					<div class="container-fluid text-left SEO-layer active" id="SEO-layer"> 
						<div class="row py-1">
								<div class="col-1">
								SEO
								</div>
						</div>		
						<div class="row py-1">
							<div class="col-1">
								EAN
							</div>
							<div class="col-11">
								<input name="ean" type="text" id="ean"  placeholder="Codigo de barras" maxlength="13"  value="<? echo $ean; ?>"/>
							</div>
						</div>		
						
						<div class="row py-1">
							<div class="col-1">
								URL
							</div>
							<div class="col-11">
								<input name="url" type="text" id="url"  size="80" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> maxlength="256"  value='<? echo $urlProduto; ?>'/>
							</div>
						</div>		
						<div class="row py-1">
							<div class="col-1">
								Title
							</div>
							<div class="col-11">
								<input name="title" type="text" id="title"  size="80" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> maxlength="256"  value='<? echo $titleProduto; ?>'/>					</div>
						</div>		
		
						<div class="row py-1">
							<div class="col-1">
								Descrição simplificada (meta description)
							</div>
							<div class="col-11">
								<textarea name="description" cols="80" rows="6" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> id="description" type="text" /><? echo $descriptionProduto; ?></textarea>
							</div>
						</div>		
	
						<div class="row py-1">
							<div class="col-1">
								Keywords
							</div>
							<div class="col-11">
								<textarea name="keywords" cols="80" rows="6" <?IF(($nivelusuario<5) AND ($modo=="editar")){ECHO "readonly=\“true\”";}?> id="keywords" type="text" /><? echo $keywordsProduto; ?></textarea>
							</div>
						</div>		
						<div class="row py-1">
							<div class="col-1">
								Pedido de Material
							</div>
							<div class="col-11">
								<?
									$queryQuantidadePedidoMaterial="SELECT quantidade FROM pedmaterial WHERE cdproduto='$cdproduto'";
									$resultadoQuantidadePedidoMaterial=mysql_query($queryQuantidadePedidoMaterial, $conexao);
									$quantidadePedidoMaterial=mysql_result($resultadoQuantidadePedidoMaterial,0,0);
									echo"	<table>
												<tr>
													<td><img src='../imagens/add2.png' height='32' width='32' onclick='pedidoMaterial(\"$cdproduto\", 2);' /></td>
													<td><img src='../imagens/add5.png' height='32' width='32' onclick='pedidoMaterial(\"$cdproduto\", 5); '/></td>
													<td><img src='../imagens/borracha.png' height='32' width='32' onclick='pedidoMaterial(\"$cdproduto\", 0);' /></td>
													<td id='idQuantPedidoMaterial' align='right'>$quantidadePedidoMaterial</td>
												</tr>
											</table>";
								?>
							</div>
						</div>		
					</div>

				</form>

		<script type="text/javascript" src="js/ajax2020.js"></script>
		<script>
			function pedidoMaterial(cdproduto, quantidade){
				//let id="idQuantPedidoMaterial"+cdproduto;
				//alert(`${cdproduto} ${quantidade}`);
				let pagina="BDRotinasAjax.php?modo=atualizarPedidoMaterial&cdproduto="+cdproduto+"&quantidade="+quantidade;
				//alert(pagina);
				//console.log("pagina: "+pagina);
				let idQuantPedidoMaterial=document.getElementById("idQuantPedidoMaterial");
				//idQuantPedidoMaterial.innerHTML="<img src='../imagens/carregando.gif' width='32' height='32' />"; 
			
				var async = true;
				xmlhttp.open("GET", pagina, async); // funcionando com um true
				xmlhttp.onreadystatechange=function(){
						if(xmlhttp.readyState==4 && xmlhttp.status==200){
							console.log(xmlhttp.responseText);
							idQuantPedidoMaterial.innerHTML=xmlhttp.responseText;
						}
				}
				xmlhttp.send(null);
			}

			//setInterval(function(){makeRequest();}, 60000);
		</script>

		<!-- Incluido em 25Ago24 -->
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