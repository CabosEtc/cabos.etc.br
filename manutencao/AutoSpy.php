<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title>AutoSpy</title>
</head>

<style>


.control-copytextarea{
  cursor: pointer;
  font-weight: bold;
  padding:3px 10px;
  border-radius: 5px 5px 0 0;
  background: darkred;
  color: white;
  display: inline-block;
  box-shadow: 0 0 3px gray;
}


.control-copyinput{
  cursor: pointer;
  font-weight: bold;
  padding:3px 10px;
  border-radius: 8px;
  background: darkred;
  color: white;
  display: inline-block;
  box-shadow: 0 0 3px gray;
  line-height: 25px;
}

fieldset{
	width: 95%;
	background: lightyellow;
	max-width: 600px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}


</style>

<script src="fieldtoclipboard.js"></script>

<body>

<?


//Prepara conexao ao db
include("../conectadb.php");

/*
// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;

}
fclose ($ponteiro);

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dthoje_br=date("d/m/Y",strtotime("now"));
$hora=date("H:i:s",strtotime("now"));

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=utf8_encode(mysql_result($resultado,0,0));
*/
// Usado na rotina para copiar o texto automaticamente

$contador_item=0;


$cdproduto=$_REQUEST["cdproduto"];
IF($cdproduto<>""){
  $flag_busca_por_codigo_produto="1";
}
//echo "produto procurado ->".$cdproduto;
$modo=$_REQUEST["modo"];
//$inicio_id=$_REQUEST["inicio_id"];

$query_ultimo_link_spy="SELECT ultimo_link_spy from parametros WHERE cdloja='1'";
$resultado_ultimo_link_spy = mysql_query($query_ultimo_link_spy,$conexao);
$inicio_id=mysql_result($resultado_ultimo_link_spy,0,0)+1; //+1 adicionado em 25mar20, estava pesquisando 2x o ultimo item...

// flag_ativo='1' AND foi retirado por enquanto
$query_contaID="SELECT id from links_boadica WHERE flag_spy='1' ORDER BY id DESC";
$resultado_contaID = mysql_query($query_contaID,$conexao);
$ultimo_id=mysql_result($resultado_contaID,0,0);
//ECHO $ultimo_id."<br>";

IF($inicio_id>=$ultimo_id){
  $inicio_id=1;
}


//IF ($inicio_id==""){
//	$inicio_id=0;
//}

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

// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link

//  AND flag_ativo='2' foi retirado por enquanto
$query="SELECT id, produto, link, cdproduto, flag_ativo_boadica, marca, links_boadica.localizador 
from links_boadica WHERE id>='$inicio_id' AND flag_spy='1' 
ORDER BY id LIMIT 5";
  
//  echo "$query<br>";
$resultado = mysql_query($query,$conexao);
$resultado_quant=mysql_num_rows($resultado);
echo "Relatório de precos do Boadica [".$hora." - ".$dthoje_br."] - <b>$resultado_quant</b> produtos listados<br><br><br>";
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
  IF($localizador<>""){
    $localizador=" [".$localizador."]";
  }
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
            $query_incluir_pendencia="INSERT INTO links_boadica_pendencias(`idproduto`,`origem`) VALUES ($id,'AutoPBD')";
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
	$dados_novos=addslashes(substr($pagina,$inicio,$tamanho));
  
// Nova rotina para pesquisar a Cabos  (id 19)
	
$findme="Cabos e etc";
$flag=strpos($dados_novos,$findme);
IF ($flag === false) { // Se não achar nosso anuncio
	IF ($tamanho_pagina==133){
	ECHO "<TABLE><TR><TD width='250'><IMG SRC='../imagens/error.png'> Erro na abertura da pagina</TD><TD><a href='../manutencao/precos_bd.php?inicio_id=$id' TARGET='_blank'><img src='../imagens/forward.png'></a></TD></TR></TABLE>";
	$flag_erro_abertura="1";
	ECHO "Ultimo id -> $id<br>";
	$query_ultimo_id="UPDATE parametros SET ultimo_link_spy='$id' WHERE cdloja ='1'";
	$resultado_ultimo_id = mysql_query($query_ultimo_id,$conexao);
	BREAK;
	}
	  
	IF ($flag === false AND $tamanho_pagina<>133){ // Se não achar nosso anuncio e a pagina tiver retornado algum resultado valido
	  $query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_boadica='0' WHERE id ='$id'";
	  $resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	  $imagem_power="<img src='../imagens/power_off.gif'>";
	  // echo $query_flag_ativo;
	}
}
ELSE { // Se achar nosso anuncio
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
}
ELSE { // Se achar nosso anuncio da Cabos 2
	$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdcabos2='1' WHERE id ='$id'";
	$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	$imagem_power_cabos2="<img src='../imagens/power_on.gif'>";
	// echo $query_flag_ativo;
	//echo "Ativo na cabos 2";
}
// Nova rotina para pesquisar a Super Game (id 2)
      
$findme_sg="Super Game";
$flag_sg=strpos($dados_novos,$findme_sg);

IF ($flag_sg === false AND $tamanho_pagina<>133){ // Se não achar nosso anuncio e a pagina tiver retornado algum resultado valido
	$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='0' WHERE id ='$id'";
	$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	$imagem_power_sg="<img src='../imagens/power_off.gif'>";
	// echo $query_flag_ativo;
//echo "Desativado na cabos 2";
}
ELSE { // Se achar nosso anuncio da Cabos 2
	$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg='1' WHERE id ='$id'";
	$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	$imagem_power_sg="<img src='../imagens/power_on.gif'>";
	// echo $query_flag_ativo;
	//echo "Ativo na cabos 2";
}

      
// Nova rotina para pesquisar a Supernova (id 239)

$findme_sg2="Supernova";
$flag_sg2=strpos($dados_novos,$findme_sg2);

IF ($flag_sg2 === false AND $tamanho_pagina<>133){ // Se não achar nosso anuncio e a pagina tiver retornado algum resultado valido
	$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='0' WHERE id ='$id'";
	$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	$imagem_power_sg2="<img src='../imagens/power_off.gif'>";
	// echo $query_flag_ativo;
	//echo "Desativado na cabos 2";
}
ELSE { // Se achar nosso anuncio da Supernova
	$query_flag_ativo_boadica="UPDATE links_boadica SET flag_ativo_bdsg2='1' WHERE id ='$id'";
	$resultado_flag_ativo_boadica = mysql_query($query_flag_ativo_boadica,$conexao);
	$imagem_power_sg2="<img src='../imagens/power_on.gif'>";
	// echo $query_flag_ativo;
	//echo "Ativo na cabos 2";
}

      
      
// Pesquisa ultima alteração de preços [ Cabos ]
$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='19' AND id_produto='".$id."' ORDER BY data DESC";
//echo $query_ultima_alteracao;
$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);

if(mysql_num_rows($resultado_ultima_alteracao)>0){
	$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
}
ELSE {
	$data_ultima_alteracao="2001-01-01";
}

$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);

//echo "$data_ultima_alteracao/$dthoje_eua";

IF ($data_ultima_alteracao==$dthoje_eua){  
	$flag_ativo_cb="<img src='../imagens/check.gif'>";
}
ELSE {
	$flag_ativo_cb="<img src='../imagens/leftarrow.gif'>";   
}
    
// Pesquisa ultima alteração de preços [ Cabos 2 ]
$query_ultima_alteracao_cb2="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='451' AND id_produto='".$id."' ORDER BY data DESC";
//echo $query_ultima_alteracao;
$resultado_ultima_alteracao_cb2 = mysql_query($query_ultima_alteracao_cb2,$conexao);

if(mysql_num_rows($resultado_ultima_alteracao_cb2)>0){
	$data_ultima_alteracao_cb2=mysql_result($resultado_ultima_alteracao_cb2,0,0);
}
ELSE {
	$data_ultima_alteracao_cb2="2001-01-01";
}

$data_ultima_alteracao_cb2=substr($data_ultima_alteracao_cb2,0,10);

//echo "$data_ultima_alteracao/$dthoje_eua";

IF ($data_ultima_alteracao_cb2==$dthoje_eua){  
	$flag_ativo_cb2="<img src='../imagens/check.gif'>";
}
ELSE {
	$flag_ativo_cb2="<img src='../imagens/leftarrow.gif'>";   
}

// Verifica anuncios de referencia flag_ativo=2
$query_verifca_links_referencia="SELECT COUNT(flag_ativo) AS total FROM links_boadica WHERE cdproduto=$cdproduto AND flag_ativo='2'";
$resultado_verifca_links_referencia = mysql_query($query_verifca_links_referencia,$conexao);
$total_anuncios_referencia=mysql_result($resultado_verifca_links_referencia,0,0);
//ECHO "TOTAL ANUNCIOS DE REFERENCIA PARA O PRODUTO $cd_produto -> $total_anuncios_referencia<br>";
IF($total_anuncios_referencia>0){
	$link_spy="<a target='_blank' href='../manutencao/precos_bd.php?cdproduto=$cdproduto&showall=1'><IMG SRC='../imagens/spy.png'/></a>";
}
ELSE{
	$link_spy="$nbsp";
}      
      
echo "<table>";
      
echo "<tr><td>$imagem_power</td><td>$flag_ativo_cb</td><td>$imagem_power_cabos2</td><td>$flag_ativo_cb2</td><td><div id='select".$contador_item."'  style='float:left'>".$produto."</div>".$localizador."</td><td>[".$marca."]</td><td>[$id]</td><td><span class='control-copydiv' onClick=\"return fieldtoclipboard.copyfield(event, 'select".$contador_item."')\"><img src='../imagens/copy.png'></span>
</td><td><a href='".$link."' TARGET='_blank'><img src='../imagens/coruja.png'>
</a></td><td><a href='../manutencao/precos_bd.php?inicio_id=$id&limite=1' $flag_target_blank><img src='../imagens/camera.png'>
</a></td><td><a href='precos_bd.php?cdproduto=".$cdproduto."' TARGET='_blank'><img src='../imagens/refresh.png'>
</a></td><td>$link_spy</td><td><a href='precos_bd.php?inicio_id=".$id."' TARGET='_blank'><img src='../imagens/forward.png'>
</a></td></tr>";
echo "</table>";
      
echo "<table>";
	
$linhas_dados = preg_split("/\n/", substr($pagina,$inicio,$tamanho));

$quant_lojas_predio=0; // Inicia o contador de lojas com marcador flag_predio "1' (predio)
$preco_loja_anterior=0;
foreach ($linhas_dados as $field) {		
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

IF(mysql_num_rows($resultado_id)>0){ // se a loja é cadastrada
	$id_loja=mysql_result($resultado_id,0,0);

	$flag_predio=mysql_result($resultado_id,0,1);
	$flag_loja_cadastrada=1;
	if ($flag_predio==0){
	$font_color="#FFA500";
	}
	if ($flag_predio==1){
	$font_color="#FF0000";
	}
	IF ($flag_predio==2){
	$font_color="#0000FF";
	}
	echo "<TR><TD title='Loja: $id_loja'><font color='".$font_color."'>".$nome_loja."</font></TD>";
	// Pesquisa ultima alteração de preços
	$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='".$id_loja."' AND id_produto='".$id."' ORDER BY data DESC";
$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);

	IF(mysql_num_rows($resultado_ultima_alteracao)>0){
		$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
	}
	ELSE {
	$data_ultima_alteracao="2001-01-01";
	}
	$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);
} 
ELSE { // se a loja NAO é cadastrada
	echo "<TR><TD><font color='#000000'>Nao cadastrada - ".$nome_loja."</font></TD><TD>&nbsp</TD>";
	$flag_loja_cadastrada=0;
} 
		}
// fim do nó 1
		
		
		// Nó 2 (preço)
		if(strpos($field,"R$") AND 
       !strpos($field,"<span>R$")){ // se a linha contem um preco
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
					$query_precos="INSERT INTO links_boadica_detalhes_lojas (`id`, `id_loja`, `data`, `id_produto`, `preco`,`origem`) 
									VALUES (NULL, $id_loja, CURRENT_TIMESTAMP, $id, $preco, 'AutoSpy');";
          echo "Inserido -> Loja: $id_loja Produto: $id Preco: R$ $preco<br>";
					$resultado_precos = mysql_query($query_precos,$conexao);
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
        
    ECHO "<TD>$quant_lojas_predio</TD></TR>"; // Fecha a linha de informacao de cada loja
    } 
		// fim do Nó 2 (preco)
		
	} 
// fim do FOR EACH, onde para de ler os dados da pagina do BD, comecou perto da linha 405
  
  	
  // Altera os flags da lojas para indicar se estao ativas ou nao
  
  
	echo "</table>";
	
	

	
$query_inserir_log="INSERT INTO log(`idlog`, `data`,  `codigo`, `loja`, `inf1`, `inf2`) VALUES ('null', CURRENT_TIMESTAMP, '200', '1', '$id', 'AutoSpy')";
//$resultado_inserir_log = mysql_query($query_inserir_log,$conexao);	
	
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

            ECHO "Ultimo id -> $id<br>";
            $query_ultimo_id="UPDATE parametros SET ultimo_link_spy='$id' WHERE cdloja ='1'";
            $resultado_ultimo_id = mysql_query($query_ultimo_id,$conexao);
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




</body>
</html>
