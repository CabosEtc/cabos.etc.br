<?php

//phpinfo();

//Mostra erros
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/*
if (function_exists("mysqli_connect")) {
    echo "MySQLi está ativado!";
} else {
    echo "MySQLi NÃO está ativado!";
}
*/


/* Versão 1.1
* Ajusta timezone
* Variaveis disponiveis:
* $cdloja=integer
* $cdloja2=integer
* $idlojabd=integer (19-Cabos, 2-Supergames )
* $idloja2bd=integer (451-Cabos 2, 239-Supernova)
* $nomeloja=string
* $raiz_site
* $caminho_imagens=string
* $index_description=string 
* $index_keywords=string
* $dthoje_eua=(Y-m-d")
* $dthoje_bra=("d-m-Y")
* $dtpesquisa="Ymd")
* $hora=('H:i:s')
*/

        //$mysqli = new mysqli("localhost", "u641118057_flavio", "Fgl@159753", "u641118057_cabos_bd");

        $host = "localhost"; // Exemplo: "localhost" ou "127.0.0.1"
        $user = "u641118057_flavio";
        $password = "Fgl@159753";
        $database = "u641118057_cabos_bd";
        
        $mysqli = new mysqli($host, $user, $password, $database);
        
        if ($mysqli->connect_error) {
            die("Falha na conexão: " . $mysqli->connect_error);
        }

        // Define o charset para UTF-8
        /*
        if (!$mysqli->set_charset("utf8")) {
            die("Erro ao definir charset: " . $mysqli->error);
        }
        */    
	
// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');		

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dthoje_bra=date("d/m/Y",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));
$hora=date("H:i:s",strtotime("now"));



// Busca o codigo e o nome da loja (fica disponivel em: $cdloja e $nome_loja)
$raiz_site=$_SERVER['DOCUMENT_ROOT'];

$ponteiro = fopen ($raiz_site."/loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
 // echo "codigo da loja: $cdloja";
 // echo gettype($cdloja); 

}
fclose ($ponteiro);

if($cdloja==1) {
	$idlojabd=19;
	$idloja2bd=451;
}

if($cdloja==8) {
	$idlojabd=2;
	$idloja2bd=239;
}


$ponteiro = fopen ($raiz_site."/imagens.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $caminho_imagens=$linha;
}
fclose ($ponteiro);

/*

$query="SELECT nomeloja, index_description, index_keywords FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);
$index_description=mysql_result($resultado,0,1);
$index_keywords=mysql_result($resultado,0,2);
*/

// Preparar e executar a consulta
$query = "SELECT nomeloja, index_description, index_keywords FROM lojas WHERE cdloja =?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $cdloja);
$stmt->execute();

//get_result() está gerando erro (mesmo com mysqllnd habilitado, talvez seja versao do php).
//$resultado = $stmt->get_result();

// Vincular os resultados às variáveis
$stmt->bind_result($nomeloja, $index_description, $index_keywords);
$stmt->fetch();

// Obter os resultados
//if ($row = $stmt->fetch_assoc()) {
//   echo "loja: $nomeloja";
//    $index_description = $row["index_description"];
//    $index_keywords = $row["index_keywords"];
/*
} else {
    $nomeloja = $index_description = $index_keywords = null;
}
    */

// Fechar conexão (colocar em todas a páginas para não deixar aberta)

//$stmt->close();
//$mysqli->close();

// Exibir resultados para testes (remova esta parte em produção)
//echo "Nome da Loja: $nomeloja<br>";
//echo "Descrição: $index_description<br>";
//echo "Palavras-chave: $index_keywords<br>";
?>