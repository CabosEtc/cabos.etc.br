<?
/* Versão 1.1
* Ajusta timezone
* Variaveis disponiveis:
* $cdloja=integer
* $cdloja2=integer
* $idlojabd=integer (19-Cabos, 2-Supergames )
* $idloja2bd=integer (451-Cabos 2, 239-Supernova)
* nomeloja=string
* $raiz_site
* $caminho_imagens=string
* $index_description=string 
* $index_keywords=string
* $dthoje_eua=(Y-m-d")
* $dthoje_bra=("d-m-Y")
* $dtpesquisa="Ymd")
* $horasistema=('H')
*/

// Conecta ao mysql
	$msg[0] = "Conexão com o banco falhou!";
	$msg[1] = "Não foi possível selecionar o banco de dados!";

// Fazendo a conexão com o servidor MySQL
		$conexao = @mysql_pconnect("bdhost0036.servidorwebfacil.com","cabos_user","fg15975300") or die($msgs[0]);
		mysql_select_db("cabos_bd",$conexao) or die($msgs[1]); // nome do banco de dados
		mysql_set_charset('utf8');

		//$conexao = mysqli_connect('bdhost0036.servidorwebfacil.com', 'cabos_user', 'fg15975300', 'cabos_bd');
		//$conexao = new PDO("mysql:host=bdhost0036.servidorwebfacil.com;dbname=cabos_bd", "cabos_user", "fg15975300"); 
	
// Ajusta hora do servidor
date_default_timezone_set('America/Sao_Paulo');		

$dthoje_eua=date("Y-m-d",strtotime("now"));
$dthoje_bra=date("d/m/Y",strtotime("now"));
$dtpesquisa=date("Ymd",strtotime("now"));
$horasistema=date('H');


// Busca o codigo e o nome da loja (fica disponivel em: $cdloja e $nome_loja)
$raiz_site=$_SERVER['DOCUMENT_ROOT'];

$ponteiro = fopen ($raiz_site."/loja.txt", "r");
while (!feof ($ponteiro)) {
  $linha = fgets($ponteiro, 4096);
  $cdloja=$linha;
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


$query="SELECT nomeloja, index_description, index_keywords FROM lojas WHERE cdloja='".$cdloja."'";
$resultado = mysql_query($query,$conexao);
$nomeloja=mysql_result($resultado,0,0);
$index_description=mysql_result($resultado,0,1);
$index_keywords=mysql_result($resultado,0,2);
?>