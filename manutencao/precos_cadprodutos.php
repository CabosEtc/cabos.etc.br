<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
</head>

<script>

function mouseOver(src, clr) {

  src.style.cursor = 'hand';

  src.bgColor = clr;

}



function mouseOut(src, clr) {

  src.style.cursor = 'default';

  src.bgColor = clr;

}



function mouseClick(id, nome) {

  confirma = confirm("Incluir o produto "+nome+" na sua loja?");

  if (confirma) 

      document.location = 'precos_cadprodutos2.php?cdproduto='+id;

}

</script>

<link href="../lojas.css" rel="stylesheet" type="text/css" />
<body>

<?
//Prepara conexao ao db
include("../conectadb.php");
?>

<?
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

?>

<?
session_start();
/*if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
	*/
	$_SESSION["usuario"]="flavio";
	$_SESSION["nivel"]="4";
	
include("../manutencao/menu.php");
?>
<br>
<form action="../manutencao/precos_cadprodutos.php" method="get">
<table width="500" border="1" align="center">
  <tr>
    <td>
      Fabricante: 
      
<?      $query="SELECT cdfabricante, nome FROM fabricantes ORDER BY nome ASC";
		$resultado = mysql_query($query,$conexao);
		echo "<select name='fabricante' id='fabricante'>";
		echo "<option value='999'>Todos</option>";
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdfabricante=$row[0]; // nome da categoria
			$nomefabricante=$row[1]; // nome da categoria
			echo "<option value='".$cdfabricante."'>".$nomefabricante."</option>";
		}
		echo "</select>";
?>    
	</td>
    <td><input name="modo" type="submit" value="Enviar" id="modo" />
    </td>
  </tr>
</table>
</form>
<?
$modo=$_REQUEST["modo"];
$fabricante=$_REQUEST["fabricante"];


?>
<table width="960" border="1" align="center">
  <tr>
    <td>Fabricante</td>
    <td>Modelo</td>
    <td>Especifica&ccedil;&atilde;o</td>
  </tr>
<?
if ($modo=="Enviar"){
		if($fabricante<>999){
      		$query="SELECT produtos.cdproduto, produtos.nome, fabricantes.nome FROM produtos, fabricantes WHERE fabricantes.cdfabricante='".$fabricante."' AND produtos.cdfabricante=fabricantes.cdfabricante ORDER BY fabricantes.nome, produtos.nome ASC";
		}
		
		if($fabricante==999){
      		$query="SELECT produtos.cdproduto, produtos.nome, fabricantes.nome FROM produtos, fabricantes WHERE produtos.cdfabricante=fabricantes.cdfabricante ORDER BY fabricantes.nome, produtos.nome ASC";
		}
		
	  // echo $query;
		$resultado = mysql_query($query,$conexao);
		while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdproduto=$row[0]; // nome da categoria
			$nomeproduto=$row[1]; // nome da categoria
			$nomefabricante=$row[2]; // nome da categoria
			      $query2="SELECT precos.cdproduto FROM precos WHERE precos.cdproduto='".$cdproduto."' AND precos.cdloja='".$cdloja."'";
	  			// echo $query;
				$resultado2 = mysql_query($query2,$conexao);
				$existenobd=mysql_num_rows($resultado2);
				if ($existenobd==0){ // se estiver no bd de precos, não é listado abaixo...
					echo "<tr onMouseOver=\"mouseOver(this, '#CCCCCC');\" onMouseOut=\"mouseOut(this, '#FFFFFF');\" onClick=\"mouseClick('".$cdproduto."', '".$cdproduto."-".$nomeproduto."')\">";
					echo "<td>".$nomefabricante."</td>";
					echo "<td>".$cdproduto."-".$nomeproduto."</td>";
					echo "<td>"."&nbsp;"."</td>";
					echo "</tr>";
				}
		}
	}
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
