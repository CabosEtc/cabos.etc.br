<html>
	<head>
		<title>Contagem from CSV</title>
        <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="manutencao.css">
	</head>
	<body>
        <?php
            //Prepara conexao ao db
            include("../conectadb.php");

            //Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
            $query="SELECT nomeloja, apelido, lojas_grupo   
                    FROM lojas 
                    WHERE cdloja='".$cdloja."'";
            $resultado = mysql_query($query,$conexao);
            $nomeloja=mysql_result($resultado,0,0);
            $apelidoLoja=mysql_result($resultado,0,1);
            $lojasGrupo=mysql_result($resultado,0,2);
        ?>
        <form action="eContagemFromCSV.php" method="post">
            <table>
                <tr>
                    <td>
                        Loja
                    </td>
                    <td>
                        <select name='cdloja'>
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
                        Data da contagem
                    </td>
                    <td>
                        <input type="date" name="dtcontagem" value="<? echo $dthoje_eua; ?>" min="2001-01-01" max="<? echo $dthoje_eua; ?>">
                    </td>
                </tr>

                
                <tr>
                    <td>
                        Excluir movimento a partir de...
                    </td>
                    <td>
                        <input type="date" name="dtexclusao" value="<? echo $dthoje_eua; ?>" min="2001-01-01" max="">
                        &nbsp*Inclusive
                    </td>
                </tr>

                <tr>
                    <td>
                        Cole aqui o conteúdo do CSV
                    </td>
                    <td>
                        <textarea name="csv" cols="50" rows="20" type="text">
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button class="btn btn-primary">Enviar</button>
                    </td>
                </tr>
            </table>
        </form>                                
    </body>
</html>


