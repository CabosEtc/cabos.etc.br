<?
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");

    //Prepara conexao ao db
    include("../../conectadb.php");

    // Recebe variaveis
    //$modo=$_REQUEST["modo"];
    //$linkBD=$_REQUEST["linkbd"];
    $msg = file_get_contents('php://input');

    $arrJson=(json_decode($msg, true)); // true retorna array, sem parametro retorna objeto
    $modo=$arrJson["modo"];
    $linkBD=$arrJson["linkBD"]; // Aqui chega o id do linkBD

    $depuração=false;

    if ($depuração){
        $modo="ajustarFlagAtivo";
        $linkBD="p50601";
        // Ativa a exibição de erros
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }


    //Espera ser chamada com "https://www.cabos.etc.br/m/scraper/rotinasScraper.php?modo=ajustarFlagAtivo&linkbd=p6923"

    if ($modo=="ajustarFlagAtivo"){
        $query="UPDATE `links_boadica`  
                SET `flag_ativo`=0 
                WHERE link='https://www.boadica.com.br/produtos/$linkBD'";
        $resultado = mysql_query($query,$conexao);
        $linhasAfetadas=mysql_affected_rows();
        echo "Mensagem de rotinasScraper | Linhas afetadas: $linhasAfetadas";
        //echo "Mensagem de rotinasScraper.php: Done!";
    }
?>