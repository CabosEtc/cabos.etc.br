<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="manutencao.css">
  <title>BDPCat</title>
</head>

<?

//Prepara conexao ao db
include("../conectadb.php");

//Recebe variaveis
//$loja=$_REQUEST["loja"];
$pag=$_REQUEST["pag"];

IF($pag==""){
  $pag=1;
}

//Inclui o menu
include("mmenu.php");   

$contador_item=0;

//echo "<br>";
//echo "<table width='960' align='center'><tr><td>"; // tabela estrutural externa





$cat=$_REQUEST["cat"];

IF($cat<>""){
  $query_cat="SELECT bd_linkcategoria.link, bd_linkcategoria.descricao FROM `bd_linkcategoria` WHERE `id`='$cat'";

      $resultado_cat = mysql_query($query_cat,$conexao);
      $link=mysql_result($resultado_cat,0,0);
      $descricao=mysql_result($resultado_cat,0,1);
}



$link=$link."&curpage=$pag";
$nextpag=$pag+1;

echo "<table><tr><td><a href='BDCategorias.php'>Categoria</a> ->$descricao</td><td title='Próxima página'><a href='BDPCat.php?cat=$cat&pag=$nextpag'><IMG SRC='../imagens/forward.png'/></a></td></tr></table>";
//echo "<br>Quantidade de produtos listados:: ".."<br>\n";

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

  
	$pagina = Abresite( $link ); //metodo novo, usar se der chabu acima
  $tamanho_pagina=strlen($pagina); // a pagina quando nao abre tem tamanho 133 (por causa da mensagem "Object moved to here.")
  $inicio=strpos($pagina,"<div class=\"row preco detalhe\"");
  $fim=strrpos($pagina,"Atenção!");
	$tamanho=$fim-$inicio;
	$dados_novos=addslashes(substr($pagina,$inicio,$tamanho));
 	$linhas_dados = preg_split("/\n/", substr($pagina,$inicio,$tamanho));

  
  $contador_linhas=0;
  $marcador_inicio_div=0;
  
  echo "<table>";

  // Laco principal *********************************************************************************************
  
	foreach ($linhas_dados as $field) {
    $contador_linhas=$contador_linhas+1;
  
  // nó 0 Procura pela linha que contem um anuncio
  
		if(strpos($field,"row preco detalhe")){ // se a linha contem o marcador do inicio da div daquele produto
      
      //ECHO "<b>Encontrei uma linha ($contador_linhas) de inicio</b><br>";
      $marcador_inicio_div=$contador_linhas;
      $marcador_marca=$marcador_inicio_div+5;
      $marcador_nome_produto=$marcador_inicio_div+21;
      //echo "$marcador_inicio_div - $field<BR>\n";
		}
		// fim do nó 0
		
		// Nó 1 Procura pela marca do produto
    IF($contador_linhas==$marcador_marca){
      $inicio_marca=strpos($field,"<span>")+6;
			$fim_marca=strrpos($field,"</span>");
			$tamanho_marca=$fim_marca-$inicio_marca;
      $marca=utf8_encode(substr($field,$inicio_marca,$tamanho_marca));
      
      
      // Se o campo marca tiver um hiperlink
      if(strpos($field,"<a href=\"http")){
        $inicio_marca=strpos($field,"nofollow\">")+10;
        $fim_marca=strrpos($field,"</a>");
        $tamanho_marca=$fim_marca-$inicio_marca;
        $marca=utf8_encode(substr($field,$inicio_marca,$tamanho_marca));
        
      }
      
      //ECHO "marca->$marca<br>\n";
      
    }
    
    // Procura pelo nome do produto
    IF($contador_linhas==$marcador_nome_produto){
      //echo "Passei pelo nome ->*$field*tamanho-> ".strlen($field)."<br>";
      $produto=trim($field);
      IF (trim($field)=="<div class=\"no-mobile\">"){
        $marcador_nome_produto=$marcador_nome_produto+1;   
        continue;
      }
      //echo "produto->$produto<br>\n";
    }
    
    
  
		// Nó 2 Procura pelo codigo bd do produto Pxxxxxx
		if(strpos($field,"clique aqui e veja mais detalhes")){ // se a linha contem o codigo do produto no site do boadica
      $inicio_codigo_bd=strpos($field,"\"/produtos/")+11;
			$fim_codigo_bd=strrpos($field,"/");
      $tamanho_codigo_bd=$fim_codigo_bd-$inicio_codigo_bd;
      $codigoBd=utf8_encode(substr($field,$inicio_codigo_bd,$tamanho_codigo_bd));
      $posicaoBarra=strrpos($codigoBd,"/");
      $codigoBd=substr($codigoBd,0,$posicaoBarra);
      $tamanho_codigo_bd=STRLEN($codigo_bd);
      $queryId="SELECT id, cdproduto, flag_ativo_boadica, flag_ativo_bdcabos2 FROM `links_boadica` WHERE `link` like '%$codigoBd%'";
      //echo $queryId."<br>";
        $resultado_id = mysql_query($queryId,$conexao);
        IF(mysql_num_rows($resultado_id)>0){
          $id=mysql_result($resultado_id,0,0);
          $cdProduto=mysql_result($resultado_id,0,1);
          $flagAtivoBDCabos=mysql_result($resultado_id,0,2);
          $flagAtivoBDCabos2=mysql_result($resultado_id,0,3);
          $flag_produto_cadastrado="1";

          $camera="<a href='BDPrecos.php?inicio_id=$id&limite=1' target='_blank'><img src='../imagens/camera.png' /></a>";
          $grupo="<a href='BDPrecos.php?cdproduto=$cdProduto' target='_blank'><img src='../imagens/refresh.png' title=\"Listar\nProduto\n$cdProduto\" /></a>";
          $precoCompraTitle="Preço de custo\núltimos 30 dias\nentre\nR$ - R$\nClique para\nvisualizar todos";
          $precoCompra="<a href='elisthistorico.php?cdproduto=$cdProduto' target='_blank'><img src='../imagens/lista.png' title=\"$precoCompraTitle\" /></a>";
          $queryTitle="SELECT nome FROM produtos WHERE cdproduto='$cdProduto'";
          $resultadoTitle=mysql_query($queryTitle, $conexao);
          $titleProduto=mysql_result($resultadoTitle,0,0);
          if($flagAtivoBDCabos){
            $ImgAtivoBDCabos="<img src='../imagens/power_on.gif' />";
          }
          else{
            $ImgAtivoBDCabos="<img src='../imagens/power_off.gif' />";
          }
          if($flagAtivoBDCabos2){
            $ImgAtivoBDCabos2="<img src='../imagens/power_on.gif' />";
            }
            else{
              $ImgAtivoBDCabos2="<img src='../imagens/power_off.gif' />";            
            }
        }
        ELSE{
          $id="Nao localizado";
          //$produto="";
          //$marca="";
          $flag_produto_cadastrado="0";
          $camera="<a href='BDCadastroLink.php?idBD=$codigoBd' target='_blank'><img src='../imagens/camerapb.png' /></a>";
          $grupo="<img src='../imagens/refreshpb.png' />";
          $precoCompra="<img src='../imagens/listapb.png' />";
          $titleProduto="Não cadastrado";
          $ImgAtivoBDCabos="<img src='../imagens/power_off.gif' />";   
          $ImgAtivoBDCabos2="<img src='../imagens/power_off.gif' />";   
        }

      
      $coruja="<a href='https://www.boadica.com.br/produtos/$codigoBd'  TARGET='_blank'><img src='../imagens/coruja.png' title=\"Visitar\nsite\nBoaDica\"/></a>";      
      
      /*
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
				echo "<TR><TD><font color='".$font_color."'>".$nome_loja."</font></TD>";
				// Pesquisa ultima alteração de preços
				$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='".$id_loja."' AND id_produto='".$id."' ORDER BY data DESC";
				$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
				
				if(mysql_num_rows($resultado_ultima_alteracao)>0){
				$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
				} 	
				$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);
				
				
			} 
			else {
			echo "<TR><TD><font color='#000000'>Nao cadastrada - ".$nome_loja."</font></TD><TD>&nbsp</TD>";
			$flag_loja_cadastrada=0;
			}
			*/
		}
		// fim do nó 2
		
		
    
      
		// Nó 3 (preço)
		if(strpos($field,"R$")){ // se a linha contem um preco
		//echo $field;
			$inicio_preco=strpos($field,"R$ ");
			$fim_preco=strrpos($field,"\n");
			//$tamanho_preco=$fim_preco-$inicio_preco;
			$field=str_replace(".","",substr($field,$inicio_preco+3,12));
			//echo $field;
			$preco=floatval(str_replace(",",".",$field));
			//echo $preco;
      $preco=number_format((float)$preco, 2, '.', '');
      
      //echo "Preço-> $preco<br>\n";
      //echo "<td>$preco</td>";
      
      /*
      
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
					$query_precos="INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`) VALUES (NULL, $id_loja, NULL, $id, $preco);";
          echo "Inserido -> Loja: $id_loja Produto: $id Preco: R$ $preco<br>";
					$resultado_precos = mysql_query($query_precos,$conexao);
				}
			}
      
      // Rotina adicionada em 28Maio2018 para permitir guardar um snapshot de todos os precos de determinado produto na data corrente
					$query_precos_snapshot="INSERT INTO links_boadica_detalhes_snapshot (`id`, `id_loja`, `data`, `id_produto`, `preco`) VALUES (NULL, $id_loja, NULL, $id, $preco);";
					//echo $query_precos_snapshot;
          $resultado_precos_snapshot = mysql_query($query_precos_snapshot,$conexao);
          
		IF ($data_ultima_alteracao==$dthoje_eua){
					ECHO "<TD><img src='../imagens/check.gif' width='16' height='16' /></TD>";
				}
				else {echo "<TD>&nbsp</TD>";}
        
    ECHO "<TD>$quant_lojas_predio</TD></TR>"; // Fecha a linha de informacao de cada loja
    
    */
    
    }
    
		// fim do Nó 3 (preco)
		
    
    // Nó 4 (loja)
		if(strpos($field,"Clique para detalhes da loja")){ // se a linha contem um nome
		//echo "linha dados->$field<br>\n";
			$inicio_nome=strpos($field,"data-header");
			$fim_nome=strrpos($field,">");
      $tamanho_nome=$fim_nome-$inicio_nome;
			$nome=TRIM(substr($field,$inicio_nome+13, $tamanho_nome-14));
      
      $queryIdLoja="SELECT id_loja, flag_predio  FROM `lojas_boadica` WHERE `nome` LIKE '%$nome%'";
      $resultadoIdLoja=mysql_query($queryIdLoja, $conexao);
      IF(mysql_num_rows($resultadoIdLoja)>0){
        $idLoja=mysql_result($resultadoIdLoja,0,0);
        $flagPredio=mysql_result($resultadoIdLoja,0,1);
        $flag_loja_cadastrada="1";

        if ($flagPredio==0){
					$font_color="#FFA500";
				}
				if ($flagPredio==1){
					$font_color="#FF0000";
				}
				if ($flagPredio==2){
					$font_color="#0000FF";
				}

      }
      ELSE{
        $id_loja="Nao localizado";
        $flag_loja_cadastrada="0";
        $font_color="#FFFFFF";
      }
      
      
       //$link_incluir_bd="<a href='http://cabos.etc.br/manutencao/precos_bd_cadastro_link.php?marca=$marca&produto=$produto&link=https://www.boadica.com.br/produtos/$codigoBd'  TARGET='_blank'><img src='../imagens/addbd.png'></a>";
   
      
      IF($preco>0){
      //echo "R$ $preco ";
      }
      //echo "[Id Loja: $id_loja / Id Produto: $id]";
      IF($flag_produto_cadastrado=="0"){
        //echo "$link_incluir_bd<br>";
        
        // Apaga os registros com o mesmo codigo_bd que sera incluido
        $query_evitar_duplicidade="DELETE FROM `log` WHERE `inf1`='$codigoBd' AND `codigo`='301'";
        //echo "$query_evitar_duplicidade<br>";
        $resultado_evitar_duplicidade = mysql_query($query_evitar_duplicidade,$conexao);	
        // Insere o novo codigo_bd para providencias
        $query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`, `inf3`, `inf4`, `inf5`) 
        VALUES ('null', CURRENT_TIMESTAMP, '301', '1', '$codigoBd', '$cat', '$pag', 'BDPCat', '$produto')";
        //echo "$query_inserir_log<br>";
        $resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
      }
      //echo "<br><br>";
     
      
      
      
      //echo "CONTADOR-> $contador<BR>";
      
          // Insere no banco de dados, somente se a loja for cadastrada e o preço for diferente da pesquisa anterior
        IF($idLoja<>"Nao localizado" AND $id<>"Nao localizado"){
          $query_pesquisa_preco_antigo="SELECT preco, data FROM links_boadica_detalhes_lojas 
          WHERE id_loja='$idLoja' AND id_produto='$id' ORDER BY data DESC";
          // Na depuracao ativar linha abaixo
          //echo "query_pesquisa_preco_antigo-> $query_pesquisa_preco_antigo<br>";
          $resultado_pesquisa_preco_antigo = mysql_query($query_pesquisa_preco_antigo,$conexao);
          $quantidade_itens=mysql_num_rows($resultado_pesquisa_preco_antigo);
          //echo "quantidade de itens=".$quantidade_itens;
          IF($quantidade_itens>0){
            $preco_anterior=mysql_result($resultado_pesquisa_preco_antigo,0,0);
            $data_preco_anterior=substr(mysql_result($resultado_pesquisa_preco_antigo,0,1),0,10);
          }
          ELSE{
            $preco_anterior=0;
          }
          // Na depuracao ativar a linha abaixo
          //echo "Data_preco_anterior->$data_preco_anterior Data_EUA->$dthoje_eua<br>";
          IF($data_preco_anterior==$dthoje_eua){
            $flag_atualizado_hoje='1';
          }
          ELSE{
            $flag_atualizado_hoje="0";
          }
          // Na depuracao ativar a linha abaixo
          //echo "quant itens->$quantidade_itens flag_loja_cadastrada->$flag_loja_cadastrada flag_produto_cadastrado-> $flag_produto_cadastrado preco_anterior-> $preco_anterior Preco->$preco Flag_atualizado_hoje->$flag_atualizado_hoje<BR>";
          IF (($quantidade_itens==0 OR $flag_atualizado_hoje=="0") AND $flag_loja_cadastrada=="1" 
          AND $flag_produto_cadastrado=="1" AND $preco_anterior<>$preco){		
            //echo "preço anterior=".$preco_anterior;
            //echo "flag_loja_cadastrada".$flag_loja_cadastrada;			
            $query_precos="INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`) 
            VALUES (NULL, $idLoja, CURRENT_TIMESTAMP, $id, $preco);";
            // Na depuracao ativar linha abaixo
            //echo "$query_precos<br>\n";
            // Na depuraçao ativar a linha abaixo
            //echo "quantidade_itens -> $quantidade_itens / flag_atualizado_hoje-> $flag_atualizado_hoje /
            //flag_loja_cadastrada -> $flag_loja_cadastrada / preco_anterior -> $preco_anterior / preco -> $preco<br>";
            echo "<FONT COLOR='blue'>Inserido -> Loja: $idLoja Produto: $id Preco: R$ $preco</FONT><br>";
            $resultado_precos = mysql_query($query_precos,$conexao);
            
            $query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`) 
                                VALUES ('null', CURRENT_TIMESTAMP, '200', '1', '$id', 'BDPCat')";
            //$resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
          }
        
        }
      
      
      
      
        echo "<tr>
        <td>$ImgAtivoBDCabos</td>
        <td><img src='../imagens/leftarrow.gif' /></td>
        <td>$ImgAtivoBDCabos2</td>
        <td><img src='../imagens/leftarrow.gif' /></td>
        
        <td>$camera</td>
        <td>$grupo</td>
        <td>$coruja</td>
        <td><img src='../imagens/info.png' /></td>
        <td>$precoCompra</td>
        <td>$marca</td>
        <td title='$titleProduto'>$produto</td>
        <td>$preco</td>
        <td title='Id Loja - $idLoja'><font color='$font_color'>$nome</font></td></tr>\n";    
    }
    
    
    
		
        
        
        
        
        
        
        
        
				
				
        
    
    
  
    
	} // fim do FOR EACH, onde para de ler os dados da pagina do BD
  
  echo "</table>";	
  // Altera os flags da lojas para indicar se estao ativas ou nao
  
 /* 
	echo "</table>";
	
	

	
	
} // fim do laco principal, depois de varrer todos os ids que foram passados para pesquisa (fetch array da linha proxima a 214)

echo "<br><a href='precos_bd_dia.php' TARGET='_blank'>Link para alteracoes do dia</a><br>";
IF ($flag_busca_por_codigo_produto=="1"){
  IF($flag_erro_abertura<>"1"){
  echo "<br><a href='consolidado.php?ids=$id_acumulado' TARGET='_blank'>Relatorio acumulado</a><br>";
  }
    ELSE
    {
      echo "<br>Houve erro na abertura de pelo menos uma das paginas, impossivel mostrar o relatorio consolidado<br>";
    }
}

*/

?>



</body>
</html>


