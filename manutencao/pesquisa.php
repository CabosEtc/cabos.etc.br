<!DOCTYPE html>
<html>

<!--Tabela de cores-->
<!-- https://celke.com.br/artigo/tabela-de-cores-html-nome-hexadecimal-rgb -->

<head>
    <title>3DCon</title>
    <link rel="stylesheet" type="text/css" href="3dcon.css">
</head>
<body>
<?
//Prepara conexao ao db
include("../conectadb.php");

$busca=$_REQUEST["busca"];
if ($busca<>""){
$query="SELECT produtos.cdproduto, produtos.nome FROM produtos WHERE produtos.nome LIKE '%".$busca."%' ORDER BY nome";
//echo $query;
$resultado = mysql_query($query,$conexao);
}
?>
<div id="site">
    <div id="cabecalho"  class="cabecalho">Oi aqui entra um texto de teste...
       
        <!-- aqui colocaremos a logo -->
        <div id='logo' class='logo'><a href="../manutencao/3dcon.php"><img src='../imagens/3dcon.png' width='250' height='125'/></a></div>
    </div>    
    
    <div id="menu_principal" class="menu_principal"'>
        <div id="pesquisar" class="pesquisar"><form id='form_pesquisa' name='form_pesquisa' method='get' action='../manutencao/pesquisa.php'> Pesquisar 
<input name='busca' type='text' id='busca' size='60' maxlength='60' /><input type='submit' name='Ok' id='Ok' value='Ok' /></form></div>
    </div>
    
        <div id="conteudo_principal" class="conteudo_principal">
            <?
            while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$cdproduto=$row[0]; 
			$nome=$row[1];
            ECHO "<a href='../manutencao/produto.php?cd=$cdproduto' target=_blank>$cdproduto</a> - $nome<br>";
            }
            ?>
            
        </div> <!-- Fim da div conteudo_principal -->
        
    <div id="conteudo_secundario" class="conteudo_secundario">
        <div>
        <div id="1" class="I1"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/hub.webp" widht="200" height="200"/>
        </a><div style="text-align: center">Hub Usb 3.0 4 portas</div>
        </div>
        
        <div id="2" class="I2"><a href="../manutencao/produto.php?cd=10047"><img  class="imagem_centralizada" src="../imagens/fonte.webp" widht="200" height="200" /></a>
        <div style="text-align: center">Fonte HP 19V 3.16A</div>
        </div>
        
        <div id="3" class="I3"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/rede.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Placa de rede PCI</div>
        </div>
        
        <div id="4" class="I4"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/sata.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Adaptador SATA Usb 3.0</div>
        </div>
        
        <div id="5" class="I5"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/alicate.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Alicate de rede c/ catraca</div>
        </div>
        </div>
        
        <!--Segundo grupo -->
        
        <div>
        <div id="1" class="I1"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/impressora.webp" widht="200" height="200"/>
        </a><div style="text-align: center">Cabo de Impressora Usb 2.0</div>
        </div>
        
        <div id="2" class="I2"><a href="../manutencao/produto.php?cd=10047"><img  class="imagem_centralizada" src="../imagens/sataide.webp" widht="200" height="200" /></a>
        <div style="text-align: center">Adaptador USB Sata/Ide</div>
        </div>
        
        <div id="3" class="I3"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/extensao.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Extensao Usb Ativa</div>
        </div>
        
        <div id="4" class="I4"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/hdmi.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Cabo Hdmi</div>
        </div>
        
        <div id="5" class="I5"><a href="../manutencao/produto.php?cd=10047">
        <img  class="imagem_centralizada" src="../imagens/hdmidvi.webp" widht="200" height="200"/></a>
        <div style="text-align: center">Cabo Hdmi x Dvi</div>
        </div>
        </div>
        
        
    </div> <!-- Fim da div secundario -->
        
    <div id="rodape" class="rodape">
        <div style="padding: 5px">L1</div>
        <div style="padding: 5px">L2</div>
        <div  style="padding: 5px" id="endereco" class="endereco">CNPJ n.º 03.007.331/0001-41 / Av. das Nações Unidas, nº 3.003, Bonfim, Osasco/SP - CEP 06233-903 - empresa do grupo Mercado Livre.</div>
    </div>
    
</div> <!--fim da div site -->
</body>
</html>