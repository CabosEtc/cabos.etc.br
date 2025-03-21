<script>
	function exibeDivNotasExcluir(){
		divNotasExcluir=document.getElementById('mmenu_notas_excluir');
		divNotasExcluir.style.display='block';
	}

	function exibeDivNotas(){
		var divnotas = document.getElementById("mmenu_notas");
		var divsearch = document.getElementById("mmenu_search");
		var divuser= document.getElementById("mmenu_user");
		
		if  (divnotas.style.display=='none'){
			divnotas.style.display = "block"; 
			divsearch.style.display = "none";
			divuser.style.display = "none";
			//alert("passei aqui");
		} else {
				divnotas.style.display = "none";	
		}
	}

	function exibeDivSearch(){
		var divnotas = document.getElementById("mmenu_notas");
		var divsearch = document.getElementById("mmenu_search");
		var divuser= document.getElementById("mmenu_user");
		
		if  (divsearch.style.display=='none'){ 
			divnotas.style.display = "none"; 
			divsearch.style.display = "block";
			divuser.style.display = "none";
			//alert("passei aqui");
		} else {
				divsearch.style.display = "none";	
		}
	}


	function exibeDivUser(){
		var divnotas = document.getElementById("mmenu_notas");
		var divsearch = document.getElementById("mmenu_search");
		var divuser= document.getElementById("mmenu_user");
		if  (divuser.style.display=='none'){ 
			divnotas.style.display = "none";
			divuser.style.display = "block";
			divsearch.style.display = "none";
		} else {
				divuser.style.display = "none";	
		}
	}
</script>

<div id="mmenu">
	<div class="mmenu_imagens"><img id="mmenu_img1" src="../imagens/coin.png" onclick="exibeDivNotas();"  title="Operações das notas"/></div>
	<div class="mmenu_imagens"><img id="mmenu_img1" src="../imagens/estoqueYellow.png"  onclick="window.open('nrelat.php', '_self')" title="Operações do estoque" /></div>
	<div class="mmenu_imagens"><img id="mmenu_img2" src="../imagens/addverde.png" onclick="window.open('pinc.php', '_self' );" title="Incluir produto" /></div>
	<div class="mmenu_imagens"><img id="mmenu_img4" src="../imagens/searchBlue.png" onclick="exibeDivSearch();" title="Procurar produto"/></div>
	<div class="mmenu_imagens"><img id="mmenu_img5" src="../imagens/site.png"  onclick="window.open('prelat.php', '_self')" title="Operações no Site da Loja" /></div>

	<div class="mmenu_imagens"><img id="mmenu_img8" src="../imagens/whatsapp.png"  onclick="window.open('https://api.whatsapp.com/send?phone=', '_blank')" title="Whatsapp Web" /></div>

	<div class="mmenu_imagens"><img id="mmenu_img6" src="../imagens/tools.png"  onclick="window.open('ptools.php', '_self'); " title="Upload, etc..." /></div>
	<div class="mmenu_imagens"><img id="mmenu_img7" src="../imagens/coruja.png"  onclick="window.open('BD.php', '_self'); " title="Rotinas BD" /></div>
	<div class="mmenu_imagens"><img id="mmenu_img8" src="../imagens/tv.png"  onclick="window.open('iptv.php', '_self'); " title="Iptv" /></div>
	<div class="mmenu_imagens"><img id="mmenu_img9" src="../imagens/boia.png"  onclick="window.open('help.php', '_self'); " title="Ajuda" /></div>

	<?
		// Verifica se tem perguntas no site
		$query="SELECT id FROM perguntas WHERE resposta=''";
		$resultado=mysql_query($query, $conexao);
		$flag_pergunta=mysql_num_rows($resultado);
		IF ($flag_pergunta>0){
			ECHO "<div class=\"mmenu_imagens\"><img id=\"mmenu_img7\" src=\"../imagens/phone.gif\"  onclick=\"window.open('pperg.php', '_self'); \" title=\"Responder pergunta no site\" /></div>";
		}


		//Verifica se rotina autoPBD está habilitada

		$queryVerificaStatusAutoPDB="SELECT autopbd FROM parametros WHERE cdloja=$cdloja";
		$resultadoVerificaStatusAutoPDB=mysql_query($queryVerificaStatusAutoPDB,$conexao);
		$statusAutoPDB=mysql_result($resultadoVerificaStatusAutoPDB,0,0);
		//echo "$queryVerificaStatusAutoPDB<br>";
		if($statusAutoPDB==false){
			echo "<div class=\"mmenu_imagens\"><img id=\"mmenu_img7\" src=\"../imagens/bell.gif\"  onclick=\"window.open('pperg.php', '_self'); \" title=\"Alerta do sistema, verifique\" /></div>";
		}
		else{
			echo "<div class=\"mmenu_imagens\"><img id=\"mmenu_img7\" src=\"../imagens/bellpb.png\"  onclick=\"window.open('pperg.php', '_self'); \" title=\"Tudo sob controle\" /></div>";		
		}


		if($logado){
			echo "<div class='mmenu_imagens'><img id='mmenu_img8' src='../imagens/muser.png'  onclick='window.open(\"mlogin.php?modo=logoff\",\"_self\");' title='Fazer LogOFF' /></div>";
		}
		else {
			echo "<div class='mmenu_imagens'><img id='mmenu_img8' src='../imagens/museroff.png'  onclick='exibeDivUser();' title='Fazer LogON' /></div>";	
		}
	?>

	<div class="mmenu_imagens"><?ECHO "<a href='userPainel.php' target='_blank'>$nomeusuario</a>";?></div>
	</div>

<div id="mmenu_notas">
	<div style='float:left;'><img id="mmenu_img1" src="../imagens/cifrao.png" onclick="window.open('n.php', '_self')" title="Inserir nova nota" /></div>
	<div style='float:left;'><a href="nlist.php?data=<? echo $dthoje_bra; ?>" target="_blank"><img src='../imagens/list.png' title='Listar notas' /></a></div>
	<div style='float:left;'><a href="nResumoDia.php?dtmovimento=<? echo $dthoje_bra; ?>" target="_blank"><img src='../imagens/hoje.png' title='Resumo do movimento de hoje' /></a></div>
	<div style='float:left;'><a href="nResumoMes.php" target="_blank"><img src='../imagens/calendario.png' title='Resumo do movimento do mês' /></a></div>
	<div style='float:left;'><a href="nResumoDiaReposicao.php?dtmovimento=<? echo $dtOntemBrasil; ?>" target="_blank"><img src='../imagens/cestaRefresh.png' title='Lista movimento dia anterior para reposição' /></a></div>
	<?
		//echo "Nivel do usuario: $nivelusuario<br>";
		if($nivelusuario>2){
			echo "<div style='float:left;'><img src='../imagens/x.png' onclick=\"exibeDivNotasExcluir();\" title='Apagar nota' /></div>";
			echo"	<div id='mmenu_notas_excluir' style='float:left; display:none;'>
						<form id='form4' name='form4' method='get' action='nrot.php'>
							<div>
								Excluir nota
								<input name='nrnota' type='text' id='nrnota' size='10' maxlength='6' />
								<input name='modo' type='hidden' id='modo' value='excluir' />
								<input type='submit' name='Ok' id='Ok' value='Ok' />
								ex (22)
							</div>


							<div> 
								Motivo: 
								<select name='idformacancelamento' id='idformacancelamento'>";
									
									$query="SELECT idformacancelamento, formacancelamento 
											FROM formas_cancelamento_nota  
											ORDER BY idformacancelamento";
									$resultado = mysql_query($query,$conexao);
										while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
											$idFormaCancelamento=$row[0]; 
											$formaCancelamento=$row[1]; // descricao
											echo("<option value='$idFormaCancelamento'>$formaCancelamento</option>");
										}
			echo"							
								</select>
							</div>
							<div>
								Obs:
								<input name='observacoes' type='text' id='observacoes' size='34' maxlength='256' />	
							</div>							
						</form>
					</div>";
		}
	?>
	
	
	<!--
	<form action="msearch.php" method="get" target="_blank">
	Procurar produto <input name="busca" type="text"  placeholder="Nome do produto" size='20' maxlength="40"/>
	<input type="image" src="../imagens/gaivota.png"name="enviar" id="enviar" alt="Submit" />
	</form>
	-->
</div>

<div id="mmenu_search">
	<form action="msearch.php" method="get" target="_blank">
		Procurar produto <input name="busca" type="text"  placeholder="Nome do produto" size='20' maxlength="40"/>
		<input type="image" src="../imagens/gaivota.png"name="enviar" id="enviar" alt="Submit" />
	</form>
</div>

<div id="mmenu_user">
	<form action="mlogin.php" method="post">
		Usuario <input name="user" type="text" id="user"  placeholder="Usuario" size='15' maxlength="15"/>
	<input type='hidden' name='modo' value='login'/><input name="password" type="password" id="password"  placeholder="Senha" maxlength="10" size='8'/>
	<input type="image" src="../imagens/gaivota.png"name="enviar" id="enviar" alt="Submit" />
	</form>
</div>