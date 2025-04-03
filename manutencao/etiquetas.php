<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Produtos - Editar no BD</title>
</head>
<link href="../cabos.css" rel="stylesheet" type="text/css" />
<body>
<?
include("../manutencao/menu.php");
?>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>

<br/>
<h3>Gerador de etiquetas</h3>
<form id="form1" name="form1" method="get" action="../manutencao/etiquetas_rotinas.php">
  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Codigo </td>
      <td>Repeti&ccedil;&otilde;es</td>
      <td align="center" valign="middle">Estilo</td>
      <td rowspan="4" align="center"><input type="submit" name="botao2" id="botao2" value="Enviar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td rowspan="3" align="center" valign="middle"><img src="../imagens/etiqueta_tp1.gif" width="39" height="60" /></td>
      </tr>
    <tr>
      <td><label>
        <input name="cd1" type="text" id="cd1" size="15" maxlength="5" />
      </label></td>
      <td align="center">80x</td>
      </tr>
    <tr>
      <td><input name="modo" type="hidden" id="modo" value="80" /></td>
      <td>&nbsp;</td>
      </tr>
  </table>
</form>
  <br />
  <br />
  <form id="form2" name="form2" method="get" action="../manutencao/etiquetas_rotinas.php">
  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Codigo </td>
      <td>Repeti&ccedil;&otilde;es</td>
      <td align="center" valign="middle">Estilo</td>
      <td rowspan="5" align="center"><input type="submit" name="botao3" id="botao3" value="Enviar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td rowspan="4" align="center" valign="middle"><img src="../imagens/etiqueta_tp2.gif" alt="" width="40" height="60" /></td>
      </tr>
    <tr>
      <td><label>
        <input name="cd1" type="text" id="cd1" size="15" maxlength="5" />
      </label></td>
      <td align="center">40x</td>
      </tr>
    <tr>
      <td><input name="cd2" type="text" id="cd6" size="15" maxlength="5" /></td>
      <td align="center">40x</td>
      </tr>
    <tr>
      <td><input name="modo" type="hidden" id="modo" value="4040" /></td>
      <td>&nbsp;</td>
      </tr>
  </table>
</form>

  <br />
  <br />
    <form id="form3" name="form3" method="get" action="../manutencao/etiquetas_rotinas.php">

  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Codigo </td>
      <td>Repeti&ccedil;&otilde;es</td>
      <td align="center" valign="middle">Estilo</td>
      <td rowspan="7" align="center"><input type="submit" name="botao4" id="botao4" value="Enviar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      </tr>
    <tr>
      <td><label>
        <input name="cd1" type="text" id="cd1" size="15" maxlength="5" />
      </label></td>
      <td align="center">20x</td>
      <td rowspan="4" align="center" valign="middle"><img src="../imagens/etiqueta_tp3.gif" alt="" width="40" height="60" /></td>
      </tr>
    <tr>
      <td><input name="cd2" type="text" id="cd3" size="15" maxlength="5" /></td>
      <td align="center">20x</td>
      </tr>
    <tr>
      <td><input name="cd3" type="text" id="cd4" size="15" maxlength="5" /></td>
      <td align="center">20x</td>
      </tr>
    <tr>
      <td><input name="cd4" type="text" id="cd9" size="15" maxlength="5" /></td>
      <td align="center">20x</td>
      </tr>
    <tr>
      <td><input name="modo" type="hidden" id="modo" value="20202020" /></td>
      <td>&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      </tr>
  </table>
</form>

  <br />
  <br />
      <form id="form4" name="form4" method="get" action="../manutencao/etiquetas_rotinas.php">

  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Codigo </td>
      <td>Repeti&ccedil;&otilde;es</td>
      <td align="center" valign="middle">Estilo</td>
      <td rowspan="6" align="center"><input type="submit" name="botao" id="botao" value="Enviar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      </tr>
    <tr>
      <td><label>
        <input name="cd1" type="text" id="cd7" size="15" maxlength="5" />
      </label></td>
      <td align="center">40x</td>
      <td rowspan="3" align="center" valign="middle"><img src="../imagens/etiqueta_tp4.gif" alt="" width="40" height="60" /></td>
      </tr>
    <tr>
      <td><input name="cd2" type="text" id="cd8" size="15" maxlength="5" /></td>
      <td align="center">20x</td>
      </tr>
    <tr>
      <td><input name="cd3" type="text" id="cd3" size="15" maxlength="5" /></td>
      <td align="center">20x</td>
      </tr>
    <tr>
      <td><input name="modo" type="hidden" id="modo" value="402020" /></td>
      <td>&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      </tr>
  </table>
<p>&nbsp;</p>
</form>

</td>
</tr>
</table>
</body>
</html>
