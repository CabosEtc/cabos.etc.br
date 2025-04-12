<html>
    <head>
        <title>Notas fora de ordem</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
        <link rel="stylesheet" type="text/css" href="manutencao.css">
    </head>

    <body>
        <?
            //Prepara conexao ao db
            include("../conectadb.php");

            // Inicializa a sessão
            /*
            include("msession.php");
            IF(!$logado or ($nivelusuario<4)){	
                echo "<meta http-equiv='refresh' content='15; url=index.php' target='_SELF'>";
                die("Seu nível de usuário ($nivelusuario) não permite esta operação...");
            } 
            */
            

            //Recebe variaveis
             
            $dtInicio=$_REQUEST["dtinicio"];
            $dtFim=$_REQUEST["dtfim"];
            $CdLoja=$_REQUEST["cdloja"];
            $flagRed=$_REQUEST["flagred"];

            $queryNotas="	SELECT notas.dtnota, notas.hrnota, notas.nrnota, notas.idnota, notas.vlnota, notas.formapagamento, 
                            notas.vlpago, notas.formapagamento2, notas.vlpago2, usuarios.usuario 
                            FROM `notas`, `usuarios` 
                            WHERE notas.cdloja=$CdLoja
                            AND notas.idvendedor=usuarios.idusuario 
                            AND notas.dtnota>='$dtInicio' 
                            AND notas.dtnota<='$dtFim' 
                            order by notas.idnota;";
            //echo "$queryNotas<br>";
            $resultadoNotas = mysql_query($queryNotas,$conexao);
          
 
            echo "<h3>Listagem de Notas: Início: $dtInicio | Fim: $dtFim</h3><br>";
            
            echo "  <table>
                        <tr>
                            <td align='center'>DtNota</td>
                            <td align='center'>Hora</td>
                            <td align='center'>Número</td>
                            <td align='center'>Id</td>
                            <td align='center'>Valor</td>
                            <td align='center'>Forma Pgto</td>
                            <td align='center'>Valor</td>
                            <td align='center'>Forma Pgto</td>
                            <td align='center'>Valor</td>
                            <td align='center'>Usuario</td>
                        </tr>";
            $dtNotaAnterior="2000-01-01";
            while ($row = mysql_fetch_array($resultadoNotas, MYSQL_NUM)) {
                $dtNota=$row[0];
                $hrNota=$row[1];
                $nrNota=$row[2];
                $idNota=$row[3];
                $vlNota=$row[4];
                $formaPagamento=$row[5];
                $vlPago=$row[6];
                $formaPagamento2=$row[7];
                $vlPago2=$row[8];
                $usuario=$row[9];
                if ($dtNota<$dtNotaAnterior){
                    $corFonte="#FF0000";

                }
                else{
                    $corFonte="#000000";
                }
               
                if(($flagRed==1 and $corFonte=="#FF0000") or ($flagRed<>1)){
                    echo "  <tr>
                                <td align='center'><font color=$corFonte>$dtNota</font></td>
                                <td align='center'>$hrNota</td>
                                <td align='center'>$nrNota</td>
                                <td align='center'>$idNota</td>
                                <td align='center'>$vlNota</td>
                                <td align='center'>$formaPagamento</td>
                                <td align='center'>$vlPago</td>
                                <td align='center'>$formaPagamento2</td>
                                <td align='center'>$vlPago2</td>
                                <td align='center'>$usuario</td>
                            </tr>";
                }
                $dtNotaAnterior=$dtNota;
            } // fim while
            
            echo "</table>";
        ?>

    </body>
</html>
