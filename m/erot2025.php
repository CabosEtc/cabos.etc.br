<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Rotina de entrada</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<?
			//Prepara conexao ao db
			include("../conectadb.php");


            // Recebe o JSON do POST
            $json = file_get_contents("php://input");
            /*
            $json='[
                    {
                        "cdproduto": "12315",
                        "fornecedor": "1",
                        "dtentrada": "2025-02-03",
                        "quantidade": 20,
                        "vlindividual": 1.5
                    },
                    {
                        "cdproduto": "20338",
                        "fornecedor": "1",
                        "dtentrada": "2025-02-03",
                        "quantidade": 10,
                        "vlindividual": 3
                    }
                    ]';
            */
            $dados = json_decode($json, true); // transforma em array associativo

            if (!is_array($dados)) {
                die("Dados inválidos.");
            }
            
            // Define valores fixos
            $historico = '51';
            //$cdloja = '1'; // Pode ser fixo ou vindo da aplicação
            $link = '';    // Pode ser ajustado conforme necessidade
            foreach ($dados as $item) {
                // Escapar dados manualmente (proteção básica para PHP 5.6)
                $cdproduto  = mysql_real_escape_string($item['cdproduto']);
                $fornecedor = mysql_real_escape_string($item['fornecedor']);
                $dtentrada  = mysql_real_escape_string($item['dtentrada']); // formato YYYY-MM-DD
                $quantidade = intval($item['quantidade']);
                $valor      = floatval($item['vlindividual']);
        
                echo "Codigo do produto: ".$cdproduto."<br>";
                echo "Fornecedor: ".$fornecedor."<br>";
                echo "Valor: ".$valor."<br>";
                echo "Quantidade: ".$quantidade."<br>";
                echo "Data da chegada: ".$dtentrada."<br>";
            
                // incluir o produto no banco de dados do estoque
                $query="INSERT INTO estoque(iditem, cdproduto, historico, fornecedor, dtmovimento, quantidade, idcompra, cdloja, vlindividual, link) 
                VALUES ('null', '$cdproduto', '51', '$fornecedor', '$dtentrada', '$quantidade', '0', '$cdloja', $valor, '$link')";
                echo "$query<br>";
                $resultado = mysql_query($query,$conexao);
            }
        ?>
	</body>
</html>