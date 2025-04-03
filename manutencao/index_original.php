<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manuten&ccedil;&atilde;o</title>
</head>
<link href="../cabos.css" rel="stylesheet" type="text/css" />
<body>

<?
// Busca o codigo da Loja
$ponteiro = fopen ("../loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  echo "codigo da loja: ".$linha."<br>";
}
fclose ($ponteiro);
?>

<?
session_start();
if (!isset($_SESSION["usuario"])){
			echo "<meta http-equiv='refresh' content='0; url=../manutencao/login.php'>";
	}
include("../manutencao/menu.php");?>
<br />
<table width="960" border="0" align="center">
  <tr>
    <td><h3>Produtos</h3></td>
  </tr>
  <tr>
    <td style="padding-left:20px"><a href="../manutencao/produtos.php?modo=reduzido">Listar produtos cadastrados no sistema</a></td>
  </tr>
<?
if ($_SESSION["nivel"]>=3){
  	echo "<tr>";
    echo "<td style='padding-left:20px'><a href='../manutencao/produtos.php?modo=completo'>Listar produtos cadastrados no sistema c/ custo</a></td>";
	echo "</tr>";
  	echo "<tr>";
    echo "<td style='padding-left:20px'><a href='../manutencao/etiquetas_rotinas.php?modo=todas_as_etiquetas'>Gerar lista de produtos para impressão de etiquetas</a></td>";
	echo "</tr>";
  	echo "<tr>";
    echo "<td style='padding-left:20px'><a href='../manutencao/etiquetas.php'>Gerar etiquetas</a></td>";
	echo "</tr>";
}
?>

<?
if ($_SESSION["nivel"]>=4){
	echo "<tr>";
	echo "<td style='padding-left:20px'>";
	echo "<a href='../manutencao/produtos_incluir_selecionar_categoria.php'>Incluir produtos no Banco de dados</a>";
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td style='padding-left:20px'>";
	echo "<a href='../manutencao/produtos_unificar.php'>Unificar produtos no Banco de dados</a>";
	echo "</td>";
	echo "</tr>";
}
?>

  <tr>
    <td>&nbsp;</td>
  </tr>
<?

if ($_SESSION["nivel"]>=4){
  echo "<tr>";
  echo "<td><h3>Estoque </h3></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_selecionarproduto.php'>Incluir produtos no Estoque a partir de compra anterior</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_incluir_manual.php'>Incluir produtos no Estoque (Compra efetuada fora do sistema de compras)</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque.php'>Listar produtos em estoque</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque.php?favorito=1'>Listar produtos em estoque (somente favoritos)</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_contagem.php'>Listagem para contagem de estoque (alfabetica).</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_contagem_ordem_numerica.php'>Listagem para contagem de estoque (p/ codigo).</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_movimentar.php'>Movimento de estoque para as lojas.</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/estoque_baixar.php'>Baixar produto no estoque por defeito/perda.</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'>&nbsp;</td>";
  echo "</tr>";
  //echo "<tr><td>&nbsp;</td></tr>";
}

// Compras

if ($_SESSION["nivel"]>=4){
  echo "<tr>";
  echo "<td><h3>Compras</h3></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/compras_incluir.php'>Incluir compras no sistema</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><form id='form2' name='form2' method='get' action='../manutencao/cartao_listar_compras.php'>
      Listar compras do m&ecirc;s
          <input name='periodo' type='text' id='periodo' size='10' maxlength='7' />
ex (03/2010)
<input name='modo' type='hidden' id='modo' value='listar_todas_compras' />
<input type='submit' name='Ok2' id='Ok2' value='Ok' />
    </form></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><form id='form2' name='form2' method='get' action='../manutencao/cartao_listar_compras.php'>
      Listar compras do m&ecirc;s
          <input name='periodo' type='text' id='periodo' size='10' maxlength='7' />
agrupadas por produto  
<input name='modo' type='hidden' id='modo' value='listar_todas_compras_agrupadas' />
<input type='submit' name='Ok2' id='Ok2' value='Ok' />
    </form></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><form id='form1' name='form1' method='get' action='../manutencao/cartao_listar_compras.php'>
        <label>
          Listar compras do Cart&atilde;o:
            <input name='cartao' type='text' id='cartao' size='10' maxlength='4' />
        </label>
    Periodo:
    <label>
      <input name='periodo' type='text' id='periodo' size='10' maxlength='7' />
    </label>
    <label>
      ex (04/2010)
        <input name='modo' type='hidden' id='modo' value='listar_compras_cartao_numero' />
<input type='submit' name='Ok' id='Ok' value='Ok' />
    </label>
      </form></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><a href='../manutencao/compras.php'>Listar todas as compras (agrupadas por produto)</a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'><form id='form7' name='form7' method='get' action='../manutencao/guiacompras_mes.php'>
      Guia para compras baseada no m&ecirc;s
      <input name='periodo' type='text' id='periodo' size='10' maxlength='7' />
       ex: (06/2010)
       <input type='submit' name='Ok' id='Ok' value='Ok' />
    </form></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td style='padding-left:20px'>&nbsp;</td>";
  echo "</tr>";
}
 ?>
  <tr>
<td><h3>Vendas</h3></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/vendas.php">Incluir nova nota</a></td>
  </tr>
  <tr>
    <td height="20" style="padding-left:20px"><a href="../manutencao/devolucao.php">Devolu&ccedil;&atilde;o de produto</a></td>
  </tr>
<?

  echo "<tr>";
  echo "<td style='padding-left:20px'>
  <form id='form4' name='form4' method='get' action='../manutencao/parametros_rotinas.php'>
      Alterar data das notas
      <input name='dtnota' type='text' id='dtnota' size='10' maxlength='10' />
	  <input name='modo' type='hidden' id='modo' value='alterar_dtnota' />
      <input type='submit' name='Ok3' id='Ok3' value='Ok' />
    ex (24/02/2010), deixe vazio para assumir a data atual
    </form>
</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<td style='padding-left:20px'>
  <form id='form4' name='form4' method='get' action='../manutencao/vendas_rotinas.php'>
      Excluir nota
      <input name='nrnota' type='text' id='nrnota' size='10' maxlength='5' />
	  <input name='modo' type='hidden' id='modo' value='excluir' />
      <input type='submit' name='Ok3' id='Ok3' value='Ok' />
    ex (22)
    </form>
</td>";
  echo "</tr>";
  
?>

  <tr>
    <td style="padding-left:20px">
    <form id="form3" name="form3" method="get" action="../manutencao/nota.php">
      Imprimir nota
      <input name="nrnota" type="text" id="nrnota" size="10" maxlength="5" />
      <input type="submit" name="Ok3" id="Ok3" value="Ok" />
    ex (22)
    </form>
    </td>
  </tr>
  <tr>
    <td style="padding-left:20px"><form id="form4" name="form4" method="get" action="../manutencao/notas_listar.php">
      Listar notas do dia
      <input name="data" type="text" id="data" size="10" maxlength="10" />
      <input type="submit" name="Ok4" id="Ok4" value="Ok" />
    </form></td>
  </tr>
  <tr>
    <td style="padding-left:20px"><form id="form5" name="form5" method="get" action="../manutencao/vendas_dia.php">
      Listagem de produtos vendidos no dia
      <input name="periodo" type="text" id="periodo" size="10" maxlength="10" />
agrupados por produto.

ex (02/02/2010)
<input type="submit" name="Ok5" id="Ok5" value="Ok" />
    </form></td>
  </tr>
  <tr>
    <td style="padding-left:20px"><form id="form6" name="form6" method="post" action="../manutencao/vendas_mes.php">
      Listagem de produtos vendidos no m&ecirc;s
      <input name="periodo" type="text" id="periodo" size="10" maxlength="7" />
agrupados por produto.

ex (06/2010)
<input type="submit" name="Ok6" id="Ok6" value="Ok" />
    </form></td>
  </tr>
  <tr>
        <td style="padding-left:20px"><form id="form6" name="form6" method="post" action="../manutencao/vendas_top_mes.php">
      Produtos Top do  m&ecirc;s
      <input name="periodo" type="text" id="periodo" size="10" maxlength="7" />
agrupados por produto.

ex (04/2010)
<input type="submit" name="Ok6" id="Ok6" value="Ok" />
    </form></td>
  </tr>
  <tr>
    <td style="padding-left:20px">&nbsp;</td>
  </tr>
<? if(!isset($_SESSION["usuario"])){
	echo "<tr>";
	echo "<td><h3>Fornecedores</h3></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='padding-left:20px'><a href='../manutencao/fornecedores.php'>Listar fornecedores/endere&ccedil;os</a></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='padding-left:20px'><a href='../manutencao/fornecedores_incluir.php'>Incluir fornecedor</a></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='padding-left:20px'>&nbsp;</td>";
	echo "</tr>";
}

if ($_SESSION["nivel"]>=5){
	echo"<tr>";
	echo"<td><h3>Banco de dados</h3></td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td style='padding-left:20px'><a href='http://whm.cpweb0001.servidorwebfacil.com:2082/?login_theme=cpanel'>Php Admin</a></td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td style='padding-left:20px'><a href='../manutencao/bd.php'>Estrutura</a></td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td style='padding-left:20px'><a href='../manutencao/cores.php' target='_blank'>Tabela de cores</a></td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td>&nbsp;</td>";
	echo"</tr>";
	}

if ($_SESSION["nivel"]>=1){
	echo"<tr>";
	echo"<td><h3>Links importantes</h3></td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td style='padding-left:20px'><a href='../manutencao/links.php'>Visualizar links</a></td>";
	echo"</tr>";
 	}
?>
</table>
</body>
</html>
