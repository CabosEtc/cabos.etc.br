<?php 
  	// Inicializa a sessão
	include("msession.php");
	IF(!$logado){	
		echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
	} 
	//echo $nivelusuario;
?>
<html>
<head>
    <title>eInc</title>
  <meta http-equiv= "Content-Type" content= "text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="manutencao.css">
</head>
<style>
  .alerta{
    display: none;
  }
</style>
<script type="text/javascript" src="js/ajax2020.js"></script>

<body class="body">

<?php
//Prepara conexao ao db
include("../conectadb.php");

//Recebe variaveis * $cdloja vem do conectadb 1=cabos 8=supergames
$token=$_REQUEST["token"];
$depuracao=$_REQUEST["depuracao"];
$modo=$_REQUEST["modo"];
$cdproduto=$_REQUEST["cdproduto"];
//$hoje=date("d/m/Y",strtotime("now")); 

// Mostra depuracao
//include("depuracao.php"); 
?> 

<!-- Envoltorio -->
<div id="wrapper" class="wrapper">


    
<!-- Inclui o menu -->
<? include("mmenu.php"); ?>    

<!-- Conteudo principal -->
<div id="corpo" class="corpo">






<div id="containerAlerta" class="container alerta mt-2">
  <div class="row">
      <div class="col-12">
          <div id="alerta" class="alert alert-success" role="alert">
              Mensagem aqui...
          </div>
      </div>
  </div>
</div>

<div>
  <h3 style="margin-top: 30px;">  
    Inclusão de produtos no estoque
  </h3>
</div>   
<div id="divNomeProduto">
  &nbsp
</div>

<form action="erot.php" method="get">
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Data da entrada</td>
      <td><input name="dtentrada" type="text" id="dtentrada" maxlength="10" <? echo "value='$dthoje_bra'";?> ></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Codigo do Produto</td>
      <td>
        <input name="cdproduto" type="text" id="cdproduto" maxlength="5" value="<? echo $cdproduto;?>" 
          onblur="pesquisarProduto();"/>
          <a href="#" onclick="window.open('estoque_pesquisar_produto.php','popup','resizable=no,status=no,scrollbars=no,width=500,height=400,top=30,left=20')"><img src="../imagens/lupa.png" alt="" /></a>
      </td>
      <td>
        <img src="http://www.cabos.etc.br/imagens/produtos/00000.jpg" name="imagem_produto" width="150" height="150" id="imagem_produto" />
      </td>
    </tr>
	
    <tr>
      <td>
        Fornecedor
      </td>
      <td><select name="fornecedor">
		  <? $query="SELECT fornecedor.id, fornecedor.apelido FROM `fornecedor`  ORDER BY apelido";
      $resultado = mysql_query($query,$conexao);

      while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
        $idfornecedor=$row[0];
        $apelido=$row[1];
        ECHO "<option value='$idfornecedor'>$apelido</option> ";
      }
          ?>
  
      </select></td>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>Quantidade</td>
      <td><input name="quantidade" type="text" id="quantidade" maxlength="5" value="0"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Valor individual</td>
      <td><input name="valor" type="text" id="valor" maxlength="10"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>Link</td>
      <td><input name="link" type="text" id="link" maxlength="512" size="40"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td><input name="modo" type="hidden" id="modo" value="incluir_manual" />      <input type="submit" name="Enviar" id="Enviar" value="Submit" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>









  


<!-- Fim da div conteudo_principal -->
   </div>


</div> <!--fim da div wrapper -->



<script>
// Funcao para buscar o conteudo da pagina via ajax 
function makerequest(cdproduto){
  let pagina="http://www.cabos.etc.br/m/BDRotinasAjax.php?modo=buscarInclusoesEstoque&cdproduto="+cdproduto;
  let divAlerta=document.getElementById("alerta");
  
  //alert(`Loja: ${idloja}`);
  //let conteudo='<table class="table table-striped table-hover table-sm"><thead class="thead-dark"><tr><th>Id</th><th>Produto</th><th>Valor</th><th>ativo</th><th>Nada</th></tr></thead>';
  //alert("Passei pela rotina makerequest");
  console.log("passei aqui no makerequest");
  //alert(pagina); 	 
   
  var async = true;
   xmlhttp.open("GET", pagina, async);
   //alert(xmlhttp.status);
 xmlhttp.onreadystatechange=function(){
      console.log(xmlhttp.status);
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
     //var objeto=JSON.parse(xmlhttp.responseText);
     console.log(xmlhttp.responseText);
     /*
     for(var i=0;i<objeto.dados.length;i++){
                  id=objeto.dados[i].id;
                  idloja=objeto.dados[i].idloja;
                  idlinkbd=objeto.dados[i].idlinkbd;
                  idanunciobd=objeto.dados[i].idanunciobd;
                  valor=objeto.dados[i].valor;
                  nomeProduto=objeto.dados[i].nomeproduto;
                  flagativar=objeto.dados[i].flagativar;
                  conteudo=`${conteudo}<tr><td><a href='http://cabos.etc.br/m/BDPrecos.php?inicio_id=${idlinkbd}&limite=1' target='_blank'><span name='idProduto'>${idlinkbd}</span></a></td><td>${nomeProduto}</td>`;
                  conteudo=`${conteudo}<td><input type="text" name="valor" value="${valor}" data-id="${idanunciobd}" size="6" max-length="6" ></td>`
                  conteudo=`${conteudo}<td><label name='ativar'>${flagativar}</label></td><td><input type="checkbox" name="selecao" data-id="${idanunciobd}" value="1" checked=""></td></tr>`;
                  //alert(conteudo);
              }
    */
              
              divAlerta.innerHTML=xmlhttp.responseText;		
   }
 }
 xmlhttp.send(null);
 //document.getElementById("btnEnviar").style.display="block";
 //alert(xmlhttp.status);
 //return "oieeeeee";

}
</script>



<script>
  function pesquisarProduto(){
    varCdProduto=document.getElementById("cdproduto").value;
    varContainerAlerta=document.getElementById("containerAlerta");
    varContainerAlerta.style.display="block";
    varfonte_imagem="http://www.cabos.etc.br/imagens/produtos//"+varCdProduto+".jpg";
    //alert(varfonte_imagem);	
    document.getElementById("imagem_produto").src=varfonte_imagem;
    
    // Busca ultima alteração de valor
    makerequest(varCdProduto);
}
</script>


</body>
</html>