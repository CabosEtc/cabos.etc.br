<?
//Prepara conexao ao db
$raiz_site=$_SERVER['DOCUMENT_ROOT'];
include("$raiz_site/conectadb.php");

// Recebe variaveis
$q=$_REQUEST["q"];
$modo=$_REQUEST["modo"];
$cdprodutobd=$_REQUEST["cdprodutobd"];
//$cdprodutobd="p127217"; // p81210
// LL', '$marca', '$produto', '$cdproduto', '$link','$flag_ativo','1','1','','$localizador')";
$marca=$_REQUEST["marca"];
$produto=$_REQUEST["produto"];
$cdproduto=$_REQUEST["cdproduto"];
$link=$_REQUEST["link"];
$flag_ativo=$_REQUEST["flag_ativo"];
$localizador=$_REQUEST["localizador"];

// Funções
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

if($modo=="procurar") {
	$query="select links_boadica.link, links_boadica.cdproduto, produtos.nome from links_boadica, produtos 
	where links_boadica.cdproduto=produtos.cdproduto AND links_boadica.link like '%$q%' ORDER BY cdproduto limit 5";
	$resultado=mysql_query($query, $conexao);
	$quantidade=mysql_num_rows($resultado);
	$ret="";
	
	if($quantidade>0) {
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$link=$row[0];
			$cdproduto=$row[1];
			$nome=$row[2];
			$ret=$ret."<div onclick=\"alert('');\">$cdproduto - $nome - $link</div>"; 
		}	
	}
	else {
	$ret="Não localizado";
	}	
}


if ($modo=="capturar"){
	$link="https://www.boadica.com.br/produtos/".$cdprodutobd;

	$pagina = Abresite( $link ); //metodo novo, usar se der chabu acima
	$tamanho_pagina=strlen($pagina); // a pagina quando nao abre tem tamanho 133 (por causa da mensagem "Object moved to here.")
  
  //ECHO "Tamanho da pagina de retorno".$tamanho_pagina."bytes<BR>";
  IF ($tamanho_pagina<>133){ // significa que conseguiu abrir e trouxe dados
  }
      ELSE {
      }
$inicio=strpos($pagina,"<div class=\"col-md-3\">");
	$fim=strrpos($pagina,"<div role=\"tabpanel\" class=\"tab-pane\" id=\"caracteristicas\">");
	
	$tamanho=$fim-$inicio;
	$dados_novos=addslashes(substr($pagina,$inicio,$tamanho));
  
  //echo "$dados_novos.<br>";
  
  $linhas_dados = preg_split("/\n/", substr($pagina,$inicio,$tamanho));
		
		

/*
  Aqui comeca a depuracao das linhas *******************************************************
  */
  
  $flagacheimarcanome=false;
	foreach ($linhas_dados as $field) {
    if($flagacheimarcanome){// setado na passagem anterior, logo esta tem o nome
		$marca_modelo=trim(utf8_encode($field)); // tira espaços e resolve problemas com acentos.
		//echo "marca_modelo-> $marca_modelo<br>";
		$tamanhomarca_modelo=strlen($marca_modelo);
		//echo "tamanho_marca_modelo-> $tamanhomarca_modelo<br>";
		$posicaobarra=strpos($marca_modelo,"/");
		if($posicaobarra==1) {// o produto é um N/D
		//echo "eh um N/D!<br>";
		$marca_modelo_temp=substr($marca_modelo, $posicaobarra+1,$tamanhomarca_modelo-2); // isto é para achar a segunda barra
		//echo "marca_modelo_temp-> $marca_modelo_temp<br>";
		$posicaobarra=strpos($marca_modelo_temp,"/")+2;
			}
		$tamanho_marca=$posicaobarra-1;
		$tamanho_modelo=$tamanhomarca_modelo-$posicaobarra;
		$marca=trim(substr($marca_modelo, 0, $tamanho_marca));
	
		$modelo=trim(substr($marca_modelo, $posicaobarra+1, $tamanho_modelo));
		//echo "posicaobarra-> $posicaobarra<br>";
		//echo "marca-> $marca / tamanho marca -> $tamanho_marca<br>";
		//echo "modelo-> $modelo / tamanho modelo-> $tamanho_modelo<br>";
		//echo "barra-> $posicaobarra<br>";
		$flagacheimarcanome=false;
    	//echo "$marca_nome";
    }
		// nó 1
		if(strpos($field,"<div class=\"nome\">") AND
       !strpos($field,"usados/recondicionados") AND
       !strpos($field,"usadas/recondicionadas") AND
       !strpos($field,"usados/recondiconados") AND
       !strpos($field,"target=\"_blank\">SSD</a>") AND 
       !strpos($field,"target=+blank\">Usados</a>") AND
       !strpos($field,"target=\"#precisa-logar\">Dar nota</a>") AND
       !strpos($field,"target=\"_blank\">Link para o Fabricante")
       ){ // se a linha contem um nome de loja
			$flagacheimarcanome=true;
			
		}
		// fim do nó 1
		$ret="{\"marca\":\"$marca\",\"modelo\":\"$modelo\"}";
	} // fim do for each
} // fim do modo capturar

IF($modo=="cadastrar"){
     $query_incluir_link="INSERT INTO links_boadica(`id`, `marca`,`produto`,`cdproduto`,`link`,`flag_ativo`,`flag_ativo_boadica`,
     `flag_ativo_bdcabos2`,`descricao`, `localizador`) 
     VALUES ('NULL', '$marca', '$produto', '$cdproduto', '$link','$flag_ativo','1','1','','$localizador')";
     $resultado_incluir_link = mysql_query($query_incluir_link,$conexao);
     //echo $query_incluir_link;
  }
























echo $ret;
?>