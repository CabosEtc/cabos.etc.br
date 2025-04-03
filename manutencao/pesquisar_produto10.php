<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Pesquisa de produtos</title>
</head>

<script language="Javascript" type="text/javascript"> 

function putData(codigo,nome,valor) {  
   var codigo = codigo;
   var nome = nome;
   var valor = valor;
     
   if (codigo!= ""){   
   window.opener.document.getElementById('quant10').value = 1;   
   window.opener.document.getElementById('cdproduto10').value = codigo;  
   window.opener.document.getElementById('discriminacao10').value = nome;  
   window.opener.document.getElementById('vlunitario10').value = valor;  
   window.opener.document.getElementById('vlunitario10').focus();  
   window.close();   
   }else{ 
    alert('Não é permitido campos em Brancos');
    }
}  
</script>
<?
//Prepara conexao ao db
include("../conectadb.php");

// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $cdloja = fgets($ponteiro, 4096);
}
fclose ($ponteiro);

$query="SELECT nomeloja FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);

?>
<?
$chave=$_REQUEST["chave"];

//Prepara conexao ao db
include("../conectadb.php");

if ($chave<>""){
$query="SELECT precos.cdproduto, produtos.nome, precos.vlvenda FROM produtos,precos WHERE precos.cdproduto=produtos.cdproduto AND precos.cdloja='".$cdloja."' AND (nome LIKE '%".$chave."%' OR ean='".$chave."') ORDER BY nome";
$resultado = mysql_query($query,$conexao);
}

?>
<body>
<table width="500" cellspacing="0" cellpadding="0">
  <tr><td>
  <p>Pesquisa produto</p>
<!--      <form id="form1" name="form1" method="post" action="">-->
	  <form action="pesquisar_produto10.php" method="get">
      <table width="500" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100">Nome          </td>
          <td><label>
            <input name="chave" type="text" id="chave" size="30" maxlength="50" />
            <input type="submit" name="pesquisar" id="pesquisar" value="Ok" />
          </label></td>
        </tr>
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
			echo "<tr><td width='20'><a href='' id='campoFilho' onclick=\"putData('".$cdproduto."','".$nome."','".$vlvenda."')\">".$cdproduto."</a></td><td width='350'>".$nome."</td><td width='50'>".$vlvenda."</td></tr>";
			
			
			// este if é para verificar se a pesquisa foi feita pelo codigo ean
			
		if ($tamanho_chave==13){
			echo "<script language='Javascript' type='text/javascript'> ";
			echo "putData('".$cdproduto."','".$nome."','".$vlvenda."');";
			echo "</script>";
			}
			
			}
		}
	?>
      </table>
      </form>
      
  </td></tr>
</table>

<?

    $query2="SELECT favoritos.cdproduto,produtos.nome,precos.vlvenda FROM favoritos,produtos, precos WHERE produtos.cdproduto=precos.cdproduto AND favoritos.cdproduto=produtos.cdproduto AND favoritos.cdloja='".$cdloja."'  AND precos.cdloja='".$cdloja."' GROUP BY favoritos.cdproduto ORDER BY favoritos.cdproduto";
$resultado2 = mysql_query($query2,$conexao);

$cdproduto1=mysql_result($resultado2,0,0);
$cdproduto2=mysql_result($resultado2,1,0);
$cdproduto3=mysql_result($resultado2,2,0);
$cdproduto4=mysql_result($resultado2,3,0);
$cdproduto5=mysql_result($resultado2,4,0);
$cdproduto6=mysql_result($resultado2,5,0);
$cdproduto7=mysql_result($resultado2,6,0);
$cdproduto8=mysql_result($resultado2,7,0);
$cdproduto9=mysql_result($resultado2,8,0);
$cdproduto10=mysql_result($resultado2,9,0);
$cdproduto11=mysql_result($resultado2,10,0);
$cdproduto12=mysql_result($resultado2,11,0);
$cdproduto13=mysql_result($resultado2,12,0);
$cdproduto14=mysql_result($resultado2,13,0);
$cdproduto15=mysql_result($resultado2,14,0);
$cdproduto16=mysql_result($resultado2,15,0);

$nomeproduto1=mysql_result($resultado2,0,1);
$nomeproduto2=mysql_result($resultado2,1,1);
$nomeproduto3=mysql_result($resultado2,2,1);
$nomeproduto4=mysql_result($resultado2,3,1);
$nomeproduto5=mysql_result($resultado2,4,1);
$nomeproduto6=mysql_result($resultado2,5,1);
$nomeproduto7=mysql_result($resultado2,6,1);
$nomeproduto8=mysql_result($resultado2,7,1);
$nomeproduto9=mysql_result($resultado2,8,1);
$nomeproduto10=mysql_result($resultado2,9,1);
$nomeproduto11=mysql_result($resultado2,10,1);
$nomeproduto12=mysql_result($resultado2,11,1);
$nomeproduto13=mysql_result($resultado2,12,1);
$nomeproduto14=mysql_result($resultado2,13,1);
$nomeproduto15=mysql_result($resultado2,14,1);
$nomeproduto16=mysql_result($resultado2,15,1);

$vlvenda1=mysql_result($resultado2,0,2);
$vlvenda2=mysql_result($resultado2,1,2);
$vlvenda3=mysql_result($resultado2,2,2);
$vlvenda4=mysql_result($resultado2,3,2);
$vlvenda5=mysql_result($resultado2,4,2);
$vlvenda6=mysql_result($resultado2,5,2);
$vlvenda7=mysql_result($resultado2,6,2);
$vlvenda8=mysql_result($resultado2,7,2);
$vlvenda9=mysql_result($resultado2,8,2);
$vlvenda10=mysql_result($resultado2,9,2);
$vlvenda11=mysql_result($resultado2,10,2);
$vlvenda12=mysql_result($resultado2,11,2);
$vlvenda13=mysql_result($resultado2,12,2);
$vlvenda14=mysql_result($resultado2,13,2);
$vlvenda15=mysql_result($resultado2,14,2);
$vlvenda16=mysql_result($resultado2,15,2);

echo "<table width='900' border='0'>";
echo "<tr>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto1.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto1."','".$nomeproduto1."','".$vlvenda1."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto2.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto2."','".$nomeproduto2."','".$vlvenda2."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto3.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto3."','".$nomeproduto3."','".$vlvenda3."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto4.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto4."','".$nomeproduto4."','".$vlvenda4."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto5.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto5."','".$nomeproduto5."','".$vlvenda5."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto6.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto6."','".$nomeproduto6."','".$vlvenda6."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto7.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto7."','".$nomeproduto7."','".$vlvenda7."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto8.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto8."','".$nomeproduto8."','".$vlvenda8."')\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td height='21' align='center'>".$nomeproduto1."</td>";
echo "<td height='21' align='center'>".$nomeproduto2."</td>";
echo "<td height='21' align='center'>".$nomeproduto3."</td>";
echo "<td height='21' align='center'>".$nomeproduto4."</td>";
echo "<td height='21' align='center'>".$nomeproduto5."</td>";
echo "<td height='21' align='center'>".$nomeproduto6."</td>";
echo "<td height='21' align='center'>".$nomeproduto7."</td>";
echo "<td height='21' align='center'>".$nomeproduto8."</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto9.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto9."','".$nomeproduto9."','".$vlvenda9."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto10.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto10."','".$nomeproduto10."','".$vlvenda10."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto11.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto11."','".$nomeproduto11."','".$vlvenda11."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto12.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto12."','".$nomeproduto12."','".$vlvenda12."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto13.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto13."','".$nomeproduto13."','".$vlvenda13."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto14.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto14."','".$nomeproduto14."','".$vlvenda14."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto15.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto15."','".$nomeproduto15."','".$vlvenda15."')\"></td>";
echo "<td width='100' align='center' valign='middle'><img src='http://www.companhiadoscabos.com.br/imagens/produtos/".$cdproduto16.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto16."','".$nomeproduto16."','".$vlvenda16."')\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td height='21' align='center'>".$nomeproduto9."</td>";
echo "<td height='21' align='center'>".$nomeproduto10."</td>";
echo "<td height='21' align='center'>".$nomeproduto11."</td>";
echo "<td height='21' align='center'>".$nomeproduto12."</td>";
echo "<td height='21' align='center'>".$nomeproduto13."</td>";
echo "<td height='21' align='center'>".$nomeproduto14."</td>";
echo "<td height='21' align='center'>".$nomeproduto15."</td>";
echo "<td height='21' align='center'>".$nomeproduto16."</td>";
echo "</tr>";
echo "</table>";

?>



</body>
</html>
