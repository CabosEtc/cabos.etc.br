<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    //Prepara conexao ao db
    //require("conectadb_v25.php");

/*    
    $host = "localhost"; // Exemplo: "localhost" ou "127.0.0.1"
    $user = "u641118057_flavio";
    $password = "Fgl@159753";
    $database = "u641118057_cabos_bd";
    
    $mysqli = new mysqli($host, $user, $password, $database);

    // Verifique se a conexão com o banco de dados está ativa    
    if ($mysqli->connect_error) {
        die("Falha na conexão: " . $mysqli->connect_error);
    }
*/
    //Dados em Json puro
    $dadosRecebidos='   [
                            {
                                "codigo": "12315",
                                "codigo_fornecedor": "123",
                                "custo": 30.00,
                                "quantidade": 20,
                                "data": "2025-02-03"
                            },
                            {
                                "codigo": "12316",
                                "codigo_fornecedor": "124",
                                "custo": 45.50,
                                "quantidade": 15,
                                "data": "2025-02-10"
                            },
                            {
                                "codigo": "12317",
                                "codigo_fornecedor": "125",
                                "custo": 28.75,
                                "quantidade": 10,
                                "data": "2025-02-15"
                            },
                            {
                                "codigo": "12318",
                                "codigo_fornecedor": "126",
                                "custo": 60.00,
                                "quantidade": 5,
                                "data": "2025-02-20"
                            },
                            {
                                "codigo": "12319",
                                "codigo_fornecedor": "127",
                                "custo": 22.40,
                                "quantidade": 30,
                                "data": "2025-02-25"
                            }
                        ]';
    $dadosRecebidos = json_decode($dadosRecebidos, true);
    
    //Recebe o JSON enviado pelo JavaScript e transforma em objeto (array)
    //$dadosRecebidos = json_decode(file_get_contents("php://input"), true);

    foreach ($dadosRecebidos as $linha) {
        $codigoProduto = $linha['codigo'];
        $codigoFornecedor = $linha['codigo_fornecedor'];
        $custoProduto = $linha['custo'];
        $quantidadeProduto = $linha['quantidade'];
        $data = $linha['data'];
        echo ("$codigoProduto | $codigoFornecedor | $custoProduto | $quantidadeProduto | $data<br>");

    }

    

/*
    foreach ($dadosRecebidos as &$linha) {
        $codigoProduto = $linha['codigo'];

        
        $stmt = $mysqli->query("SELECT cdproduto,nome FROM produtos WHERE cdproduto='$codigoProduto'");
        
        if (!$stmt) {
            die("Erro na consulta: " . $mysqli->error);
        }
        
        $row = $stmt->fetch_row(); // Pega os resultados

        if ($row) {
            // Produto encontrado
            $linha['flagLocalizado'] = "1";
            $linha['nomeSistema'] = $row[1]; // Usa o nome correto
        } else {
            // Produto não encontrado
            $linha['flagLocalizado'] = "0";
            $linha['nomeSistema'] = "";
        }
    }

// Nesta linha o ponteiro é retornado para o elemento 0 do array para consultar o fornecedor
*/     
    //reset($dadosRecebidos);

/*    
    foreach ($dadosRecebidos as &$linha) {
        $apelidoFornecedor = $linha['fornecedor'];

        $stmt = $mysqli->query("SELECT id FROM fornecedor WHERE apelido='$apelidoFornecedor'");
        
        if (!$stmt) {
            die("Erro na consulta: " . $mysqli->error);
        }
        
        $row = $stmt->fetch_row(); // Pega os resultados

        if ($row) {
            // Fornecedor encontrado
            $linha['flagFornecedor'] = "1";
        } else {
            // Produto não encontrado
            $linha['flagFornecedor'] = "0";
        }
    }
*/    

    // Supondo que o código do produto está na primeira coluna do JSON
        //
        //echo "$codigoProduto";

   
        //$result = $mysqli->query("SELECT cdproduto, nome FROM produtos WHERE cdproduto='$codigoProduto'");

        //$row = $result->fetch_row();
        //echo "Código: " . $row[0] . " | Nome: " . $row[1] . "<br>";

/*
       // Verifique se a conexão com o banco de dados está ativa
        if (!$mysqli) {
            die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
        }

        /*
        // Prepara a consulta para verificar se o produto existe no banco de dados
        if (!$stmt) { // Verifica se a preparação falhou
            die("Erro na preparação da consulta: " . $mysqli->error . " | Query: SELECT cdproduto,nome FROM produtos WHERE cdproduto ='12315'");
        }
        //$stmt->bind_param("s", '12315');
        $stmt->execute();
        //$stmt->store_result(); // Armazena o resultado da consulta
        $stmt->bind_result($cdproduto, $nmproduto);

        echo "$nmproduto";
        
        if ($stmt->fetch()) {
            // Produto encontrado
            $linha['flagExiste'] = "1";
            $linha['nomeProduto'] = $nmproduto; // Adicionamos o nome do produto no array
        } else {
            // Produto não encontrado
            $linha['flagExiste'] = "0";
            $linha['nomeProduto'] = ""; // Retorna vazio caso não exista
        }
        //$linha['flagExiste'] = ($stmt->num_rows > 0) ? "1" : "0";
        

        $result = $mysqli->query("SELECT cdproduto, nome FROM produtos WHERE cdproduto='$codigoProduto'");

        if (!$result) {
            die("Erro na consulta: " . $mysqli->error);
        }
        //    echo "Código: " . $row['cdproduto'] . " | Nome: " . $row['nome'] . "<br>";
        */
   // }
    // Importante: Remova a referência no final do foreach para evitar problemas futuros
    //unset($linha);
    


    // Fecha a conexão com o banco de dados
    //$stmt->close();
    //$mysqli->close();

    // Retorna o resultado como JSON
    //header("Content-Type: application/json");
    //echo json_encode($dadosRecebidos);
    //echo "oi";
?>
