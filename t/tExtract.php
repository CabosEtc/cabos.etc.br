<?

$id=$_REQUEST["id"];

$ret="{\"statusloja1\":1, \"statusloja2\":0,
\"flagloja1\":0,\"flagloja2\":1,
\"produto\":\"Cabo VGA x VGA 1,5m\",
\"marca\":\"N/D\",
\"idproduto\":\"1360\",
\"bd\":[
{\"loja\":\"Loja ".$id."---\",\"preco\":24.96,\"rank\":1,\"idloja\":85},
{\"loja\":\"Super Games\",\"preco\":24.90,\"rank\":1,\"idloja\":85},
{\"loja\":\"Supernova\",\"preco\":84.50,\"rank\":1,\"idloja\":85}]}";
echo $ret;
?>