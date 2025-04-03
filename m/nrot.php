<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Vendas</title>
	</head>

	<body>
		<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					
					<?

						//Prepara conexao ao db
						include("../conectadb.php");
						include("msession.php");
						IF(!$logado){	
							echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
						} 

						// recebe os dados 

						$modo=$_REQUEST["modo"];
						$nrnota=$_REQUEST["nrnota"];
						$nrnota_inteiro=(int)$nrnota;

						// Nova rotina, pesquisa se este numero já foi inserido e cadastra a nota com o proximo numero disponivel para esta loja.
						$query="SELECT nrnota FROM `notas` WHERE cdloja = '".$cdloja."' ORDER BY nrnota DESC LIMIT 0 , 1";
						$resultado=mysql_query($query,$conexao);
						$novo_nrnota_inteiro=mysql_result($resultado,0,0);
						$novo_nrnota_inteiro=$novo_nrnota_inteiro+1;

						// fazer checagem se este número já existe
						$query="SELECT nrnota FROM `notas` WHERE nrnota='".$nrnota_inteiro."' AND cdloja = '".$cdloja."'";
						$resultado = mysql_query($query,$conexao);
						$num_rows = mysql_num_rows($resultado);


						if($num_rows>0 ){ // Numero est� cadastrado no sistema(ser� dado novo numero).
							$nrnota_inteiro=$novo_nrnota_inteiro;
						}

						//$cdloja=$_REQUEST["cdloja"];
						$cdloja= (int)$cdloja;
						$vlnota=$_REQUEST["vlnota"];
						$vlnota_ponto=str_replace(",",".",$vlnota);
						$dtnota=$_REQUEST["dtnota"];
						$dtnota_eua=substr($dtnota,6,4)."-".substr($dtnota,3,2)."-".substr($dtnota,0,2);
						$desconto=$_REQUEST["desconto"];
						if ($desconto==""){
							$desconto=0;
						}
						$desconto_ponto=str_replace(",",".",$desconto);
						$garantia=$_REQUEST["garantia"];
						$idformapagamento=$_REQUEST["idformapagamento"];
						$vlpago=$_REQUEST["vlpago"];
						$idformapagamento2=$_REQUEST["idformapagamento2"];
						$vlpago2=$_REQUEST["vlpago2"];
						$formapagamento=$_REQUEST["formapagamento"]; // estes 2 são usados na rotina nedit.php
						$formapagamento2=$_REQUEST["formapagamento2"];
						$idusuario=$_REQUEST["idusuario"];

						$quant1=$_REQUEST["quant1"];
						$quant2=$_REQUEST["quant2"];
						$quant3=$_REQUEST["quant3"];
						$quant4=$_REQUEST["quant4"];
						$quant5=$_REQUEST["quant5"];
						$quant6=$_REQUEST["quant6"];
						$quant7=$_REQUEST["quant7"];
						$quant8=$_REQUEST["quant8"];
						$quant9=$_REQUEST["quant9"];
						$quant10=$_REQUEST["quant10"];
						$cdproduto1=$_REQUEST["cdproduto1"];
						$cdproduto2=$_REQUEST["cdproduto2"];
						$cdproduto3=$_REQUEST["cdproduto3"];
						$cdproduto4=$_REQUEST["cdproduto4"];
						$cdproduto5=$_REQUEST["cdproduto5"];
						$cdproduto6=$_REQUEST["cdproduto6"];
						$cdproduto7=$_REQUEST["cdproduto7"];
						$cdproduto8=$_REQUEST["cdproduto8"];
						$cdproduto9=$_REQUEST["cdproduto9"];
						$cdproduto10=$_REQUEST["cdproduto10"];
						$vlunitario1=$_REQUEST["vlunitario1"];
						$vlunitario2=$_REQUEST["vlunitario2"];
						$vlunitario3=$_REQUEST["vlunitario3"];
						$vlunitario4=$_REQUEST["vlunitario4"];
						$vlunitario5=$_REQUEST["vlunitario5"];
						$vlunitario6=$_REQUEST["vlunitario6"];
						$vlunitario7=$_REQUEST["vlunitario7"];
						$vlunitario8=$_REQUEST["vlunitario8"];
						$vlunitario9=$_REQUEST["vlunitario9"];
						$vlunitario10=$_REQUEST["vlunitario10"];
						// Incluido em 20Jan22
						$nrSerial=$_REQUEST["nrserial"];
						// Incluido em 10Mai22
						$cdOrigem=$_REQUEST["cdorigem"];
						$vlFrete=$_REQUEST["vlfrete"];
						$dados_cliente=$_REQUEST["dados_cliente"];
						// Incluido em 02Ago22
						$balcao1=$_REQUEST["balcao1"];
						$balcao2=$_REQUEST["balcao2"];
						$balcao3=$_REQUEST["balcao3"];
						$balcao4=$_REQUEST["balcao4"];
						$balcao5=$_REQUEST["balcao5"];
						$balcao6=$_REQUEST["balcao6"];
						$balcao7=$_REQUEST["balcao7"];
						$balcao8=$_REQUEST["balcao8"];
						$balcao9=$_REQUEST["balcao9"];
						$balcao10=$_REQUEST["balcao10"];
						if($balcao1==""){
							$balcao1=$cdOrigem;
						}
						else{
							$balcao1=0;
						}
						if($balcao2==""){
							$balcao2=$cdOrigem;
						}
						else{
							$balcao2=0;
						}
						if($balcao3==""){
							$balcao3=$cdOrigem;
						}
						else{
							$balcao3=0;
						}
						if($balcao4==""){
							$balcao4=$cdOrigem;
						}
						else{
							$balcao4=0;
						}
						if($balcao5==""){
							$balcao5=$cdOrigem;
						}
						else{
							$balcao5=0;
						}
						if($balcao6==""){
							$balcao6=$cdOrigem;
						}
						else{
							$balcao6=0;
						}
						if($balcao7==""){
							$balcao7=$cdOrigem;
						}
						else{
							$balcao7=0;
						}
						if($balcao8==""){
							$balcao8=$cdOrigem;
						}
						else{
							$balcao8=0;
						}
						if($balcao9==""){
							$balcao9=$cdOrigem;
						}
						else{
							$balcao9=0;
						}
						if($balcao10==""){
							$balcao10=$cdOrigem;
						}
						else{
							$balcao10=0;
						}

						//echo "balcao1: $balcao1<br>";
						//echo "balcao2: $balcao2<br>";

						$cdCliente=$_REQUEST["cdcliente"];
						// Incluido em 07Out22 
						$idFormaCancelamento=$_REQUEST["idformacancelamento"];
						$observacoes=$_REQUEST["observacoes"];

						/*
						echo $dtnota_eua."<br>";
						echo $nrnota_inteiro."<br>";
						echo $vlnota_ponto."<br>";
						echo $desconto_ponto."<br>";
						echo $garantia."<br>";
						echo $idformapagamento."<br>";

						echo $quant1."<br>";
						echo $cdproduto1."<br>";
						echo $vlunitario1."<br>";
						*/

						if ($modo=="incluir"){
							
							// Recupera o nome do vendedor
							$query="SELECT nomeusuario FROM usuarios WHERE idusuario='".$idusuario."'";
							$resultado = mysql_query($query,$conexao);
							$nomeusuario=mysql_result($resultado,0,0);

							// Recupera o nome dos produtos para enviar o email de pedido automatico
							
							if ($cdproduto1<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto1."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto1=mysql_result($resultado,0,0);
							}
							if ($cdproduto2<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto2."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto2=mysql_result($resultado,0,0);
							}
							if ($cdproduto3<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto3."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto3=mysql_result($resultado,0,0);
							}
							if ($cdproduto4<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto4."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto4=mysql_result($resultado,0,0);
							}
							if ($cdproduto5<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto5."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto5=mysql_result($resultado,0,0);
							}
							if ($cdproduto6<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto6."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto6=mysql_result($resultado,0,0);
							}
							if ($cdproduto7<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto7."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto7=mysql_result($resultado,0,0);
							}
							if ($cdproduto8<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto8."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto8=mysql_result($resultado,0,0);
							}
							if ($cdproduto9<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto9."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto9=mysql_result($resultado,0,0);
							}
							if ($cdproduto10<>""){
								$query="SELECT nome FROM produtos WHERE cdproduto='".$cdproduto10."'";
								$resultado = mysql_query($query,$conexao);
								$nomeproduto10=mysql_result($resultado,0,0);
							}
							
							// nova rotina, pesquisa se o item esta na lista de produto_autopedido e manda um email para mim informando para pedir automaticamente outro de reposi��o para a loja.


							// Rotinas de email: -----------------------------------------------------------------------------------------
								$flag_envio_email="nao";
								
								$emaildestino="mail.f.grande@gmail.com";

							// D� titulo ao email
								$emailassunto="Pedido automatico de produtos - ".$nomeloja; 
								
							
							// Inicio da montagem do texto da mensagem

								# HTML Version 

							$msg = "
							<html>
							<body><p>"
							// texto aqui //
							
							."Colocar o produto abaixo no pedido de material da loja ".$nomeloja."</p>"."Nome do usuario da nota: ".$nomeusuario."<p>";
							
							
							$query="SELECT cdproduto FROM produtos_autopedido WHERE cdloja = '".$cdloja."' ORDER BY cdproduto ASC";
							
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							
							while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
								$cdproduto_pesquisado=$row[0]; // cd do produto
								if ($cdproduto1==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto1." Quantidade: ".$quant1." Nome do produto: ".$nomeproduto1."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto2==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto2." Quantidade: ".$quant2." Nome do produto: ".$nomeproduto2."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto3==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto3." Quantidade: ".$quant3." Nome do produto: ".$nomeproduto3."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto4==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto4." Quantidade: ".$quant4." Nome do produto: ".$nomeproduto4."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto5==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto5." Quantidade: ".$quant5." Nome do produto: ".$nomeproduto5."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto6==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto6." Quantidade: ".$quant6." Nome do produto: ".$nomeproduto6."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto7==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto7." Quantidade: ".$quant7." Nome do produto: ".$nomeproduto7."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto8==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto8." Quantidade: ".$quant8." Nome do produto: ".$nomeproduto8."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto9==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto9." Quantidade: ".$quant9." Nome do produto: ".$nomeproduto9."<p>";
									$flag_envio_email="sim";
									}

								if ($cdproduto10==$cdproduto_pesquisado)	{
									$msg=$msg."Codigo: ".$cdproduto10." Quantidade: ".$quant10." Nome do produto: ".$nomeproduto10."<p>";
									$flag_envio_email="sim";
									}

							}
								
							$msg=$msg."Este pedido � referente a nota".$nrnota_inteiro."	</body>
							</html>";


							$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers = "From: ".$nome_loja." <".$emaildestino.">\r\n"; // deve ser configurado emaildestino aqui para evitar que filtros spam bloqueiem a mensagem, a linha return-path faz com que o reply siga para quem esta enviando a mensagem. 
							$headers .= "Reply-To: ".$nome_loja." <".$emaildestino.">\r\n";
							// adicionado para enviar copia para Suellen
							$headers .= "Cc: mail.f.grande@gmail.com" . "\r\n"; 

							// confirmar sintaxe deste abaixo
							$headers .= "Return-Path: ".$nome_loja." <".$emaildestino.">\r\n"; 

							$headers .= "Content-Type: text/HTML\r\n"; 
							//mail($email,$msg_assunto,$mensagem,$cabecalho) 

							// envia o email para a filial escolhida
							// a linha de baixo acrescenta texto a msg confeccionada acima, para que o texto de resposta j� fique incluido no email da filial, evitando digita��o desnecessaria.

							if($flag_envio_email=="sim"){
									if (mail($emaildestino, $emailassunto, $msg, $headers))
								{ // se o email pode ser enviado
										echo "Sua nota possui itens relacionados na lista de pedidos autom�tico, sua mensagem foi enviada para ".$emaildestino." com sucesso.<p>";
								//		echo "Voc� retornar� a p�gina inicial em 10 segundos, caso n�o retorne clique <a href='javascript:history.go(-1)'>aqui</a></p>"; 
									}
									else {
										echo "Ocorreu um erro durante o envio do email.";
									}
							}
							// ------------------------------------------------------------------------------------


							
							// Insere a nota no banco de dados
							$hrnota=date('H:i'); // hora atual no formato HH:MM
								
							$query="INSERT INTO notas(idnota, cdloja, nrnota, dtnota, vlnota, desconto, garantia, formapagamento, vlpago, formapagamento2, vlpago2, idvendedor, hrnota, nrserial, cdorigem, vlfrete, cdcliente)
									VALUES (null, $cdloja, $nrnota_inteiro, '$dtnota_eua', $vlnota_ponto, $desconto_ponto, $garantia, '$idformapagamento', '$vlpago', '$idformapagamento2', '$vlpago2', 
									'$idusuario','$hrnota','$nrSerial',$cdOrigem,$vlFrete,'$cdCliente')";
							$resultado = mysql_query($query,$conexao);
							$idnota= mysql_insert_id(); 
							echo "id nota: $idnota<>";
							echo "Query: $query<br>";
							
							// Insere os produtos no banco de dados
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant1, '$cdproduto1', $vlunitario1, $balcao1)";
							$resultado = mysql_query($query,$conexao);
							echo "Query detalhes: $query<br>";
							
							if ($quant2<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant2, '$cdproduto2', $vlunitario2, $balcao2)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant3<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant3, '$cdproduto3', $vlunitario3, $balcao3)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant4<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant4, '$cdproduto4', $vlunitario4, $balcao4)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant5<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant5, '$cdproduto5', $vlunitario5, $balcao5)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant6<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant6, '$cdproduto6', $vlunitario6, $balcao6)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant7<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant7, '$cdproduto7', $vlunitario7, $balcao7)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant8<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant8, '$cdproduto8', $vlunitario8, $balcao8)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant9<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant9, '$cdproduto9', $vlunitario9, $balcao9)";
							$resultado = mysql_query($query,$conexao);
							}

							if ($quant10<>""){
							$query="INSERT INTO notas_detalhes (iddetalhe, idnota, quantidade, cdproduto, vlproduto, flagbalcao) 
							VALUES (null, $idnota, $quant10, '$cdproduto10', $vlunitario10, $balcao10)";
							$resultado = mysql_query($query,$conexao);
							}

							// Atualiza o proximo numero de nota
							$proximo_nrnota=$nrnota_inteiro+1;
							$query="UPDATE parametros SET nrnota=".$proximo_nrnota." WHERE cdloja=".$cdloja;
							$resultado = mysql_query($query,$conexao);

							echo "Nota inserida com sucesso!<br>";
							if($num_rows>0){
								echo "<font color='#FF0000'>Atencao: O numero da nota foi alterado para ".$nrnota_inteiro.", 
								porque alguem utilizou este numero de nota antes de voce finalizar a operacao, por favor verifique antes de imprimir</font>";
							}
						}

						// Modo excluir

						if ($modo=="excluir"){
							
							// Pesquisa se a nota existe
							$query="SELECT nrnota, idnota  
									FROM notas 
									WHERE notas.nrnota=$nrnota AND cdloja=$cdloja";
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							@ini_set("display_errors", 0);
							$nrencontrado=mysql_result($resultado,0,0);
							$idNota=mysql_result($resultado,0,1);
							$nrencontrado=(int)$nrencontrado; // retorna numero sem os zeros
							@ini_set("display_errors", 1);


							// Rotinas de log: Registra a impress�o no LOG do sistema:

							if($nrnota==$nrencontrado){
								$query="SELECT dtnota, vlnota, desconto, garantia, formapagamento 
										FROM notas 
										WHERE nrnota=$nrnota 
										AND cdloja=$cdloja";
								$resultado = mysql_query($query,$conexao);
								$dtnota=mysql_result($resultado,0,0);
								$dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
								//$vlnota=mysql_result($resultado,0,1);
								//$desconto=mysql_result($resultado,0,2);
								//$desconto_formatado=number_format($desconto,2,",","");
								//$garantia=mysql_result($resultado,0,3);
								$idformapagamento=mysql_result($resultado,0,4);
								$querypgto="SELECT formapagamento 
											FROM formas_pagamento 
											WHERE idformapagamento='".$idformapagamento."'";
								$resultadopgto = mysql_query($querypgto,$conexao);
								$formapagamento=mysql_result($resultadopgto,0,0);
								
								$dthoje=date("Y-m-d",strtotime("now"));
								//echo $dthoje;
								$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4, inf5,inf6) 
										VALUES ('null', '$dthoje', '$cdloja','2', '$nrnota', '$nomeusuario', '$dtnota', '$formapagamento','$observacoes','$idFormaCancelamento')";
								// codigo 2 guarda os detalhes principais da nota
									//echo $query;
									$resultado = mysql_query($query,$conexao);
								
								$query="SELECT  notas_detalhes.quantidade, notas_detalhes.cdproduto, notas_detalhes.vlproduto, produtos.nome 
										FROM notas_detalhes, notas, produtos 
										WHERE notas_detalhes.cdproduto=produtos.cdproduto 
										AND notas.nrnota=$nrnota  
										AND notas.idnota=notas_detalhes.idnota 
										AND notas.cdloja='$cdloja' 
										ORDER BY notas_detalhes.iddetalhe";
								$resultado = mysql_query($query,$conexao);
								while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
									$quantidade=$row[0]; // nome da categoria
									$cdproduto=$row[1]; // nome da categoria
									$vlproduto=$row[2]; // nome da categoria
							
								$query2="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) 
											VALUES ('null', '$dthoje', '$cdloja','3', '$nrnota', '$cdproduto', '$quantidade','$vlproduto')"; // codigo 3 � o detalhamento da nota
								
									// echo $query2;
									$resultado2 = mysql_query($query2,$conexao);
								}

								// Excluir a nota no banco de dados
								$query="DELETE FROM notas WHERE notas.nrnota=$nrnota AND cdloja=$cdloja" ;
								$resultado = mysql_query($query,$conexao);
								echo "$query<br>";

								$query="DELETE FROM notas_detalhes WHERE notas_detalhes.idnota=$idNota" ;
								$resultado = mysql_query($query,$conexao);
								echo "$query<br>";

								echo "Nota $nrnota excluida com sucesso<br>";

							} // fim do if (se a nota foi encontrada)

							else {
								echo "Nota não localizada, utilize o número sem zeros na frente (Ex: 4550)";
							}

							// Faz a exclusao da nota (esta rotina foi movida, pois se fosse executada acima, n�o daria para salvar o log.
												



						} // fim do modo=excluir


						if($modo=="alterar"){



							//Recupera informações antigas da nota no BD para salvar no LOG
							$query="SELECT dtnota, vlnota, formapagamento, nrserial, cdorigem, vlfrete, formapagamento2    
									FROM notas 
									WHERE nrnota = '".$nrnota."' AND cdloja='".$cdloja."'";
							//echo $query;
							
							$resultado = mysql_query($query,$conexao);
							$dtnota = mysql_result($resultado,0,0);
							$vlnota = mysql_result($resultado,0,1);
							$formapagamento_antiga=mysql_result($resultado,0,2);
							$nrSerialAntiga = mysql_result($resultado,0,3);
							$cdOrigemAntigo = mysql_result($resultado,0,4);
							$vlFreteAntigo = mysql_result($resultado,0,5);
							$formapagamento2_antiga=mysql_result($resultado,0,6);
							
							// nova rotina, pesquisa se o item esta na lista de produto_autopedido e manda um email para mim informando para pedir automaticamente outro de reposi��o para a loja.

							// Rotinas de email: -----------------------------------------------------------------------------------------
								
								$emaildestino="mail.f.grande@gmail.com";

							// Dá titulo ao email
								$emailassunto="Forma de pagamento alterada - ".$nomeloja; 
								
							
							// Inicio da montagem do texto da mensagem

								# HTML Version 

							//Captura a forma nominal da forma de pagamento nova
							$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento."'";
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							$formapagamento_nominal_nova=mysql_result($resultado,0,0);
							
							//Captura a forma nominal da forma de pagamento antiga
							$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento_antiga."'";
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							$formapagamento_nominal_antiga=mysql_result($resultado,0,0);

							//Captura a forma nominal da forma de pagamento nova
							$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento2."'";
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							$formapagamento_nominal2_nova=mysql_result($resultado,0,0);
							
							//Captura a forma nominal da forma de pagamento antiga
							$query="SELECT formapagamento FROM formas_pagamento WHERE idformapagamento = '".$formapagamento2_antiga."'";
							//echo $query;
							$resultado = mysql_query($query,$conexao);
							$formapagamento_nominal2_antiga=mysql_result($resultado,0,0);

								$msg = "
								<html>
									<body><p>"
									// texto aqui //
									
									."A nota ".$nrnota."</p>"." teve a forma de pagamento 1 alterada de: ".$formapagamento_nominal_antiga." para : ".$formapagamento_nominal_nova." e a forma de pagamento 2 alterada de: ".$formapagamento_nominal2_antiga." para : ".$formapagamento_nominal2_nova."<p>consulte o log <a href='http://www.cabos.etc.br/manutencao/log.php'>aqui</a><p>";
									
									
									$msg=$msg."	</body>
								</html>";


							$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers = "From: ".$nome_loja." <".$emaildestino.">\r\n"; // deve ser configurado emaildestino aqui para evitar que filtros spam bloqueiem a mensagem, a linha return-path faz com que o reply siga para quem esta enviando a mensagem. 
							$headers .= "Reply-To: ".$nome_loja." <".$emaildestino.">\r\n";
							// adicionado para enviar copia para Suellen
							$headers .= "Cc: mail.f.grande@gmail.com" . "\r\n"; 

							// confirmar sintaxe deste abaixo
							$headers .= "Return-Path: ".$nome_loja." <".$emaildestino.">\r\n"; 

							$headers .= "Content-Type: text/HTML\r\n"; 
							//mail($email,$msg_assunto,$mensagem,$cabecalho) 

							// envia o email para a filial escolhida
							// a linha de baixo acrescenta texto a msg confeccionada acima, para que o texto de resposta j� fique incluido no email da filial, evitando digita��o desnecessaria.

								if (mail($emaildestino, $emailassunto, $msg, $headers))
							{ // se o email pode ser enviado
									echo "A alteração da forma de pagamento foi efetuada com sucesso, uma mensagem foi enviada para ".$emaildestino.".<p>";
							//		echo "Voc� retornar� a p�gina inicial em 10 segundos, caso n�o retorne clique <a href='javascript:history.go(-1)'>aqui</a></p>"; 
								}
								else {
									echo "Ocorreu um erro durante o envio do email.";
								}
							// ------------------------------------------------------------------------------------


							
							// Atualiza a forma de pagamento
							// serial de teste da nota 172433 | 2021230186730
							$query="UPDATE notas 
									SET formapagamento=$formapagamento, formapagamento2=$formapagamento2, idvendedor=$idusuario, nrserial='$nrSerial' 
									WHERE nrnota=$nrnota and cdloja=$cdLoja";
							//echo $query;
							$resultado = mysql_query($query,$conexao);

							// Rotinas de log: Registra a impressão no LOG do sistema:

							
							$dthoje=date("Y-m-d",strtotime("now"));
							//echo $dthoje;
							$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) 
									VALUES ('null', '$dthoje', '$cdloja','8', '$nrnota', '$nomeusuario', '$dtnota', '$vlnota')";
								//echo $query;
								$resultado = mysql_query($query,$conexao);
							// Detalhes da altera��o
								$query="INSERT INTO log(idlog, data, loja, codigo, inf1, inf2, inf3, inf4) 
								VALUES ('null', '$dthoje', '$cdloja','9', '$nrnota', '$formapagamento_nominal_antiga', '$formapagamento_nominal_nova', '$formapagamento_nominal2_antiga')";
								//echo $query;
								$resultado = mysql_query($query,$conexao);

							

							
							echo "<p style='padding-top:480px; padding-left:750px'>";
							echo "<a href='../manutencao/index.php'>Voltar</a> ao menu principal (Confira a alteração por favor).";


						} 
						// fim do modo alterar

					?>
						
						<p style="padding-top:300px; padding-left:750px">
						<a href="n.php">Inserir</a> nova nota
						</p>
						
						<p style="padding-top:40px; padding-left:750px">
						<? 	if($cdloja==1) { 
								echo "<a href='n.php?user=14'>Inserir</a> nova nota Cabos 2";
							} 
						?>
						</p>
						
						<br><br>
						<? 
							// echo ("<a href='../manutencao/nota.php?nrnota=".$nrnota_inteiro."'>Imprimir</a> nota"); 
						?>
					</td>
			</tr>
		</table>
		
	
	</body>
</html>
