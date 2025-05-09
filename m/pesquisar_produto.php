<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Pesquisa de produtos</title>
</head>

<?
  //Mostra erros
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);
  //Prepara conexao ao db
  include("../conectadb.php");

  // Inicializa a sessão
  include("msession.php");
  IF(!$logado){	
    echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
  } 
  //echo $nivelusuario;

  $query="SELECT nomeloja 
          FROM lojas 
          WHERE cdloja='".$cdloja."'";
  $resultado = mysql_query($query,$conexao);
  $nomeloja=mysql_result($resultado,0,0);

  $queryCentroDeCustos="	SELECT cdloja_centro_custo  
                          FROM lojas  	
                          WHERE cdloja='".$cdloja."'";
  $resultadoCentroDeCustos = mysql_query($queryCentroDeCustos,$conexao);
  $centroDeCustos=mysql_result($resultadoCentroDeCustos,0,0);

  $queryCentroDePrecos="	SELECT cdloja_centro_precos  
                          FROM lojas  	
                          WHERE cdloja='".$cdloja."'";
  $resultadoCentroDePrecos = mysql_query($queryCentroDePrecos,$conexao);
  $centroDePrecos=mysql_result($resultadoCentroDePrecos,0,0);


  $quantidadeProduto=$_REQUEST["quantidade"];
  $chave=$_REQUEST["chave"];
  $ArrayChave  = explode(' ', $chave);
  $chave1=$ArrayChave[0];
  $chave2=$ArrayChave[1];
  $chave3=$ArrayChave[2];
  $idItemPesquisa=$_REQUEST["iditem"];


  if ($chave<>""){
    $query="SELECT produtos.cdproduto, produtos.nome, precos.vlvenda, produtos.modelo, produtos.cdfabricante   
    FROM produtos,precos, fabricantes      
    WHERE precos.cdproduto=produtos.cdproduto 
    AND produtos.cdfabricante=fabricantes.cdfabricante 
    AND precos.cdloja='$centroDePrecos' 
    AND precos.ativo=1 
    AND (
      (produtos.nome LIKE '%$chave1%' AND  produtos.nome LIKE '%$chave2%' AND  produtos.nome LIKE '%$chave3%')  
      OR produtos.ean='$chave1'    
      OR produtos.cdproduto='$chave1'
      OR produtos.modelo LIKE '%$chave1%'  
      OR fabricantes.nome LIKE '%$chave1%' 
      ) 
      ORDER BY produtos.nome, fabricantes.cdfabricante";
    $resultado = mysql_query($query,$conexao);
    //echo "Query: $query<br>";
  }
?>
<body>
<div id="conteudo">

  <div>Pesquisa produto: Busca composta, modelo, fabricante, código EAN ou código do produto.</div>
  <?php
    echo" <div>Centro de Custos: $centroDeCustos</div>
          <div>Centro de Preços: $centroDePrecos</div>";
  ?>
<!--      <form id="form1" name="form1" method="post" action="">-->
	  <form action="pesquisar_produto.php" method="get">
      <table width="700" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100">Nome          </td>
          <td><label>
            <input name="chave" type="text" id="chave" size="30" maxlength="50" />
            <input type="submit" name="pesquisar" id="pesquisar" value="Ok" />
            <input type="hidden" name="iditem" value="<?php print$idItemPesquisa; ?>">
            <input type="hidden" name="quantidade" value="<?php print$quantidadeProduto; ?>">
          </label></td>
        </tr>
      </table>

      <table width="700" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td><label>
            <div align="right"></div>
          </label></td>
        </tr>
        <?
        $tamanho_chave=strlen($chave);
        if ($chave<>""){
          while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
            $cdproduto=$row[0]; 
            $nome=$row[1]; 
            $vlvenda=$row[2];
            $modelo=$row[3];
            $cdFabricante=$row[4];
            $queryFabricante="SELECT nome FROM fabricantes WHERE cdfabricante=$cdFabricante";
            $resultadoFabricante = mysql_query($queryFabricante,$conexao);
            $nomeFabricante=mysql_result($resultadoFabricante,0,0);
            if ($cdFabricante==0){
              $nomeFabricante="N/D";
            }
            else{
              $queryFabricante="SELECT nome FROM fabricantes WHERE cdfabricante=$cdFabricante";
              $resultadoFabricante = mysql_query($queryFabricante,$conexao);
              $nomeFabricante=mysql_result($resultadoFabricante,0,0);
            }
            
            if ($modelo<>""){
              $modelo="[$modelo]";
            }
            
            // Pesquisa do preços de custo
            $queryVlCompra="SELECT estoque.vlindividual, estoque.dtmovimento, fornecedor.apelido  
                            FROM estoque, fornecedor 
                            WHERE estoque.fornecedor=fornecedor.id 
                            AND cdproduto='$cdproduto' 
                            AND cdloja = '$centroDeCustos' 
                            AND historico = 51 
                            ORDER BY dtmovimento DESC";

            //echo "QueryVlCompra: $queryVlCompra<br>";
            $resultadoVlCompra = mysql_query($queryVlCompra,$conexao);

            $vlCompraConcatenado="";
            while ($row = mysql_fetch_array($resultadoVlCompra, MYSQL_NUM)) {
              $vlcompra=$row[0]; 
              $dtcompra=$row[1]; 
              //echo "dtCompraLoop $dtcompra<br>";
              $apelidoFornecedor=$row[2];
              $vlCompraConcatenado=$vlCompraConcatenado."$vlcompra $dtcompra $apelidoFornecedor\n";
            }



            //$vlcompra=mysql_result($resultado4,0,0);
            //IF($vlcompra==''){
            //  $vlcompra=0;
            //}
            //$dtmovimento=mysql_result($resultado4,0,1);

            

            

            // Rotina para calcular o tempo da ultima atualizacao, usado para definir o icone de alerta

            $dtmovimento=mysql_result($resultadoVlCompra,0,1);
            IF($dtmovimento==''){
              $dtmovimento='2001-01-01';
            }
            $dtPreco=new DateTime($dtmovimento);
            $dtHoje=new DateTime($dthoje_eua);
            //echo "Dtmovimento $dtmovimento<br>";
            // Resgata diferença entre as datas
            $dateInterval = $dtPreco->diff($dtHoje);
            $diasDecorridos=$dateInterval->days;
            //echo ("Dias decorridos: $diasDecorridos<br>");
            if($diasDecorridos>120){
              $iconePrecoAntigo="<img title='Produto sem atualização a $diasDecorridos dias' 
              src='../imagens/informacaoRed.png' width='16' height='16'/>
              <a href='einc.php?cdproduto=$cdproduto' target='_blank'>
              <img style='padding-left: 5px;' src='../imagens/addEstoque.png' title='Incluir produtos no estoque' width='16' height='16' /></a>";
            }elseif ($diasDecorridos>60){
              $iconePrecoAntigo="<img title='Produto sem atualização a $diasDecorridos dias' 
                                  src='../imagens/warning.png' width='16' height='16'/>
                                  <a href='einc.php?cdproduto=$cdproduto' target='_blank'>
                                  <img style='padding-left: 5px;' src='../imagens/addEstoque.png' title='Incluir produtos no estoque' width='16' height='16' /></a>";
            }
            
            else{
              $iconePrecoAntigo="<a href='einc.php?cdproduto=$cdproduto' target='_blank'>
                                  <img style='padding-left: 5px;' src='../imagens/addEstoque.png' title='Incluir produtos no estoque' width='16' height='16' /></a>";
            }

          
            $dtatualizacao=date("d/m/Y",strtotime($dtmovimento));









            // Pesquisa para mostrar o valor das ultimas vendas
            $queryUltimasVendas=" SELECT notas_detalhes.vlproduto, notas.dtnota 
                                  FROM notas_detalhes, notas  
                                  WHERE notas_detalhes.idnota=notas.idnota 
                                  AND notas_detalhes.cdproduto='$cdproduto' 
                                  AND notas.cdloja='$cdLoja' 
                                  ORDER BY notas.dtnota DESC 
                                  LIMIT 10 ";

            //echo "queryUltimasVendas: $queryUltimasVendas<br>";
            $resultadoUltimasVendas = mysql_query($queryUltimasVendas,$conexao);

            $ultimasVendasConcatenadas="";
            while ($row = mysql_fetch_array($resultadoUltimasVendas, MYSQL_NUM)) {
              $vlVenda=$row[0]; 
              $dtNota=$row[1]; 
              $ultimasVendasConcatenadas=$ultimasVendasConcatenadas."$dtNota $vlVenda \n";
            }









              
              
              
            // Aqui entra rotina que pesquisa nossos precos no boadica e mostra suspenso no "title" do preco
            $precos_bd="Valores anunciados no BD:\n";
            $query_id_links=" SELECT links_boadica.id 
                              FROM links_boadica 
                              WHERE cdproduto='$cdproduto' 
                              ORDER BY id";
            //echo $query_id_links;
            $resultado_id_links = mysql_query($query_id_links,$conexao);
            while ($row = mysql_fetch_array($resultado_id_links, MYSQL_NUM)) {
              $id_links=$row[0];
              $query_id_links_preco="SELECT preco,data, id_produto  
                                      FROM links_boadica_detalhes_snapshot 
                                      WHERE id_produto='$id_links' 
                                      AND (id_loja='19' OR id_loja='451') 
                                      ORDER BY data DESC";
              //echo "$query_id_links_preco<br>";
              $resultado_id_links_preco = mysql_query($query_id_links_preco,$conexao);
              //$valor_cabos=mysql_result($resultado_id_links_preco,0,0);
              //$idProduto=mysql_result($resultado_id_links_preco,0,2);
              while ($row_preco = mysql_fetch_array($resultado_id_links_preco, MYSQL_NUM)) {
                $precoProduto=$row_preco[0];
                $dataPesquisa=$row_preco[1];
                $idAnuncio=$row_preco[2];
                if($precoProduto<>0){
                  $data_valor_cabos=date("d/m/Y [h:m",strtotime($dataPesquisa))."hrs]";
                  $precos_bd=$precos_bd."$idAnuncio | R$ ".$precoProduto." - ".$data_valor_cabos."\n";
                }
              }
              
              //IF($valor_cabos<>0){
                //$data_valor_cabos=date("d/m/Y [h:m",strtotime(mysql_result($resultado_id_links_preco,0,1)))."hrs]";
                //$precos_bd=$precos_bd."$idProduto | R$ ".$valor_cabos." - ".$data_valor_cabos."\n";
              //}
            }
            
            $titleVlVenda="$precos_bd\n--------------------------------\nValor de compra: \n$vlCompraConcatenado\n--------------------------------\nUltimas vendas: \n$ultimasVendasConcatenadas";
            echo "<tr>
                  <td width='60'><img onmouseover='this.width=\"300\"; this.height=\"300\"' src='../imagens/produtos/$cdproduto.jpg' onmouseout='this.width=\"60\"; this.height=\"60\"' width='60' height='60'/></td>
                  <td width='100' style='padding-left: 5px;'>$nomeFabricante</td>
                  <td width='20'><a href='' id='campoFilho' onclick=\"putData('".$cdproduto."','".$nome."','".$vlvenda."')\">".$cdproduto."</a></td>
                  <td width='350' style='padding-left: 5px;'>$nome $modelo</td>
                  <td width='50' title='$titleVlVenda'>$vlvenda</td>
                  <td width='50'>$iconePrecoAntigo</td>
                  <td width='20'><a href='pinc.php?cdproduto=$cdproduto&modo=editar' target='_blank'><img src='../imagens/edit.png' title='Editar o produto' width='16' height='16' /></a></td>
                  </tr>";
        
            // este if � para verificar se a pesquisa foi feita pelo codigo ean
        
            if ($tamanho_chave==13){
              echo "<script language='Javascript' type='text/javascript'> ";
              echo "putData('".$cdproduto."','".$nome."','".$vlvenda."');";
              echo "</script>";
            }
          } // fim do while
          
        } // fim do primeiro if
      ?>
      </table>
      </form>
      

</div> <!-- Fim da div principal-->

<script language="Javascript" type="text/javascript"> 
    function putData(codigo,nome,valor) {  
        var codigo = codigo;
        var nome = nome;
        var valor = valor;
        let idItemPesquisa=<?php print $idItemPesquisa; ?>; // Php passando dados para o javascript
        let quant=`quant${idItemPesquisa}`;
        let cdproduto=`cdproduto${idItemPesquisa}`;
        let discriminacao=`discriminacao${idItemPesquisa}`;
        let vlunitario=`vlunitario${idItemPesquisa}`;
        //alert(quant);
        //alert(cdproduto);

        if (codigo!= ""){   
            window.opener.document.getElementById(quant).value = <?php print $quantidadeProduto; ?>; // Php passando dados para o javascript;   
            window.opener.document.getElementById(cdproduto).value = codigo;  
            window.opener.document.getElementById(discriminacao).value = nome;  
            window.opener.document.getElementById(vlunitario).value = valor; 
            window.opener.document.getElementById(quant).focus();  
            window.close();   
        }
        else { 
            alert('N�o � permitido campos em Brancos');
        }
    }  
</script>

</body>
</html>
