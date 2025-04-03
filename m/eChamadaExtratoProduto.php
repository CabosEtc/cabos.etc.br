
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
    <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
    <title>Extrato do produto</title>
</head>

<link href="../lojas.css" rel="stylesheet" type="text/css" /> <!--  Vai sair  -->
<link rel="stylesheet" type="text/css" href="manutencao.css">

<script type="text/javascript" src="js/ajax2020.js"></script>

<body>

<?
    //Prepara conexao ao db
    include("../conectadb.php");

    // Inicializa a sessão
	include("msession.php");
	IF(!$logado){	
		echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	} 
	//echo $nivelusuario;

    //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
    $query="SELECT nomeloja, apelido, lojas_grupo   
            FROM lojas 
            WHERE cdloja='".$cdloja."'";
    $resultado = mysql_query($query,$conexao);
    $nomeloja=mysql_result($resultado,0,0);
    $apelidoLoja=mysql_result($resultado,0,1);
    $lojasGrupo=mysql_result($resultado,0,2);

    // Inclui o menu
    include("mmenu.php"); 
?>    

<div id="wrapper" class="wrapper">
    <h3>
        Visualizar extrato de produto no estoque
    </h3>

    <form action="eExtratoProduto.php" method="get">

        <table width="500" border="0" align="left">
            <tr>
                <td width='100' align="left">
                    Loja:
                </td>
                <td width='400'>
                    <select name='cdLojaX'>
                    <?
                        $arrayLojasGrupo=explode(',', $lojasGrupo);
                        // Retira o código da loja da lista de destino (para não transferir para ela mesma), neste caso não é desejavel retirar. 
                        //$arrayLojasGrupo=array_diff($arrayLojasGrupo, array($cdloja));
                        foreach ($arrayLojasGrupo as $item) {
                            $queryApelidoLoja=" SELECT apelido 
                                                FROM lojas 
                                                WHERE cdloja=$item";
                            $resultadoApelidoLoja = mysql_query($queryApelidoLoja,$conexao);
                            $apelidoLoja=mysql_result($resultadoApelidoLoja,0,0);
                            echo "  <option value='$item'>
                                        $apelidoLoja
                                    </option>";
                        }
                    ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    Cd Produto
                </td>
                <td>
                    <input name="cdProduto" type="text"  placeholder="Código do produto" size='20' maxlength="5"/>
                </td>
            </tr>


            <tr>
                <td>
                    <label for="dtCorte">
                        Data do corte:
                    </label>
                </td>
                <td>
                    <input type="date" id="dtCorte" name="dtCorte" value="<? echo $dthoje_eua; ?>" min="2001-01-01" max="<? echo $dthoje_eua; ?>">
                </td>
            </tr>



            <tr>
                <td>
                    <input type="submit" name="Enviar" id="Enviar" value="Submit" />
                </td>
            </tr>

        </table>
    <p>&nbsp;</p>
    </form>

</div> <!-- fim do wrapper -->

</body>
</html>
