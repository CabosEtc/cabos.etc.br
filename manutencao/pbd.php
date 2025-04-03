<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
<title>PBD</title>


</head>

<style>

/* Demos styles. Remove if desired */

/* demo #1 textarea */

.control-copytextarea{
  cursor: pointer;
}

/* demo #2 input text with control */

#select2{
  line-height: 25px;
  font-size: 105%;
	width: 95%;
	max-width: 500px;
  margin: 0;
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

/* demo #3 input text only */

fieldset{
	width: 95%;
	background: lightyellow;
	max-width: 600px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

#select3{
  font-size: 105%;
  margin: 0;
	width: 90%;
	max-width: 500px;
}

/* demo #4 regular div */

#select4{
	width: 200px;
	padding: 5px;
}

.control-copydiv{
  cursor: pointer;
}

</style>

<body onload='timedCount()'>




<script src="fieldtoclipboard.js">

/***********************************************
* Select (and copy) Form Element Script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Add this script to the very END of your page, right above the </body> tag if possible
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>


<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
include("../conectadb.php");

// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
}
fclose ($ponteiro);



$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));

$modo=$_REQUEST["modo"];
IF($modo==""){ $modo="produto";}

$atualizavel=$_REQUEST["atualizavel"];
IF($atualizavel==""){$atualizavel="1";}

$data=$_REQUEST["data"];
IF($data==""){$data=$dtpesquisa;}
$texto_data="Data: ".$data.", ";

$only_actives=$_REQUEST["only_actives"];
IF($only_actives==""){$only_actives="1";}



IF($only_actives=="0"){
  $clausula_query_only_actives="AND links_boadica.flag_ativo='0' ";
  }
   ELSE {
    $clausula_query_only_actives="AND links_boadica.flag_ativo='1' ";
   }

$filtro_loja=$_REQUEST["filtro_loja"];

IF ($filtro_loja==""){
$clausula_filtro_loja=" AND lojas_boadica.nome LIKE '%%'";
}
ELSE {
$clausula_filtro_loja=" AND lojas_boadica.nome LIKE '%$filtro_loja%'";  
}

$only_losing=$_REQUEST["only_losing"];
IF($only_losing==""){$only_losing="1";}



echo "<br>";
//echo "<table width='960' align='center'><tr><td>"; // tabela estrutural externa




// Provisorio

$clausula_query_order_by="ORDER BY links_boadica.produto, links_boadica.id, links_boadica_detalhes_lojas.data DESC";



/*



IF($modo=='hora'){
  ECHO "Para ordenar por Produto, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=produto&atualizavel=".$atualizavel."&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";
  $texto_modo="Listado por hora, ";
  $clausula_query_order_by="ORDER BY links_boadica_detalhes_lojas.data DESC";
}
  ELSE{
    ECHO "Para ordenar por Hora, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=hora&atualizavel=".$atualizavel."&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";    
    $texto_modo="Listado por produto, ";
    $clausula_query_order_by="ORDER BY links_boadica.produto, links_boadica.id, links_boadica_detalhes_lojas.data DESC";
  }
  
IF($atualizavel=='0'){
  ECHO "Para exibir somente atualizaveis, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";
  $texto_atualizavel="todos os produtos atualizaveis ou nao no dia, ";
}
  ELSE {
    ECHO "Para exibir todos (atualizaveis ou nao), clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=0&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";
  $texto_atualizavel="somente produtos atualizaveis no dia, ";
  }
  
IF($only_actives=='0'){
  ECHO "Para exibir somente Ativos para pesquisa no BD, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=1&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";
  $texto_ativo_bd="produtos ativos ou nao para pesquisa no Boa Dica";
}
  ELSE {
    ECHO "Para exibir todos (ativos ou nao  para pesquisa no BD), clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=".$atualizavel."&data=".$data."&only_actives=0&filtro_loja=".$filtro_loja."&only_losing=".$only_losing."'>Aqui</a><BR>";
    $texto_ativo_bd="somente produtos ativos para pesquisa no Boa Dica";  }
  
IF ($filtro_loja<>""){
  ECHO "Para voltar a exibir todas as lojas, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=".$atualizavel."&data=".$data."&only_actives=".$only_actives."&filtro_loja=&only_losing=".$only_losing."'>Aqui</a><BR>";
    $texto_filtro_loja=", somente produtos da loja $filtro_loja";
    $imagem_cadeado="../imagens/cadeado_aberto.png";
}
ELSE {
  $imagem_cadeado="../imagens/cadeado_fechado.gif";
}

IF($only_losing==1){
  ECHO "Para exibir todos os itens que estamos perdendo ou empatando para concorrencia, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=".$atualizavel."&data=".$data."&only_actives=$only_actives&filtro_loja=".$filtro_loja."&only_losing=0'>Aqui</a><BR>";  
  $texto_only_losing=", somente produtos que estamos acima da concorrencia";}
ELSE {
  ECHO "Para exibir somente itens que estamos perdendo para concorrencia, clique <a href='http://www.cabos.etc.br/manutencao/pbd.php?modo=".$modo."&atualizavel=".$atualizavel."&data=".$data."&only_actives=$only_actives&filtro_loja=".$filtro_loja."&only_losing=1'>Aqui</a><BR>";
  $texto_only_losing=", produtos que estamos acima ou empatados com a concorrencia";}
  
  ECHO "Clique <a target='_blank' href='../manutencao/precos_bd_rotinas.php?modo=zerar_ocultar_link'>Aqui</a> para resetar o \"Ocultar id\" e voltar a visualiza-los";
  
  
  
  
  */

echo "<h3>Relatório de alterações de precos do Boadica ($texto_data $texto_modo $texto_atualizavel $texto_ativo_bd $texto_filtro_loja $texto_only_losing)</h3><br>";





//if ($_SESSION["nivel"]<3){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/mensagem.php?cdmensagem=1'>";
//	}
// permite que pagina externas sejam lidas
ini_set('allow_url_fopen', 1);

// seleciona os produtos no banco de dados links_boadica

// Escreve todas as categorias no inicio da pagina com link


/*

IF ($modo=="hora"){
$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca, links_boadica.id, links_boadica.flag_ativo_boadica FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data ) = $data $clausula_query_only_actives  ORDER BY links_boadica_detalhes_lojas.data DESC";
}
ELSE {
$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca, links_boadica.id, links_boadica.flag_ativo_boadica FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data ) = $data $clausula_query_only_actives ORDER BY links_boadica.produto, links_boadica_detalhes_lojas.data DESC";}

*/

$query="SELECT lojas_boadica.nome, links_boadica.produto, links_boadica_detalhes_lojas.preco, links_boadica_detalhes_lojas.data, links_boadica.link, links_boadica_detalhes_lojas.id_produto, lojas_boadica.flag_predio, links_boadica.cdproduto, links_boadica.flag_ativo, links_boadica.marca, links_boadica.id, links_boadica.flag_ativo_boadica, links_boadica_detalhes_lojas.id_loja, links_boadica.flag_ativo_bdcabos2, links_boadica.localizador FROM links_boadica_detalhes_lojas, lojas_boadica, links_boadica
WHERE links_boadica_detalhes_lojas.id_loja=lojas_boadica.id_loja AND links_boadica_detalhes_lojas.id_produto=links_boadica.id AND DATE(
links_boadica_detalhes_lojas.data )='$data' $clausula_filtro_loja $clausula_query_only_actives $clausula_query_order_by";

$resultado = mysql_query($query,$conexao);



//echo $query."<BR><BR>";

$contador_item=0;
$contador_item_produtos_atualizaveis=0;

echo"Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima<BR><BR><BR>";


echo "<table>";
echo "<tr><td>Hora</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>Loja</td><td>&nbsp</td><td witdh='5'>Id</td><td>Marca</td><td>Produto/Localizador</td><td>&nbsp</td><td>Rank</td><td>Loja$</td><td>Cabo$</td><td colspan='3' align='center' title='Ativo BD, Status vitoria, Editavel'>Flags</td><td>Cabo$2</td><td colspan='3' align='center' title='Ativo BD, Status vitoria, Editavel'>Flags</td><td align='center'>BD</td><td align='center'>Grupo</td><td align='right'>ID</td><td>Spy</td></tr>";

//Incluida em 03Ago19 para permitir ocultar todas as lojas com um unico clique

$id_loja_todas="0";
$ultimo_id_produto="0";


while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
	$loja=utf8_encode($row[0]); 
	$produto=$row[1]; 
	$preco=$row[2];
	$hora=substr($row[3],11,8);
	$link=$row[4];
	$id_produto=$row[5];
  //ECHO "ID: $id_produto<BR>";
  
  
  
  
  
	$flag_predio=$row[6];
	$cd_produto=$row[7];
	$flag_ativo=$row[8];
	$marca=$row[9];
	$id_geral_produto=$row[10];
  $flag_ativo_boadica=$row[11];
  $id_loja=$row[12];
  $flag_ativo_bdcabos2=$row[13];
  $localizador=$row[14];
  //IF ($localizador<>""){
   // $localizador="[".$localizador."]";
  //}
  
  
  $query_verifca_links_referencia="SELECT COUNT(flag_ativo) AS total FROM links_boadica WHERE cdproduto=$cd_produto AND flag_ativo='2'";
  $resultado_verifca_links_referencia = mysql_query($query_verifca_links_referencia,$conexao);
  $total_anuncios_referencia=mysql_result($resultado_verifca_links_referencia,0,0);
  //ECHO "TOTAL ANUNCIOS DE REFERENCIA PARA O PRODUTO $cd_produto -> $total_anuncios_referencia<br>";
  IF($total_anuncios_referencia>0){
    $link_spy="<a target='_blank' href='../manutencao/precos_bd.php?cdproduto=$cd_produto&showall=1'><IMG SRC='../imagens/spy.png'/></a>";
  }
  ELSE
      {
        $link_spy="$nbsp";
      }
  
  
  $query_linkgrupoBD="SELECT linkgrupoBD
FROM bd_linkgrupo
WHERE cdproduto=".$cd_produto."";
//echo $query2;
$resultado_linkgrupoBD = mysql_query($query_linkgrupoBD,$conexao);
$linkgrupoBD=mysql_result($resultado_linkgrupoBD,0,0);
	
	$query2="SELECT links_boadica_detalhes_lojas.preco
FROM links_boadica_detalhes_lojas
WHERE links_boadica_detalhes_lojas.id_loja=19 AND links_boadica_detalhes_lojas.id_produto=".$id_produto." ORDER BY links_boadica_detalhes_lojas.data DESC";
//echo $query2;
$resultado2 = mysql_query($query2,$conexao);
if(mysql_num_rows($resultado2)>0){
$preco_cabos=mysql_result($resultado2,0,0);
}	else {$preco_cabos=0;}


	$query_preco_cabos2="SELECT links_boadica_detalhes_lojas.preco
FROM links_boadica_detalhes_lojas
WHERE links_boadica_detalhes_lojas.id_loja=451 AND links_boadica_detalhes_lojas.id_produto=".$id_produto." ORDER BY links_boadica_detalhes_lojas.data DESC";
//echo $query2;
$resultado_preco_cabos2 = mysql_query($query_preco_cabos2,$conexao);
if(mysql_num_rows($resultado_preco_cabos2)>0){
$preco_cabos2=mysql_result($resultado_preco_cabos2,0,0);
}	else {$preco_cabos2=0;}




	IF($flag_predio==0){
		$cor="#FFA500";}
	IF($flag_predio==1){
		$cor="#FF0000";}
	IF($flag_predio==2){
		$cor="#0000FF";}
    
    // Inicio de exibicao da linha de detalhe
    
    		// Pesquisa ultima alteração de preços [ Cabos ]
		$query_ultima_alteracao="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='19' AND id_produto='".$id_produto."' ORDER BY data DESC";
		$resultado_ultima_alteracao = mysql_query($query_ultima_alteracao,$conexao);
		
		if(mysql_num_rows($resultado_ultima_alteracao)>0){
		$data_ultima_alteracao=mysql_result($resultado_ultima_alteracao,0,0);
		} 	
		$data_ultima_alteracao=substr($data_ultima_alteracao,0,10);
		
		IF ($data_ultima_alteracao==$dthoje_eua){
			$flag_atualizado_hoje="1";
			}
				ELSE {
					$flag_atualizado_hoje="0";					
				}
        
    IF ($flag_atualizado_hoje=="0"){ 
			$tipo_bolinha="edit.gif";
		}
		IF ($flag_atualizado_hoje=="0" AND ($preco<$preco_cabos) AND $flag_predio==1 AND $flag_ativo=="1"){ 
			$tipo_bolinha="leftarrow.gif";
      // Incluido em 14Ago18. Poe o produto em evidencia na lista de pendentes, faz com que seja atualizado de 15 em 15 minutos
      $query_evitar_duplicidades="DELETE FROM links_boadica_pendencias WHERE idproduto='".$id_geral_produto."'";
      $resultado_evitar_duplicidades = mysql_query($query_evitar_duplicidades,$conexao);
      $query_incluir_pendencia="INSERT INTO links_boadica_pendencias(`idproduto`,`origem`) VALUES ($id_geral_produto,'pbd_cb1')";
      $resultado_incluir_pendencias = mysql_query($query_incluir_pendencia,$conexao);
		}
    IF ($flag_atualizado_hoje=="1"){ 
			$tipo_bolinha="check.gif";
		}
    
    IF ($preco_cabos<=$preco AND $preco_cabos>0 AND $flag_ativo_boadica=="1"){
      $flag_win_cabos="1";
    }
    ELSE {
      $flag_win_cabos="0";
    }



    		// Pesquisa ultima alteração de preços [ Cabos 2]
		$query_ultima_alteracao_cb2="SELECT data from links_boadica_detalhes_lojas WHERE id_loja='451' AND id_produto='".$id_produto."' ORDER BY data DESC";
		$resultado_ultima_alteracao_cb2 = mysql_query($query_ultima_alteracao_cb2,$conexao);
		
		if(mysql_num_rows($resultado_ultima_alteracao_cb2)>0){
		$data_ultima_alteracao_cb2=mysql_result($resultado_ultima_alteracao_cb2,0,0);
		} 	
		$data_ultima_alteracao_cb2=substr($data_ultima_alteracao_cb2,0,10);
		
		IF ($data_ultima_alteracao_cb2==$dthoje_eua){
			$flag_atualizado_hoje_cb2="1";
			}
				ELSE {
					$flag_atualizado_hoje_cb2="0";					
				}
        
    IF ($flag_atualizado_hoje_cb2=="0"){ 
			$tipo_bolinha_cb2="edit.gif";
		}
		IF ($flag_atualizado_hoje_cb2=="0" AND ($preco<$preco_cabos2) AND $flag_predio==1 AND $flag_ativo=="1"){ 
			$tipo_bolinha_cb2="leftarrow.gif";
      // Incluido em 14Ago18. Poe o produto em evidencia na lista de pendentes, faz com que seja atualizado de 15 em 15 minutos
      $query_evitar_duplicidades="DELETE FROM links_boadica_pendencias WHERE idproduto='".$id_geral_produto."'";
      $resultado_evitar_duplicidades = mysql_query($query_evitar_duplicidades,$conexao);
      $query_incluir_pendencia="INSERT INTO links_boadica_pendencias(`idproduto`,`origem`) VALUES ($id_geral_produto,'pbd_cb2')";
      $resultado_incluir_pendencias = mysql_query($query_incluir_pendencia,$conexao);
		}
    IF ($flag_atualizado_hoje_cb2=="1"){ 
			$tipo_bolinha_cb2="check.gif";
		}

    
    IF ($preco_cabos2<=$preco AND $preco_cabos2>0 AND $flag_ativo_bdcabos2=="1"){
      $flag_win_cabos2="1";
    }
    ELSE {
      $flag_win_cabos2="0";
    }














    
    
    IF ($flag_ativo_boadica=="1"){ 
			$imagem_power="power_on.gif";
      $exibir_preco_cabos=$preco_cabos;
		}
		
		IF ($flag_ativo_boadica=="0"){ 
			$imagem_power="power_off.gif";$exibir_preco_cabos2=$preco_cabos2;
      $exibir_preco_cabos="-----";
		}
		
		
    // Avalia o botao de ativo da Cabos 2
    
    IF ($flag_ativo_bdcabos2=="1"){ 
			$imagem_power_cabos2="power_on.gif";
      $exibir_preco_cabos2=$preco_cabos2;
		}
		IF ($flag_ativo_bdcabos2=="0"){ 
			$imagem_power_cabos2="power_off.gif";
      $exibir_preco_cabos2="-----";
		}
    
    // Comparacao dos precos com a Cabos
		IF ($preco<$preco_cabos){ 
			$imagem_bola="bola_vermelha.gif";
      $cor_fonte_preco_concorrencia="#FF0000";
		}
		IF ($preco==$preco_cabos){ 
			$imagem_bola="bola_amarela.gif";
      $cor_fonte_preco_concorrencia="#FFA500";
		}
		IF ($preco>$preco_cabos){ 
			$imagem_bola="bola_verde.gif";
            $cor_fonte_preco_concorrencia="#000000";
		}
    
    
    // Comparacao dos precos com a Cabos 2
		IF ($preco<$preco_cabos2){ 
			$imagem_bola2="bola_vermelha.gif";
      $cor_fonte_preco_concorrencia="#FF0000";
		}
		IF ($preco==$preco_cabos2){ 
			$imagem_bola2="bola_amarela.gif";
      $cor_fonte_preco_concorrencia="#FFA500";
		}
		IF ($preco>$preco_cabos2){ 
			$imagem_bola2="bola_verde.gif";
            $cor_fonte_preco_concorrencia="#000000";

		}
    
    
    
        
        
        
    // Rotina incluida em 08Ago18, decide se vai exibir ou nao dependendo do flag "atualizavel"
    
    	// Conta quantos anuncios com o mesmo codigo de produtos existem cadastrados no sistema
		$query_quantidade_anuncios="SELECT id from links_boadica WHERE cdproduto='$cd_produto'";
		$resultado_quantidade_anuncios = mysql_query($query_quantidade_anuncios,$conexao);
		$quantidade_anuncios=mysql_num_rows($resultado_quantidade_anuncios);
    
    // Rotina incluida em 12Set18, decide se vai exibir ou nao dependendo do flag "ocultar"
    
    	// Verifica se o codigo consta da tabela links_bd_ocultar, com data de hoje.
		$query_verifica_ocultar="SELECT data from links_boadica_ocultar WHERE idproduto='$id_produto' AND data='$dthoje_eua' AND idloja='$id_loja'";
    //echo $query_verifica_ocultar;
		$resultado_verifica_ocultar = mysql_query($query_verifica_ocultar,$conexao);
		$verifica_resultado=mysql_num_rows($resultado_verifica_ocultar);
    //echo 'Quant '.$id_produto.'  '.$verifica_resultado.'<BR>';
    IF($verifica_resultado==0){
      $flag_ocultar='0';
    }
    ELSE {$flag_ocultar='1';}
    
    
          $contador_item=$contador_item+1; // para gerar o
          //echo $contador_item." - ";

    IF ($filtro_loja==""){
      $var_loja=trim($loja);
      }
      ELSE {$var_loja="";
      }
      
    IF ($ultimo_id_produto==$id_produto){
      $id_loja_todas=$id_loja_todas.",".$id_loja;
    }
    ELSE {
      $id_loja_todas=$id_loja;
    }
    
    $ultimo_id_produto=$id_produto;
    
    //echo "Produto: $id_produto Preco: $preco Preco Cabos: $preco_cabos Preco Cabos 2: $preco_cabos2<BR>";
    
/*    
    IF ($atualizavel=='1' AND $flag_atualizado_hoje=='0'  AND $flag_ocultar=='0'){ // ENCAIXAR ISTO AQUI ->  AND $only_losing=='0' AND $tipo_bolinha=='leftarrow.gif'
      $contador_item_produtos_atualizaveis=$contador_item_produtos_atualizaveis+1;
      IF ($only_losing=='1' AND $tipo_bolinha=='leftarrow.gif'){
  */

  
  // Ratoeira para pegar erros de programacao
  /*
  IF ($id_produto==668){
    echo "Preco: $preco id/Loja: $id_loja->$loja Preco Cabos: $preco_cabos Preco Cabos2: $preco_cabos2 Id Produto: $id_produto Id geral: $id_geral_produto<BR>";
    echo "Flag win CB: $flag_win_cabos Flag win CB2: $flag_win_cabos2 Flag_predio: $flag_predio Flag_ocultar: $flag_ocultar<BR>";
  }
  */
  
  //echo "ID: $id_produto / Loja: $id_loja / flag_win_cabos: $flag_win_cabos / flag_win_cabos2: $flag_win_cabos2 / flag_predio: $flag_predio / flag_ocultar: $flag_ocultar / P: $preco PCb: $preco_cabos PCb2: $preco_cabos2<BR>";
  
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
  
  IF (($flag_win_cabos=="0" AND $flag_win_cabos2=="0") AND $flag_predio=="1" AND $flag_ocultar=="0"){ // perdendo ambas (anuncios ativos), estar no predio e nao estar na lista de ocultar
      echo "<tr><td>".$hora."</td><td><a href='http://www.cabos.etc.br/manutencao/precos_bd_dia.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$var_loja."&only_losing=".$only_losing."'><img src='$imagem_cadeado'></a></td><td><a href='http://www.cabos.etc.br/manutencao/precos_bd_dia.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$var_loja."&only_losing=".$only_losing."'><img src='../imagens/lupa.gif'></a></td><td><a href='".$linkgrupoBD."' TARGET='_blank'><img src='/imagens/relatorioBD.gif'></a></td><td><a href='../manutencao/estatisticas.php?&idproduto=$id_geral_produto&idloja=$id_loja' TARGET='_blank'><img src='/imagens/estatistica.png'></a></td><td><DIV><FONT COLOR='".$cor."'>".substr($loja,0,25)."</FONT></DIV></td><td><a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id_geral_produto&idloja=$id_loja_todas'><img src='../imagens/trash.png'></a></td><td>".$id_geral_produto."</td><td>".$marca."</td><td>".$div_produto.$separador.$div_localizador."</td><td><span class='control-copydiv' onClick=\"return fieldtoclipboard.copyfield(event, 'select".$contador_item."')\"><img src='../imagens/copy.png'></span></td><td>0/0</td><td align='right'><FONT COLOR='$cor_fonte_preco_concorrencia'>".$preco."</FONT></td><td align='right'>".$exibir_preco_cabos."</td><td><IMG SRC='../imagens/".$imagem_power."'></td><td><IMG SRC='../imagens/".$imagem_bola."'></td><td><IMG SRC='../imagens/".$tipo_bolinha."'></td><td align='right'>$exibir_preco_cabos2</td><td><IMG SRC='../imagens/".$imagem_power_cabos2."'></td><td><IMG SRC='../imagens/".$imagem_bola2."'></td><td><IMG SRC='../imagens/".$tipo_bolinha_cb2."'></td><td align='center'><a href='".$link."'  TARGET='_blank'><img src='../imagens/coruja.png'></a></td><td align='center'><a href='../manutencao/precos_bd.php?cdproduto=".$cd_produto."'  TARGET='_blank'>".$cd_produto." (".$quantidade_anuncios.")</a></td><td align='center'><a href='../manutencao/precos_bd.php?inicio_id=$id_produto&limite=1' TARGET='_blank'><img src='../imagens/camera.png'></a></td><td>$link_spy</td></tr>";
  }
// Escondido em 05Ago19
/*      
      }
      
      

      
      IF ($only_losing=='0'){
      echo "<tr><td>".$hora."</td><td><a href='http://www.cabos.etc.br/manutencao/precos_bd_dia.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$var_loja."&only_losing=".$only_losing."'><img src='$imagem_cadeado'></a></td><td><a href='http://www.cabos.etc.br/manutencao/precos_bd_dia.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".$var_loja."&only_losing=".$only_losing."'><img src='../imagens/lupa.gif'></a></td><td><a href='".$linkgrupoBD."' TARGET='_blank'><img src='../imagens/relatorioBD.gif'></a></td><td><DIV><FONT COLOR='".$cor."'>".substr($loja,0,25)."</FONT></DIV></td><td><a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id_geral_produto&idloja=$id_loja'><img src='../imagens/on.png'></a></td><td>".$id_geral_produto."</td><td>".$marca."</td><td><div id='select".$contador_item."'><input type='hidden'  value='".$localizador."'>".$produto."</div></td><td><span class='control-copydiv' onClick=\"return fieldtoclipboard.copyfield(event, 'select".$contador_item."')\">copy</span></td><td align='right'>".$preco_cabos."</td><td align='right'>$preco_cabos2</td><td><FONT COLOR='$cor_fonte_preco_concorrencia'>".$preco."</FONT></td><td><IMG SRC='../imagens/".$imagem_power."'></td><td><IMG SRC='../imagens/".$imagem_bola."'></td><td><IMG SRC='../imagens/".$tipo_bolinha."'></td><td><a href='".$link."'  TARGET='_blank'>Link BD</a></td><td><a href='../manutencao/precos_bd.php?cdproduto=".$cd_produto."'  TARGET='_blank'>".$cd_produto." (".$quantidade_anuncios.")</a></td><td><a href='../manutencao/precos_bd.php?modo=pendentes&id_pesquisa=".$id_produto."'  TARGET='_blank'>".'Link '.$id_produto." </a></td></tr>";
      }
    } // Fim do IF da condicao atualizavel (para exibicao somente dos itens atualizaveis)

    IF ($atualizavel=='0' AND $flag_ocultar=='0'){ // flag para exibir todos os itens, seja possivel ou nao sua atualizacao no dia
      echo "<tr><td>".$hora."</td><td><a href='http://www.cabos.etc.br/manutencao/precos_bd_dia.php?modo=".$modo."&atualizavel=1&data=".$data."&only_actives=".$only_actives."&filtro_loja=".trim($loja)."&only_losing=".$only_losing."'><img src='$imagem_cadeado'></a></td><td><DIV><FONT COLOR='".$cor."'>".substr($loja,0,25)."</FONT></DIV></td><td><a target='_blank' href='precos_bd_rotinas.php?modo=ocultar_link&idproduto=$id_geral_produto&idloja=$id_loja'><img src='../imagens/on.png'></a></td><td>".$id_geral_produto."</td><td>".$marca."</td><td>".$produto."</td><td align='right'>".$preco_cabos."</td><td align='right'>$preco_cabos2</td><td><FONT COLOR='$cor_fonte_preco_concorrencia'>".$preco."</FONT></td><td><IMG SRC='../imagens/".$imagem_power."'></td><td><IMG SRC='../imagens/".$imagem_bola."'></td><td><IMG SRC='../imagens/".$tipo_bolinha."'></td><td><a href='".$link."'  TARGET='_blank'>Link BD</a></td><td><a href='../manutencao/precos_bd.php?cdproduto=".$cd_produto."'  TARGET='_blank'>".$cd_produto." (".$quantidade_anuncios.")</a></td><td><a href='../manutencao/precos_bd.php?modo=pendentes&id_pesquisa=".$id_produto."'  TARGET='_blank'>".'Link '.$id_produto." </a></td></tr>";
    } // Fim do IF da condicao atualizavel (para exibicao somente dos itens nao atualizaveis)
  
  
  */  

	} // Fim da linha de exibicao do produto




  
echo"<tr><td colspan='6'>Clique <a href='http://www.cabos.etc.br/manutencao/precos_bd.php?modo=pendentes' target='_blank'>Aqui</a> para atualizar todos os ($contador_item_produtos_atualizaveis) itens atualizaveis acima</td></tr>";
echo "</table>";

?>



</body>
</html>
