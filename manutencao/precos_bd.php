<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="precos_bd.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Precos BD</title>
</head>


<body>

<script src="fieldtoclipboard.js">
// Copia conteudo para area de transferencia
</script>


<?
//Prepara conexao ao db
include("../conectadb.php");


//$dthoje_eua=date("Y-m-d",strtotime("now"));
//$dthoje_br=date("d/m/Y",strtotime("now"));
//$hora=date("H:i:s",strtotime("now"));

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=utf8_encode(mysql_result($resultado,0,0));

// Usado na rotina para copiar o texto automaticamente
$contador_item=0;

//echo "<br>";
//echo "<table width='960' align='center'><tr><td>"; // tabela estrutural externa





$cdproduto=$_REQUEST["cdproduto"];
IF($cdproduto<>""){
  $flag_busca_por_codigo_produto="1";
}
//echo "produto procurado ->".$cdproduto;
$modo=$_REQUEST["modo"];
$inicio_id=$_REQUEST["inicio_id"];
IF ($inicio_id==""){
	$inicio_id=0;
}

$limite=$_REQUEST["limite"];
IF ($limite==""){
  $clausula_limit="";
  $flag_target_blank=" TARGET='_blank'";
}
ELSE {
  $clausula_limit="LIMIT ".$limite;
  $flag_target_blank="";
  
}

$id_pesquisa=$_REQUEST["id_pesquisa"];

$showall=$_REQUEST["showall"];
IF($showall==1){
  $clausula_ativo="flag_ativo IN (0,1,2)";
}
  ELSE{
    $clausula_ativo="flag_ativo='1'";
  }

//if ($_SESSION["nivel"]<3){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
//	}
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link
IF ($modo=='pendentes'){
      IF($id_pesquisa==''){ // Pesquisa por um unico item com o id fornecido
      $query="SELECT links_boadica_pendencias.idproduto, links_boadica.produto, links_boadica.link, links_boadica.cdproduto, links_boadica.flag_ativo_boadica, links_boadica.marca, links_boadica.localizador, links_boadica.box from links_boadica_pendencias,links_boadica WHERE links_boadica_pendencias.idproduto=links_boadica.id AND (links_boadica.flag_ativo_boadica='1' OR flag_ativo_bdcabos2='1')";
      }
      ELSE{
      $query="SELECT links_boadica_pendencias.idproduto, links_boadica.produto, links_boadica.link, links_boadica.cdproduto, links_boadica.flag_ativo_boadica, links_boadica.marca, links_boadica.localizador, links_boadica.box from links_boadica_pendencias,links_boadica WHERE links_boadica_pendencias.idproduto=links_boadica.id AND (links_boadica.flag_ativo_boadica='1' OR flag_ativo_bdcabos2='1') AND links_boadica_pendencias.idproduto=$id_pesquisa";        
      }
}
  ELSE {
        IF ($cdproduto<>""){
      $query="SELECT id, produto, link, cdproduto, flag_ativo_boadica, marca, links_boadica.localizador, links_boadica.box from links_boadica WHERE cdproduto='$cdproduto' AND id>='".$inicio_id."' AND $clausula_ativo ORDER BY id";
    } ELSE {
        IF ($inicio_id==""){
          $query="SELECT id, produto, link, cdproduto, flag_ativo_boadica, marca, links_boadica.localizador, links_boadica.box from links_boadica WHERE flag_ativo='1' ORDER BY id";
        }
          ELSE {
            $query="SELECT id, produto, link, cdproduto, flag_ativo_boadica, marca, links_boadica.localizador, links_boadica.box from links_boadica WHERE (id>='".$inicio_id."' AND id<='".($inicio_id+9)."') AND flag_ativo='1' ORDER BY id $clausula_limit";
          }
        }

  }
  //echo "$query<br>";
  
$resultado = mysql_query($query,$conexao);
$resultado_quant=mysql_num_rows($resultado);


// Inicializa a variavel
$flag_erro_abertura="0";

echo "Relatório de precos do Boadica [".$hora." - ".$dthoje_bra."] - <b>$resultado_quant</b> produtos listados<br><br>";
echo "<div id='relatorio_acumulado' style='display:none'><a href='consolidado.php?ids=$id_acumulado' TARGET='_blank'>Relatorio acumulado</a></div><BR>";
//echo "<br>Quantidade de produtos listados:: ".."<br>";

// incluido em 12nov17
function AbreSite ( $url ) {
			$site_url = $url;
			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $site_url);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			ob_start();
			curl_exec($ch);
			curl_close($ch);
			$file_contents = ob_get_contents();
			ob_end_clean();
			return $file_contents;
		}


$contador_registro = 0;
$id_acumulado="";

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$id=$row[0];
  IF ($id_acumulado==""){
  $id_acumulado=$id;
  }
  ELSE{
    $id_acumulado=$id_acumulado.",$id";
  }
	$produto=utf8_encode($row[1]); 
	$link=$row[2];
	$cdproduto=$row[3];
	$flag_ativo_boadica=$row[4];
  $marca=$row[5];
  $localizador=$row[6];
  $box=$row[7];
  IF($box=="1"){
    $box="[Box]";
  }
  ELSE
  {$box="&nbsp";}
  
  // Inicializa o id das lojas para nao acumular de id para o outro
  $id_loja_todas="";
  
  //IF($localizador<>""){
  //  $localizador=" [".$localizador."]";
  //}
  
	$contador_registro++;
  
  $contador_item=$contador_item+1; // para gerar o sequencial na rotina de copiar automaticamente o nome do produto abaixo
	
	//echo "<h3>".$produto."</h3> ";
	
	// $pagina=file_get_contents($link); ** alterado em 12nov17
	$pagina = Abresite( $link ); //metodo novo, usar se der chabu acima
  $tamanho_pagina=strlen($pagina); // a pagina quando nao abre tem tamanho 133 (por causa da mensagem "Object moved to here.")
  
  //ECHO "Tamanho da pagina de retorno".$tamanho_pagina."bytes<BR>";
  IF ($tamanho_pagina<>133){ // significa que conseguiu abrir e trouxe dados
				$query_apaga_dados_anteriores="DELETE from links_boadica_detalhes_snapshot WHERE id_produto='".$id."'";
				$resultado_apaga_dados_anteriores = mysql_query($query_apaga_dados_anteriores,$conexao);
        // Apaga os registros anteriores para este produto (guarda somente os daquele momento)
				$query_apaga_dados_pendencias="DELETE from links_boadica_pendencias WHERE idproduto='".$id."'";
				$resultado_apaga_dados_pendencias = mysql_query($query_apaga_dados_pendencias,$conexao);
  }
      ELSE {
        $query_evitar_duplicidades="DELETE FROM links_boadica_pendencias WHERE idproduto='".$id."'";
        //echo $query_apaga_dados_anteriores;
				$resultado_evitar_duplicidades = mysql_query($query_evitar_duplicidades,$conexao);
        IF ($flag_ativo_boadica=='1'){ // so vai inserir na pendencia se o produto estiver ativo no Boadica
            $query_incluir_pendencia="INSERT INTO links_boadica_pendencias(`idproduto`,`origem`) VALUES ($id,'precos_bd')";
            //echo $query_apaga_dados_anteriores;
            $resultado_incluir_pendencias = mysql_query($query_incluir_pendencia,$conexao);
        }
      }
	//$inicio=strpos($pagina,"<div class=\"loja\">");
	//echo $inicio;
	//$fim=strrpos($pagina,"<div id=\"div-detalhes\">");
	//echo $fim;
	
	$inicio=strpos($pagina,"<div class=\"col-md-3\">");
	$fim=strrpos($pagina,"<div role=\"tabpanel\" class=\"tab-pane\" id=\"caracteristicas\">");
	
	$tamanho=$fim-$inicio;
	$dados_novos=addslashes(substr($pagina,$inicio,$tamanho)); // põe \antes de ' " \ e null
  
  //echo "$dados_novos.<br>";
	
	$findme="Cabos e etc";
			$flag=strpos($dados_novos,$findme);
			IF ($flag === false) { // Se não achar nosso anuncio
				  IF ($tamanho_pagina==133){
            ECHO "<TABLE><TR><TD width='250'><IMG SRC='../imagens/error.png'> Erro na abertura da pagina</TD><TD><a href='../manutencao/precos_bd.php?inicio_id=$id' TARGET='_blank'><img src='../imagens/forward.png'></a></TD></TR></TABLE>";
            $flag_erro_abertura="1";
            
            BREAK;
          }
				//echo "<font color='red'>**Anuncio Desativado!!!!!**</font><br>";
        IF ($flag === false AND $tamanho_pagina<>133){ // Se não achar nosso anuncio e a pagina tiver retornado algum resultado valido
          $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$id'";
          $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
          $imagem_power="<img src='../imagens/power_off.gif'>";
          // echo $query_flag_ativo;
        }
			} 			ELSE { // Se achar nosso anuncio
				$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='1' WHERE id ='$id'";
				$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
        $imagem_power="<img src='../imagens/power_on.gif'>";
				// echo $query_flag_ativo;
			}
      
      
      // Nova rotina para pesquisar a Cabos 2 Inform&#225;tica (id 451)
      
      $findme_cb2="Cabos 2 Inform&#225;tica";
      $flag_cb2=strpos($dados_novos,$findme_cb2);
      
      IF ($flag_cb2 === false AND $tamanho_pagina<>133){ // Se não achar nosso anuncio e a pagina tiver retornado algum resultado valido
          $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='0' WHERE id ='$id'";
          $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
          $imagem_power_cabos2="<img src='../imagens/power_off.gif'>";
          // echo $query_flag_ativo;
          //echo "Desativado na cabos 2";
        }
			 			ELSE { // Se achar nosso anuncio da Cabos 2
				$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='1' WHERE id ='$id'";
				$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
				$imagem_power_cabos2="<img src='../imagens/power_on.gif'>";
          // echo $query_flag_ativo;
        //echo "Ativo na cabos 2";
			}
      /*
      ECHO "flag".$flag."<BR>";
      echo "flag2".$flag_cb2."<BR>";
      IF ($flag===false){
      $bola=<img src="../imagens/bola_vermelha.gif">;}
      IF ($flag AND $flag_cb2){
      $cor_fonte_produto="<font color='green'>";}
      //IF ($flag!==false OR $flag_cb2!==false){
      //$cor_fonte_produto="<font color='blue'>";}
      */
      
      
      // Pesquisa ultima alteração de preços [ Cabos ]
		$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='19' AND id_produto='".$id."' ORDER BY data DESC";
    //echo "Cabos> $query_ultima_alteracao<br>";
		$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
		
		IF(mysql_num_rows($resultado_ultima_alteracao)>0){
		$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
		}
      ELSE {
        $data_ultima_alteracao="2001-01-01";
      }
    
		$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);
    
    //echo "Cabos> $data_ultima_alteracao/$dthoje_eua<br>";
		
		IF ($data_ultima_alteracao==$dthoje_eua){  
     $flag_ativo_cb="<img src='../imagens/check.gif'>";
			}
      ELSE {
        $flag_ativo_cb="<img src='../imagens/leftarrow.gif'>";   
      }
    
     // Pesquisa ultima alteração de preços [ Cabos 2 ]
		$query_ultima_alteracao_cb2="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='451' AND id_produto='".$id."' ORDER BY data DESC";
    
    //echo "Cabos2> $query_ultima_alteracao_cb2<br>";
		$resultado_ultima_alteracao_cb2 = mysql_query($query_ultima_alteracao_cb2,$conexao);
		
		IF(mysql_num_rows($resultado_ultima_alteracao_cb2)>0){
		$data_ultima_alteracao_cb2=mysql_result($resultado_ultima_alteracao_cb2,0,0);
		}
          ELSE {
        $data_ultima_alteracao_cb2="2001-01-01";
      }

		$data_ultima_alteracao_cb2=substr($data_ultima_alteracao_cb2,0,10);
    
    //echo "Cabos2> $data_ultima_alteracao_cb2/$dthoje_eua<br>";
		
		IF ($data_ultima_alteracao_cb2==$dthoje_eua){  
     $flag_ativo_cb2="<img src='../imagens/check.gif'>";
			}
      ELSE {
        $flag_ativo_cb2="<img src='../imagens/leftarrow.gif'>";   
      }

$query_verifca_links_referencia="SELECT COUNT(flag_ativo) AS total FROM links_boadica WHERE cdproduto=$cdproduto AND flag_ativo='2'";
  $resultado_verifca_links_referencia = mysql_query($query_verifca_links_referencia,$conexao);
  $total_anuncios_referencia=mysql_result($resultado_verifca_links_referencia,0,0);
  //ECHO "TOTAL ANUNCIOS DE REFERENCIA PARA O PRODUTO $cd_produto -> $total_anuncios_referencia<br>";
  IF($total_anuncios_referencia>0){
    $link_spy="<a target='_blank' href='../manutencao/precos_bd.php?cdproduto=$cdproduto&showall=1'><IMG SRC='../imagens/spy.png'/></a>";
  }
  ELSE
      {
        $link_spy="$nbsp";
      }
      
			echo "<table>";
      
      IF($localizador==""){
  $div_produto="<div id='select".$contador_item."' style='float:left'>".$produto."</div>";
  $div_localizador=$localizador;
  $separador="";
  }
  
  IF($localizador<>""){
  $div_produto=$produto;
  $div_localizador="<div id='select".$contador_item."' style='float:right'>".$localizador."</div>";
   $separador=" - ";
  }
      
      echo "<tr><td>$imagem_power</td><td>$flag_ativo_cb</td><td>$imagem_power_cabos2</td><td>$flag_ativo_cb2</td><td>".$div_produto.$separador.$div_localizador."</td><td>[".$marca."]</td><td>$box</td><td>[$id]</td></tr>
      <tr><td colspan='8'>
      <span class='control-copydiv' onClick=\"return fieldtoclipboard.copyfield(event, 'select".$contador_item."')\"><img src='../imagens/copy.png'></span>
		<a href='".$link."' TARGET='_blank'><img src='../imagens/coruja.png'></a>
		<a href='../manutencao/precos_bd.php?inicio_id=$id&limite=1' $flag_target_blank><img src='../imagens/camera.png'></a>
		<a href='precos_bd.php?cdproduto=".$cdproduto."' TARGET='_blank'><img src='../imagens/refresh.png'></a>
		$link_spy
		<a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id&idloja=0&preco=0&flagmeiodia=1'><img src='../imagens/clock.png' title='Esconde o anuncio de todas as lojas ate as 12:00h'></a>
		<a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id&idloja=0'><img src='../imagens/trashred.png' title='Esconde o anuncio de todas as lojas ate o fim do dia (CUIDADO!)'></a>
		<a href='precos_bd.php?inicio_id=".$id."' TARGET='_blank'><img src='../imagens/forward.png'></a>
		</td></tr>";
      echo "</table>";
      
      echo "<table>";
			//echo "<tr><td colspan='3'></td></tr>";	
			//echo "<tr><td colspan='3'><a href='precos_bd.php?cdproduto=".$cdproduto."' TARGET='_blank'>Atualizar somente este produto ".$cdproduto."</a></td></tr>";
			//echo "<tr><td colspan='3'><a href='precos_bd.php?inicio_id=".$id."' TARGET='_blank'>Recomeçar daqui id->".$id."</a></td></tr>";	
	
	
	$linhas_dados = preg_split("/\n/", substr($pagina,$inicio,$tamanho));
	
	$quant_lojas_predio=0; // Inicia o contador de lojas com marcador flag_predio "1' (predio)
  $preco_loja_anterior=0;
  
  
  /*
  Aqui comeca a depuracao das linhas *******************************************************
  */
  
  
	foreach ($linhas_dados as $field) {
    
    //echo "<tr><td colspan='2'>$field</td></tr>";
		// nó 1
		if(strpos($field,"target") AND
       !strpos($field,"usados/recondicionados") AND
       !strpos($field,"usadas/recondicionadas") AND
       !strpos($field,"usados/recondiconados") AND
       !strpos($field,"target=\"_blank\">SSD</a>") AND 
       !strpos($field,"target=+blank\">Usados</a>") AND
       !strpos($field,"target=\"#precisa-logar\">Dar nota</a>") AND
       !strpos($field,"target=\"_blank\">Link para o Fabricante")
       ){ // se a linha contem um nome de loja
			$inicio_nome=strpos($field,"target")+16;
			$fim_nome=strrpos($field,"</a>");
			$tamanho_nome=$fim_nome-$inicio_nome;
			$nome_loja=utf8_encode(substr($field,$inicio_nome,$tamanho_nome));
			// pesquisa se loja está cadastrada
			$query_id="SELECT id_loja, flag_predio from lojas_boadica WHERE nome LIKE '%".$nome_loja."%'";
			$resultado_id = mysql_query($query_id,$conexao);
			
			if(mysql_num_rows($resultado_id)>0){ // se a loja é cadastrada
				$id_loja=mysql_result($resultado_id,0,0);
				
        $flag_predio=mysql_result($resultado_id,0,1);
				$flag_loja_cadastrada=1;
				if ($flag_predio==0){
					$font_color="#FFA500";
				}
				if ($flag_predio==1){
					$font_color="#FF0000";
				}
				if ($flag_predio==2){
					$font_color="#0000FF";
				}
        
        IF($id_loja_todas<>""){
        $id_loja_todas=$id_loja_todas.",".$id_loja;
        }
        ELSE
        {
          $id_loja_todas=$id_loja;
        }
        
        
        
				echo "<TR><TD><font color='".$font_color."'>".$nome_loja."</font></TD>";
				// Pesquisa ultima alteração de preços
				$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='".$id_loja."' AND id_produto='".$id."' ORDER BY data DESC";
				$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
				
				if(mysql_num_rows($resultado_ultima_alteracao)>0){
				$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
				}
        ELSE {
        $data_ultima_alteracao="2001-01-01";
      }
      
				$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);
        
        //echo "Data ultima alteracao> $data_ultima_alteracao<br>";
				
				
			} 
			else {
			echo "<TR><TD><font color='#000000'>Nao cadastrada - ".$nome_loja."</font></TD><TD>&nbsp</TD>";
			$flag_loja_cadastrada=0;
      $query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`) VALUES ('null', CURRENT_TIMESTAMP, '300', '1', '$id', '$nome_loja')";
      $resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
			} 
		}
		// fim do nó 1
		
		
		// Nó 2 (preço)
		if(strpos($field,"R$") AND 
       !strpos($field,"<span>R$")
       ){ // se a linha contem um preco
		//echo $field;
			$inicio_preco=strpos($field,"R$ ");
			$fim_preco=strrpos($field,"\n");
			//$tamanho_preco=$fim_preco-$inicio_preco;
			$field=str_replace(".","",substr($field,$inicio_preco+3,12));
			//echo $field;
			$preco=floatval(str_replace(",",".",$field));
			//echo $preco;
			$preco=number_format((float)$preco, 2, '.', '');
      
      // Rotina para contagem do ranking
      
      IF($preco<>$preco_loja_anterior AND ($flag_predio=="1" OR $flag_predio=="2")){
        $quant_lojas_predio=$quant_lojas_predio+1;
      }
      $preco_loja_anterior=$preco;
      
			echo "<TD>".$preco."</TD>";
			
			//echo $data_ultima_alteracao.$dthoje_eua;
			IF ($flag_loja_cadastrada==1 AND ($data_ultima_alteracao<>$dthoje_eua)){
			//echo "vou cadastradar a loja".$nome_loja."codigo ".$id_loja." com o valor ".$preco;
			// Insere no banco de dados, somente se a loja for cadastrada e o preço for diferente da pesquisa anterior	
				$query_pesquisa_preco_antigo="SELECT preco, data FROM links_boadica_detalhes_lojas WHERE id_loja='$id_loja' AND id_produto='$id' ORDER BY data DESC";
				//echo $query_pesquisa_preco_antigo;
				$resultado_pesquisa_preco_antigo = mysql_query($query_pesquisa_preco_antigo,$conexao);
				$quantidade_itens=mysql_num_rows($resultado_pesquisa_preco_antigo);
				//echo "quantidade de itens=".$quantidade_itens;
				if($quantidade_itens>0){
					$preco_anterior=mysql_result($resultado_pesquisa_preco_antigo,0,0);
					$data_preco_anterior=mysql_result($resultado_pesquisa_preco_antigo,0,1);
					
					//IF ($preco_anterior<>$preco){
					//	echo "  Preco anterior: ".$preco_anterior. " [".$data_preco_anterior."]<br>";
					//}
					//	else {echo "<br>";}
				}
			
				IF (($quantidade_itens==0) OR ($preco_anterior<>$preco)){		
					//echo "preço anterior=".$preco_anterior;
					//echo "flag_loja_cadastrada".$flag_loja_cadastrada;			
					$query_precos="INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`) VALUES (NULL, $id_loja, CURRENT_TIMESTAMP, $id, $preco);";
          //echo "$query_precos<br>";
          echo "Inserido -> Loja: $id_loja Produto: $id Preco: R$ $preco<br>";
					$resultado_precos = mysql_query($query_precos,$conexao) OR DIE(mysql_error());
          //mysql_query($query_insert) OR DIE(mysql_error());
				}
			}
      
      // Rotina adicionada em 28Maio2018 para permitir guardar um snapshot de todos os precos de determinado produto na data corrente
					$query_precos_snapshot="INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`) VALUES (NULL, $id_loja, CURRENT_TIMESTAMP, $id, $preco);";
					//echo $query_precos_snapshot;
          $resultado_precos_snapshot = mysql_query($query_precos_snapshot,$conexao);
          
		IF ($data_ultima_alteracao==$dthoje_eua){
					ECHO "<TD><img src='../imagens/check.gif' width='16' height='16' /></TD>";
				}
				else {echo "<TD>&nbsp</TD>";}
        
        
    // Rotina adicionada em 19Abr20 para mostrar o simbolo hidden.png se o id e a loja estiverem no precos_bd_ocultar
    
    
    // Verifica se o codigo consta da tabela links_bd_ocultar, com data de hoje, com o id e o codigo da loja (Ou loja 0, para ocultar todos).
  $query_verifica_ocultar="SELECT flagmeiodia from links_boadica_ocultar WHERE idproduto='$id' AND data='$dthoje_eua' AND (idloja='$id_loja' OR idloja='0')";
  //echo "Query verifica ocultar-> $query_verifica_ocultar<br>";
  $resultado_verifica_ocultar = mysql_query($query_verifica_ocultar,$conexao);
  $verifica_resultado=mysql_num_rows($resultado_verifica_ocultar);
  if($verifica_resultado>0) {
  $flagmeiodia=mysql_result($resultado_verifica_ocultar,0,0);
  }
  else {
  $flagmeiodia=0;
  }
  //echo "Flag meio dia-> $flagmeiodia<br>";
  //echo 'Quant '.$id_produto.' - '.$verifica_resultado.'<BR>';
  IF($verifica_resultado==0){
   $hidden='&nbsp';
   }
    ELSE {
      IF ($flagmeiodia==1){
        $hidden="<img src='../imagens/hidden12.png' width='16' height='16' title='Esta escondido ate 12h'/>";
        //echo "<TR><TD colspan='16'>Flag $flag_ocultar / ID $id_produto / Loja $id_loja</TD></TR>";
      }
        ELSE {
          $hidden="<img src='../imagens/hidden.png' width='16' height='16' title='Esta escondido ate o final do dia'/>";
        }
    }
    
    
    
    
    
    
    
    
        
    ECHO "<TD>$quant_lojas_predio</TD><TD>$hidden</TD><td><a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id&idloja=$id_loja_todas'><img src='../imagens/trash.png' width='16' height='16' title='Esconde o anuncio da loja $id_loja_todas'></a></td>
    <td><a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id&idloja=$id_loja_todas&preco=0&flagmeiodia=1'><img src='../imagens/clock.png' width='16' height='16' title='Esconde o anuncio da loja $id_loja_todas ate as 12:00h'></a></td></TR>"; // Fecha a linha de informacao de cada loja
    } 
		// fim do Nó 2 (preco)
		
	} // fim do FOR EACH, onde para de ler os dados da pagina do BD
  
  	
  // Altera os flags da lojas para indicar se estao ativas ou nao
  
  
	echo "</table>";
	
	
	
			
		

/*		
	if ($flag_predio=1){
				echo "<font color='#FF0000'>".$nome_loja."</font><br>";
				} else {
					echo "<font color='#FFFF00'>".$nome_loja."</font><br>";
					}
				echo $preco."<br>";		
*/				
		
	
	
	
	/*
	$posicao_inicial_nome=strpos($dados_novos, 'target=\"_blank\">'); // inicio do nome da loja
	$posicao_final_nome=strpos($dados_novos, '</a>'); // fim do nome da loja
	$tamanho_nome_loja=$posicao_final_nome-$posicao_inicial_nome;
	$nome_loja=substr($dados_novos,$posicao_inicial_nome,$tamanho_nome_loja);
	echo $nome_loja;
	*/
	
	
	
	

/*	todo este trecho foi suspenso, verificar se ele realmente não é mais util (a comparação é individual agora, não pelo md5 da pagina)
	
	$md5_novo=md5($dados_novos);

		$query_compara_md5="SELECT md5 from links_boadica_detalhes WHERE links_boadica_detalhes.id=".$id." ORDER BY sequencial DESC";
		echo $query_compara_md5;
		$resultado_md5 = mysql_query($query_compara_md5,$conexao);
		$md5_antigo=mysql_result($resultado_md5,0,0);
		echo $md5_antigo;

			//echo $produto;
			
			echo "<BR>";
		IF ($md5_novo<>$md5_antigo){
			echo "<font color='#3AFF00'> Foi modificado!!!!!</font> <BR>";
			//echo $dados_novos."<BR>";
			
			$query_inserir="INSERT INTO links_boadica_detalhes(`id`, `dados`, `md5`) VALUES ($id, '$dados_novos', '$md5_novo')";
//			$resultado2 = mysql_query($query_inserir,$conexao);
		}
			//Else {
				
			
			//}
				
				
*/

// Registra as pesquisas no log para fins estatisticos
IF($flag_erro_abertura<>"1"){ // Registra no log a ultima pesquisa deste id
  $query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`) VALUES ('null', CURRENT_TIMESTAMP, '200', '1', '$id', 'precos_bd')";
  $resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
}
	
	
} // fim do laco principal, depois de varrer todos os ids que foram passados para pesquisa (fetch array da linha proxima a 214)

//echo "<br><a href='precos_bd_dia.php' TARGET='_blank'>Link para alteracoes do dia</a><br>";
IF ($flag_busca_por_codigo_produto=="1"){
  IF($flag_erro_abertura<>"1"){
  //echo "<br><a href='consolidado.php?ids=$id_acumulado' TARGET='_blank'>Relatorio acumulado</a><br>";
  echo"<script>";
  //echo "document.getElementById('relatorio_acumulado').style.display = 'block';";
  //ECHO "document.getElementById('relatorio_acumulado').innerHTML = '<a href=\'consolidado.php?ids=$id_acumulado\' TARGET=\'_blank\'>Relatorio acumulado</a>';";
  //ECHO "window.open('http://www.cabos.etc.br/manutencao/consolidado.php?ids=$id_acumulado', '$id');";
  echo"</script>";
  }
    ELSE
    {
      //echo "<br>Houve erro na abertura de pelo menos uma das paginas, impossivel mostrar o relatorio consolidado<br>";
      echo"<script>";
      echo "document.getElementById('relatorio_acumulado').style.display = 'block';";
      ECHO "document.getElementById('relatorio_acumulado').innerHTML = '<IMG src='..\imagens\error.png' /> Houve erro na abertura de pelo menos uma das paginas, impossivel mostrar o relatorio consolidado';";
      //ECHO "window.open('http://www.cabos.etc.br/manutencao/consolidado.php?ids=$id_acumulado', '$id');";
      echo"</script>";
    }
    
    
}



           
/*
  // envia email avisando da atualização
    $emailenviar = "mail.f.grande@gmail.com";
    $destino = $emailenviar;
    $assunto = "Boadica - Atualizacao";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Cabos e Etc (Cron Jobs) <contato@cabos.etc.br>';
	IF($modo=='pendentes'){
    $mensagem="Regularizacao dos itens pendentes na pesquisa anterior";
  }
  ELSE {
    $mensagem="Hora da atualizacao: ".$hora." -> Inicio em: ".$inicio_id." (10 registros)";
  }
    $enviaremail = mail($destino, $assunto, $mensagem, $headers);
    if($enviaremail){
    $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
    echo " Arquivo enviado";
    } else {
    echo "ERRO AO ENVIAR E-MAIL!";
    echo "";
    }

*/
?>
<!-- Relatorio consolidado -->
<?

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));

//$ids=$_REQUEST["ids"];
$ids=$id_acumulado;


echo "<h3>Relatorio consolidado</h3><br>";

// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);


$query="SELECT links_boadica_detalhes_snapshot.id_loja, links_boadica_detalhes_snapshot.id_produto, links_boadica_detalhes_snapshot.preco, lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_snapshot.data, lojas_boadica.flag_predio, links_boadica.marca  FROM `links_boadica_detalhes_snapshot`, lojas_boadica, links_boadica WHERE `id_produto` IN ($ids) AND LEFT(data,10)='$dthoje_eua' AND links_boadica_detalhes_snapshot.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_snapshot.id_produto=links_boadica.id ORDER BY preco";

$resultado = mysql_query($query,$conexao);


$contador_item=0;
$contador_item_produtos_atualizaveis=0;

echo "<table>";
echo "<tr><td>Id</td><td>Hora</td><td>Marca</td><td>Produto</td><td>loja</td><td>Valor</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique

while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idloja=$row[0]; 
	$idproduto=$row[1];
  $preco=$row[2];
  $loja=utf8_encode($row[3]); 
	$produto=$row[4]; 
	$hora=substr($row[5],11,8);
  $flag_predio=$row[6];
  if ($flag_predio=="0") {
    $cor_fonte="orange";
} elseif ($flag_predio=="1") {
    $cor_fonte="red";
} else {
    $cor_fonte="blue";
}
  $marca=$row[7];	
		if($flag_erro_abertura<>"1"){
      	echo "<tr><td align='right'><a href='../manutencao/precos_bd.php?inicio_id=$idproduto&limite=1'  TARGET='_blank'>$idproduto</a></td><td>$hora</td><td>$marca</td><td>$produto</td><td><FONT COLOR='$cor_fonte'>$loja</FONT></td><td>$preco</td></tr>";
		}
	} // Fim da linha de exibicao do produto

echo "</table>";

?>
</body>
</html>
