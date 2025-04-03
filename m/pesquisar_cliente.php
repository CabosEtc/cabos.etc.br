<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link href="manutencao.css" rel="stylesheet" type="text/css" />
        <title>Pesquisa de clientes</title>
    </head>
    <?
        //Prepara conexao ao db
        include("../conectadb.php");

        // Inicializa a sessão
        include("msession.php");
        if(!$logado){	
            echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
        } 

        $chave=$_REQUEST["chave"];
        $modo=$_REQUEST["modo"];
    ?>
    <body>
        <div id='menuSuperior'>
            <a href='../m/pesquisar_cliente.php?modo=preencherCadastro'>
                <img src='../imagens/addverde.png' onlick='' target='_self'>
            </a>
        </div>

        <?php
            if($modo=='preencherCadastro'){
                echo "<p>Cadastro de cliente:</p>";
                echo "
                    <form action='pesquisar_cliente.php' method='get'>
                        <table width='700' cellspacing='2' cellpadding='0'>
                            <tr>
                                <td width='100'>
                                    Nome:
                                </td>
                                <td>
                                    <input name='nome' type='text' size='30' maxlength='50' />
                                </td>
                            </tr>
                            <tr>
                                <td width='100'>
                                    CPF/CNPJ:
                                </td>
                                <td>
                                    <input name='cpfCnpj' type='text' size='30' maxlength='14' />
                                </td>
                            </tr>

                            <tr>
                                <td width='100'>
                                    Telefone:
                                </td>
                                <td>
                                    <input name='telefone' type='text' size='30' maxlength='11' />
                                </td>
                            </tr>

                            <tr>
                                <td width='100'>
                                    &nbsp;
                                </td>
                                <td>
                                    <input type='hidden' name='modo' value='incluirCadastro' />
                                    <input type='submit' name='pesquisar' value='Ok' />
                                </td>
                            </tr>
                        </table>
                    </form>";
            }

            if($modo==''){
                echo "<p>Pesquisa cliente: Por nome, sobrenome, nome fantasia, telefone ou cpf.</p>";
                echo "
                    <form action='pesquisar_cliente.php' method='get'>
                        <table width='700' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td width='100'>Nome          </td>
                                <td>
                                    <input name='chave' type='text' id='chave' size='30' maxlength='50' />
                                    <input type='submit' name='pesquisar' id='pesquisar' value='Ok' />
                                </td>
                            </tr>
                        </table>
                    </form>";
                if ($chave<>""){
                    $query="SELECT cdcliente, nome, nome_fantasia, cpf_cnpj, telefone     
                            FROM cadastro       
                            WHERE nome like '%$chave%'   
                            OR telefone like '%$chave%'    
                            OR cpf_cnpj like '%$chave%' 
                            OR nome_fantasia like '%$chave%' 
                            ORDER BY nome";
                            $resultado = mysql_query($query,$conexao);
                            //echo "$query";
                    echo "<div>Chave da pesquisa: $chave</div>";
                    echo "<p>Resultados:</p>";
                    echo " <table class='table table-bordered' width='700'>";
                    echo "  <thead>
                                <tr>
                                    <td>
                                        Nome
                                    </td>
                                    <td>
                                        Nome fantasia
                                    </td>
                                    <td>
                                        CPF/CNPJ
                                    </td>
                                    <td>
                                        Telefone
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                            </thead>";
                    while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                        $cdCliente=$row[0];
                        $nomeCliente=$row[1]; 
                        $nomeFantasia=$row[2];
                        $cpfCnpj=$row[3];
                        $telefoneCliente=$row[4];

                        echo "  
                                <tr>
                                    <td onclick=\"putData('$cdCliente','$nomeCliente');\">
                                        $nomeCliente
                                    </td>
                                    <td onclick=\"putData('$cdCliente','$nomeFantasia');\">
                                        $nomeFantasia
                                    </td>
                                    <td>
                                        $cpfCnpj
                                    </td>
                                    <td>
                                        $telefoneCliente
                                    </td>
                                    <td>
                                        <img src='../imagens/edit.png' title='Em desenvolvimento...' width='16' height='16'>
                                    </td>
                                </tr>";
                    
                    }
                    echo "</table>";
                }
            }
            if($modo=='incluirCadastro'){
                $nome=$_REQUEST["nome"];
                $cpfCnpj=$_REQUEST["cpfCnpj"];
                $telefone=$_REQUEST["telefone"];
                $queryInsereCliente="INSERT INTO `cadastro` (`cdcliente`, `nome`, `cpf_cnpj`, `telefone`, `dt`) 
                                    VALUES (NULL, '$nome', '$cpfCnpj', '$telefone', '$timestampSaoPaulo')";
                //echo"$queryInsereCliente<br>"; 
                $resultadoInsereCliente = mysql_query($queryInsereCliente,$conexao);
                $cdCliente=mysql_insert_id($conexao);


                echo "  <div>
                            $nome
                        </div>
                        <div>
                            $cpfCnpj
                        </div>
                        <div>
                            $telefone
                        </div>
                        <div>
                            Clique <span onclick=\"putData('$cdCliente','$nome $sobrenome');\"> aqui </span> para incluir
                        </div>
                        ";
            }
        ?>
    </body>

    <script language="Javascript" type="text/javascript"> 
            function putData(cdcliente,nome) {  
                if (nome!= ""){   
                    //alert(nome+" teste");
                    window.opener.document.getElementById('nomeCliente').innerHTML = nome;   
                    window.opener.document.getElementById('cdCliente').value = cdcliente;  
                    window.opener.document.getElementById('nomeCliente').focus();  
                    window.close();   
                }
                else { 
                    alert('Não é permitido campos em Brancos');
                }
            }  
    </script>
</html>
