<html>
<head>
<meta charset="UTF-8">
<title>BD Precos Rotinas</title>
</head>

<script language="javascript">
function popup(){
window.opener=self;
setTimeout("window.close()",10000);
}
</script>

<body onload=popup()>

<?
session_start();
//if (!isset($_SESSION["usuario"])){
//			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
//	}

//Prepara conexao ao db
include("../conectadb.php");

$dthoje_eua=date("Y-m-d",strtotime("now"));

$modo=$_REQUEST["modo"];
$marca=$_REQUEST["marca"];
$cdproduto=$_REQUEST["cdproduto"];
$link=$_REQUEST["link"];
$produto=$_REQUEST["produto"];
$idproduto=$_REQUEST["idproduto"];
$idloja=$_REQUEST["idloja"];
$flag_ativo=$_REQUEST["flag_ativo"];
$localizador=$_REQUEST["localizador"];
$preco=$_REQUEST["preco"];
$flagmeiodia=$_REQUEST["flagmeiodia"];
$flagmeiodia=$_REQUEST["flagmeiodia"];
$idRegistro=$_REQUEST["idRegistro"];

//Incluir bd_id_anuncios
$idloja1=$_REQUEST["idloja1"];
$idloja2=$_REQUEST["idloja2"];
$idanunciobdloja1=$_REQUEST["idanunciobdloja1"];
$idanunciobdloja2=$_REQUEST["idanunciobdloja2"];
$idlinkbd=$_REQUEST["idlinkbd"];


IF($modo=="cadastrar_link"){
     $query_incluir_link="INSERT INTO links_boadica(`id`, `marca`,`produto`,`cdproduto`,`link`,`flag_ativo`,`flag_ativo_boadica`,`flag_ativo_bdcabos2`,`descricao`, `localizador`) VALUES ('NULL', '$marca', '$produto', '$cdproduto', '$link','$flag_ativo','1','1','','$localizador')";
     $resultado_incluir_link = mysql_query($query_incluir_link,$conexao);
     //echo $query_incluir_link;
  }
  
  IF($modo=="ocultar_link"){
    $id_lojas = explode(",", $idloja);
    
    echo "quantidade de itens escondidos: ".count($id_lojas). "<BR><BR><BR>";
    echo "Clique <A target='_blank' href='BDPrecosRotinas.php?modo=reexibir_link&idproduto=$idproduto&idloja=$idloja'>Aqui</A> para reexibir os itens deletados<BR><BR><BR>";
    
    FOR ($i = 0; $i < count($id_lojas); $i++) {
      //echo 'Id loja ' . $i . ', Valor: ' . $id_lojas[$i] . PHP_EOL;
      $query_ocultar_link="INSERT INTO links_boadica_ocultar (`id`,`idproduto`,`cdloja`,`idloja`,`data`,`preco`,`flagmeiodia`) VALUES ('NULL','$idproduto','$cdloja','$id_lojas[$i]','$dthoje_eua','$preco','$flagmeiodia')";
      $resultado_ocultar_link = mysql_query($query_ocultar_link,$conexao);
      echo "$query_ocultar_link<br>";
     }

  }
  
  
IF($modo=="ocultar_cdproduto"){
    
   $query="SELECT id FROM links_boadica WHERE cdproduto='$cdproduto' ORDER BY id";
   echo $query;
   $resultado=mysql_query($query, $conexao);
    
    echo "quantidade de itens escondidos: ".count($resultado). "<BR><BR><BR>";
    //echo "Clique <A target='_blank' href='BDPrecosRotinas.php?modo=reexibir_link&idproduto=$idproduto&idloja=$idloja'>Aqui</A> para reexibir os itens deletados<BR><BR><BR>";
    
while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
  $idlink=$row[0]; 
	//echo "$idlink<br>";
	
   $query_ocultar_link="INSERT INTO links_boadica_ocultar (`id`,`idproduto`,`cdloja`,`idloja`,`data`,`preco`,`flagmeiodia`) 
   VALUES ('NULL','$idlink','$cdloja','0','$dthoje_eua','$preco','$flagmeiodia')";
	$resultado_ocultar_link = mysql_query($query_ocultar_link,$conexao);
	echo "$query_ocultar_link<br>";      
  
  }
    
}  
  
  
  IF($modo=="reexibir_link"){
    $id_lojas = explode(",", $idloja);
    
    echo "quantidade de itens reexibidos: ".count($id_lojas). "<BR>";
    
    FOR ($i = 0; $i < count($id_lojas); $i++) {
      //echo 'Id loja ' . $i . ', Valor: ' . $id_lojas[$i] . PHP_EOL;
      $query_reexibir_link="DELETE FROM links_boadica_ocultar WHERE `idproduto`='$idproduto' AND `cdloja`='$cdloja' AND `idloja` IN ($idloja)";
      $resultado_reexibir_link = mysql_query($query_reexibir_link,$conexao);
      echo $query_reexibir_link;
     }
  }
  
  
  IF($modo=="altera_flag_ativo"){
  	if($idloja==1) {
     $query_altera_flag_ativo="UPDATE `links_boadica` SET `flag_ativo`='$flag_ativo' WHERE `links_boadica`.`id`=$idproduto";
	}     
  	if($idloja==4) {
     $query_altera_flag_ativo="UPDATE `links_boadica` SET `flag_ativosg`='$flag_ativo' WHERE `links_boadica`.`id`=$idproduto";
	}     
     $resultado_altera_flag_ativo = mysql_query($query_altera_flag_ativo,$conexao);
     echo $query_altera_flag_ativo;
     echo "Status alterado<br>Fechando automaticamente em 10s...";
     
  }
  
  IF($modo=="zerar_ocultar_link"){
     $query_zerar_ocultar="DELETE FROM `links_boadica_ocultar` WHERE `cdloja`='$cdloja'";
     $resultado_zerar_ocultar = mysql_query($query_zerar_ocultar,$conexao);
     //echo $query_ocultar_link;
  }


IF($modo=="ajustar_data"){
     // Aproveita e zera os produtos que estavam ocultos no dia anterior
     $query_zerar_ocultar="DELETE FROM `links_boadica_ocultar` WHERE 1=1";
     $resultado_zerar_ocultar = mysql_query($query_zerar_ocultar,$conexao);
     //echo $query_ocultar_link;
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-08-02 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-08-03 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-08-03 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-14 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-15 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-15 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-15 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-16 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-16 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-16 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-17 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-17 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-17 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-18 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-18 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-18 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-19 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-19 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-19 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-20 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-20 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-20 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-21 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-21 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-21 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-22 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-22 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-22 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-23 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-23 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-23 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-24 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-24 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-24 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-25 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-25 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-25 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-26 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-26 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-26 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-27 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-27 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-27 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-28 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-28 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-28 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-29 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-29 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-29 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-30 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-30 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-30 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-05-31 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-05-31 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
     $query_ajustar_data="UPDATE `links_boadica_detalhes_lojas` SET `links_boadica_detalhes_lojas`.`data`= '2020-05-31 23:59:00'
     WHERE `links_boadica_detalhes_lojas`.`data`>'2020-06-01 00:00:00' AND `links_boadica_detalhes_lojas`.`data`<'2020-06-01 04:00:00'";
     $resultado_ajustar_data = mysql_query($query_ajustar_data,$conexao);
     
  }

  if($modo=="apagarRegistroDetalhesLojas"){
    $queryApagarRegistro="DELETE FROM `links_boadica_detalhes_lojas` WHERE `links_boadica_detalhes_lojas`.`id` =$idRegistro";
    $resultadoApagarRegistro = mysql_query($queryApagarRegistro,$conexao);
    //echo $query_ocultar_link;
  }


//echo"Clique <a href='http://www.cabos.etc.br/manutencao/index.php' target='_blank'>Aqui</a> para voltar";


// INSERT INTO `links_boadica` (`id`, `marca`, `produto`, `cdproduto`, `link`, `flag_ativo`, `flag_ativo_boadica`, `descricao`) VALUES (NULL, '3D Connexion', 'TV Box OTT Android 7.1.2', '17000', 'https://www.boadica.com.br/produtos/p156987', '1', '1', '');

IF($modo=="cadastrar_id_anuncio_bd"){
  $query_incluir_id_anuncio_bd="INSERT INTO 
  bd_id_anuncios(`id`, `idloja`,`idlinkbd`,`idanunciobd`)  
  VALUES ('NULL', '$idloja1', '$idlinkbd', '$idanunciobdloja1')";
  $resultado_incluir_id_anuncio_bd = mysql_query($query_incluir_id_anuncio_bd,$conexao);
  //echo $query_incluir_link;

  $query_incluir_id_anuncio_bd="INSERT INTO 
  bd_id_anuncios(`id`, `idloja`,`idlinkbd`,`idanunciobd`)  
  VALUES ('NULL', '$idloja2', '$idlinkbd', '$idanunciobdloja2')";
  $resultado_incluir_id_anuncio_bd = mysql_query($query_incluir_id_anuncio_bd,$conexao);
  //echo $query_incluir_link;

  echo" <div>idlink: $idlinkbd</div>
        <div>idloja1: $idloja1</div>
        <div>idloja2: $idloja2</div>
        <div>idanunciobd1: $idanunciobdloja1</div>
        <div>idanunciobd2: $idanunciobdloja2</div>";
}

?>


</body>
</html>
