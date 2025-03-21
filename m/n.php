
<html>
  <head>
    <title>Vendas</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link href="manutencao.css" rel="stylesheet" type="text/css" />
  </head>


  <body>

    <?php 
      //Prepara conexao ao db
      include("../conectadb.php");

      // Inicializa a sessão
      include("msession.php");
      IF(!$logado){	
        echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
      } 
      //echo "Nível de Usuario: $nivelusuario<br>";
      include("mmenu.php");
    ?>

    <script type="text/javascript"src="ajaxInit.js"></script>
    <script type="text/javascript">
        function consulta(){
            // Implementar este função futuramente, está com erros e não permite avaliar preços, melhor usar a lupa mesmo
            var cdproduto=document.getElementById("cdproduto1").value;
            //alert(cdproduto);

            /*
            ajax=ajaxInit();
            //document.getElementById("discriminacao1").value="Ol�";

            var url="produtos_consulta_ajax.php";
            url=url+"?cdproduto="+cdproduto;
            //var url="montaxml.php";

            if(ajax){
                ajax.open('GET',url,true);
                ajax.onreadystatechange=function(){

                if(ajax.readyState==4) {
                    if(ajax.status==200) {
                        //document.getElementById("discriminacao1").value=ajax.responseText ;

                        var xmlDoc = ajax.responseXML;
                        var i, n_elems, elems = xmlDoc.getElementsByTagName("nome"); 
                        //alert(elems);

                        n_elems = elems.length; 
                        for (i = 0; i < n_elems; i++) 
                        //   alert("nome ="+elems[i].firstChild.nodeValue + "<br>");
                        document.getElementById("discriminacao1").value=elems[i].firstChild.nodeValue;

                        var i, n_elems, elems = xmlDoc.getElementsByTagName("valor"); 
                        n_elems = elems.length; 
                        for (i = 0; i < n_elems; i++) 
                        //   alert("pac ="+elems[i].firstChild.nodeValue + "<br>");
                        document.getElementById("vlunitario1").value=elems[i].firstChild.nodeValue;
                    }
                }
                //} Sobrando???
            }
            
            ajax.send(null);
            */
        }

        function pesquisarProduto(idproduto){
            let quantidadeProduto=document.getElementById('quant'+idproduto).value
            if(quantidadeProduto==""){
                quantidadeProduto=1;
            }
            window.open('pesquisar_produto.php?iditem='+idproduto+'&quantidade='+quantidadeProduto+'','popup','resizable=no,status=no,scrollbars=no,width=900,height=600,top='+(window.innerHeight-600)/2+',left='+(window.innerWidth-900)/2+'');
            //alert(idproduto);
        }

        //--------------------------------------------------------------------------

        function consulta2(){
            // Implementar este função futuramente, está com erros e não permite avaliar preços, melhor usar a lupa mesmo
            //	alert(campo);
            var cdproduto=document.getElementById("cdproduto2").value;

            /*
            ajax=ajaxInit();
            //document.getElementById("discriminacao1").value="Ol�";

            var url="produtos_consulta_ajax.php";
            url=url+"?cdproduto="+cdproduto;
            //var url="montaxml.php";

            if(ajax){
                ajax.open('GET',url,true);
                ajax.onreadystatechange=function(){

                if(ajax.readyState==4) {
                    if(ajax.status==200) {

                        //document.getElementById("discriminacao1").value=ajax.responseText ;

                        var xmlDoc = ajax.responseXML;

                        var i, n_elems, elems = xmlDoc.getElementsByTagName("nome"); 
                        n_elems = elems.length; 
                        for (i = 0; i < n_elems; i++) 
                        //   alert("sedex ="+elems[i].firstChild.nodeValue + "<br>");
                        document.getElementById("discriminacao2").value=elems[i].firstChild.nodeValue;

                        var i, n_elems, elems = xmlDoc.getElementsByTagName("valor"); 
                        n_elems = elems.length; 
                        for (i = 0; i < n_elems; i++) 
                        //   alert("pac ="+elems[i].firstChild.nodeValue + "<br>");
                        document.getElementById("vlunitario2").value=elems[i].firstChild.nodeValue;
                    }
                } 
                // } Sobrando??
            } 
            
            ajax.send(null);

            */
        }
    </script>

    <script language="Javascript" type="text/javascript"> 

        function putData(codigo,nome,valor) {  
            var codigo = codigo;
            var nome = nome;
            var valor = valor;
            
            if (codigo!= ""){
            document.getElementById('quant1').value = 1;  
            document.getElementById('cdproduto1').value = codigo;  
            document.getElementById('discriminacao1').value = nome;  
            document.getElementById('vlunitario1').value = valor;
            document.getElementById('vlunitario1').focus();  
            }
        }  
    </script>

    <script language="Javascript">
        function valida(){
            var cdCliente = document.form_venda.cdCliente.value
            //alert(typeof cdCliente)
            /*
            if (cdCliente=="0"){
                alert("É necessário identificar o cliente, use a lupa para localizar/cadastrar");
                document.form_venda.quant1.focus()
                return false
            }
            */    

            var quant1 = document.form_venda.quant1.value
            var cdproduto1 = document.form_venda.cdproduto1.value

            if (quant1=="" && !(cdproduto1=="")){
                alert("É necessário preencher a quantidade de produtos do primeiro campo!");
                document.form_venda.quant1.focus()
                return false
            }

            var quant2 = document.form_venda.quant2.value
            var cdproduto2 = document.form_venda.cdproduto2.value

            if (quant2=="" && !(cdproduto2=="")){
                alert("É necessário preencher a quantidade de produtos do segundo campo!");
                document.form_venda.quant2.focus()
                return false
            }

            var quant3 = document.form_venda.quant3.value
            var cdproduto3 = document.form_venda.cdproduto3.value

            if (quant3=="" && !(cdproduto3=="")){
                alert("É necessário preencher a quantidade de produtos do terceiro campo!");
                document.form_venda.quant3.focus()
                return false
            }

            var quant4 = document.form_venda.quant4.value
            var cdproduto4 = document.form_venda.cdproduto4.value

            if (quant4=="" && !(cdproduto4=="")){
                alert("É necessário preencher a quantidade de produtos do quarto campo!");
                document.form_venda.quant4.focus()
                return false
            }

            var quant5 = document.form_venda.quant5.value
            var cdproduto5 = document.form_venda.cdproduto5.value

            if (quant5=="" && !(cdproduto5=="")){
                alert("É necessário preencher a quantidade de produtos do quinto campo!");
                document.form_venda.quant5.focus()
                return false
            }

            var quant6 = document.form_venda.quant6.value
            var cdproduto6 = document.form_venda.cdproduto6.value

            if (quant6=="" && !(cdproduto6=="")){
                alert("É necessário preencher a quantidade de produtos do sexto campo!");
                document.form_venda.quant6.focus()
                return false
            }

            var quant7 = document.form_venda.quant7.value
            var cdproduto7 = document.form_venda.cdproduto7.value

            if (quant7=="" && !(cdproduto7=="")){
                alert("É necessário preencher a quantidade de produtos do setimo campo!");
                document.form_venda.quant7.focus()
                return false
            }

            var quant8 = document.form_venda.quant8.value
            var cdproduto8 = document.form_venda.cdproduto8.value

            if (quant8=="" && !(cdproduto8=="")){
                alert("É necessário preencher a quantidade de produtos do oitavo campo!");
                document.form_venda.quant8.focus()
                return false
            }

            var quant9 = document.form_venda.quant9.value
            var cdproduto9 = document.form_venda.cdproduto9.value

            if (quant9=="" && !(cdproduto9=="")){
                alert("É necessário preencher a quantidade de produtos do nono campo!");
                document.form_venda.quant9.focus()
                return false
            }

            var quant10 = document.form_venda.quant10.value
            var cdproduto10 = document.form_venda.cdproduto10.value

            if (quant10=="" && !(cdproduto10=="")){
                alert("É necessário preencher a quantidade de produtos do decimo campo!");
                document.form_venda.quant10.focus()
                return false
            }

        }
        //-->
    </script>

    <?

        $vendedor=$_REQUEST["user"];// codigo do vendedor


        $query="SELECT parametros.nrnota, parametros.dtnota, lojas.nomeloja 
                FROM parametros, lojas  
                WHERE parametros.cdloja='$cdloja' 
                AND lojas.cdloja='$cdloja'";
        //echo "query para buscar numero da nota $query";
        $resultado = mysql_query($query,$conexao);
        $nr_ultima_nota=mysql_result($resultado,0,0);
        $dtnota=mysql_result($resultado,0,1);
        $dtnota=substr($dtnota,8,2)."/".substr($dtnota,5,2)."/".substr($dtnota,0,4);
        if ($dtnota=="00/00/0000"){
            $dtnota=date("d/m/Y",strtotime("now"));
            }
        $abreviacao2Loja1=mysql_result($resultado,0,2);



        //include("../manutencao/menu.php");

        $hoje= $dtnota;
        //$hoje="16/08/2010"; 
        //$hoje= date("d/m/Y",strtotime("now")); 

    ?>
        
    <div style='margin-top:0px;'>
        &nbsp
    </div>  

        <form id="form_venda" name="form_venda" method="post" action="nprev.php" onsubmit="return valida();">
            <div class="container mx-auto bg-warning">
                <div class="row">
                    <div class="col-6">
                        Loja: <? echo "$abreviacao2Loja1"; ?>
                    </div>
                    <div class="col-6">
                        N&ordm; 
                        <input name='nrnota' type='text' id='nrnota' maxlength='6' <?php echo("value='".(substr(1000000+$nr_ultima_nota,1,6))."'"); ?> />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-3">Data de emiss&atilde;o: 
                        
                        <input type="text" name="dtnota" id="dtnota"  <? if($nivelusuario<=3){echo "readonly='true'";}?> size="10" maxlength='10' <? echo("value='".$hoje."'") ?>/>
                    </div>
                    <div class="col-3">Garantia
                        <select name="garantia" id="garantia">
                            <option value='7'>7 dias</option>
                            <option value='15'>15 dias</option>
                            <option value='90' selected>90 dias</option>
                            <option value='180'>180 dias</option>
                            <option value='365'>1 ano</option>
                        </select>
                        <!--
                        <input name="garantia" type="radio" id="3m2" value="7" />7D 
                        <input name="garantia" type="radio" id="3m4" value="15" />15D 
                        <input name="garantia" type="radio" id="3m5" value="90" checked="checked" />3M 
                        <input type="radio" name="garantia" id="3m" value="180" />6M 
                        <input type="radio" name="garantia" id="3m3" value="360" />1A
                        --> 
                    </div>


                </div>
                
                <div class="row">

                    <div class="col-3">Vendedor 
 
                        <select name="idusuario" id="idusuario">
                            <?
                            $query="SELECT idusuario, nomeusuario 
                                    FROM usuarios 
                                    WHERE cdloja='".$cdloja."' AND status=1 
                                    ORDER BY usuario" ;
                            $resultado = mysql_query($query,$conexao);
                                while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
                                $idUsuarioLoja=$row[0]; 
                                $nomeusuario=$row[1]; // descricao
                                IF($idusuario==$idUsuarioLoja){ // Se o id do usuario da sessao for igual ao idUsuarioLoja na tabela
                                    echo("<option value='".$idUsuarioLoja."' selected>".$nomeusuario."</option>");
                                }

                                ELSE{
                                    echo("<option value='".$idUsuarioLoja."'>".$nomeusuario."</option>");
                                }
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-3"><label>
                        Origem
                        </label>
                        <select name="cdorigem" id="cdorigem">
                        <option value="0">Balcão</option>
                        <option selected="selected" value="1">Boadica</option>
                        <option value="2">Instagram</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label>
                            Cliente
                        </label>
                        <a href="#" onclick="window.open('pesquisar_cliente.php','popup','resizable=no,status=no,scrollbars=no,width=900,height=600,top='+(window.innerHeight-600)/2+',left='+(window.innerWidth-900)/2+'')">
                            <img src="../imagens/lupa.png" alt="" />
                        </a>
                        <label id="nomeCliente" name="nomeCliente">
                            Não identificado
                        </label>
                        <span>
                            <input name="cdCliente" type="text" id="cdCliente" size="10" maxlength="7" readonly="readonly" value='0' />
                        </span>
                    </div>
                </div>
            </div>
            

            <table width="960" border="0" align="center">
                <tr>
                    <td width="50">Quant</td>
                    <td width="150">C&oacute;digo</td>
                    <td width="400">Discrimina&ccedil;&atilde;o do produto (n&atilde;o edit&aacute;vel)</td>
                    <td>Pre&ccedil;o Unitario</td>
                </tr>
                
                <tr>
                    <td><input name="quant1" type="text" id="quant1" size="5" maxlength="4" /></td>
                    <td>
                        <input name="cdproduto1" type="text" id="cdproduto1" size="10" maxlength="5" onblur="consulta(this);"/>
                        <a href="#" onclick="pesquisarProduto(1);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td><input name="discriminacao1" type="text" id="discriminacao1" size="70" maxlength="6" disabled="disabled" /></td> 
                    <td><input name="vlunitario1" type="text" id="vlunitario1" size="15" maxlength="7" /></td>
                </tr>
                
                <tr>
                    <td>
                        <input name="quant2" type="text" id="quant2" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto2" type="text" id="cdproduto2" size="10" maxlength="5" onblur="consulta2(this);" />
                        <a href="#" onclick="pesquisarProduto(2);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao2" type="text" id="discriminacao2" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario2" type="text" id="vlunitario2" size="15" maxlength="7" />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input name="quant3" type="text" id="quant3" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto3" type="text" id="cdproduto3" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(3);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao3" type="text" id="discriminacao3" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario3" type="text" id="vlunitario3" size="15" maxlength="7" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="quant4" type="text" id="quant4" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto4" type="text" id="cdproduto4" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(4);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao4" type="text" id="discriminacao4" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario4" type="text" id="vlunitario4" size="15" maxlength="7" />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input name="quant5" type="text" id="quant5" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto5" type="text" id="cdproduto5" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(5);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao5" type="text" id="discriminacao5" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario5" type="text" id="vlunitario5" size="15" maxlength="7" />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input name="quant6" type="text" id="quant6" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto6" type="text" id="cdproduto6" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(6);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao6" type="text" id="discriminacao6" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario6" type="text" id="vlunitario6" size="15" maxlength="7" />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input name="quant7" type="text" id="quant7" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto7" type="text" id="cdproduto7" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(7);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao7" type="text" id="discriminacao7" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario7" type="text" id="vlunitario7" size="15" maxlength="7" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <input name="quant8" type="text" id="quant8" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto8" type="text" id="cdproduto8" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(8);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao8" type="text" id="discriminacao8" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario8" type="text" id="vlunitario8" size="15" maxlength="7" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="quant9" type="text" id="quant9" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto9" type="text" id="cdproduto9" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(9);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao9" type="text" id="discriminacao9" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario9" type="text" id="vlunitario9" size="15" maxlength="7" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <input name="quant10" type="text" id="quant10" size="5" maxlength="4" />
                    </td>
                    <td>
                        <input name="cdproduto10" type="text" id="cdproduto10" size="10" maxlength="5" />
                        <a href="#" onclick="pesquisarProduto(10);"><img src="../imagens/lupa.png" alt="" /></a>
                    </td>
                    <td>
                        <input name="discriminacao10" type="text" id="discriminacao10" size="70" maxlength="6"  disabled="disabled" />
                    </td>
                    <td>
                        <input name="vlunitario10" type="text" id="vlunitario10" size="15" maxlength="7" />
                    </td>
                </tr>

                <tr>
                    <td colspan='2'>
                        Atalho (Só o primeiro campo)
                    </td>
                    <td align="right">
                        Desconto
                    </td>
                    <td>
                        <input name="desconto" type="text" id="desconto" size="15" maxlength="7" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="cdloja" type="hidden" id="cdloja" <? echo "value=".$cdloja; ?> />
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <label>
                            <input type="submit" name="Incluir" id="Incluir" value="Incluir" />
                        </label>
                    </td>
                </tr>
                
                <tr>
                <td colspan="4">
                    &nbsp;
                </td>
                </tr>
            </table>
          
          
          
    <?
          
        $query2="   SELECT favoritos.cdproduto,produtos.nome,precos.vlvenda 
                    FROM favoritos, produtos, precos 
                    WHERE produtos.cdproduto=precos.cdproduto 
                    AND favoritos.cdproduto=produtos.cdproduto 
                    AND favoritos.cdloja='$cdloja'  
                    AND precos.cdloja='$cdloja' 
                    ORDER BY favoritos.idfavorito";
        //echo $query2;
        $resultado2 = mysql_query($query2,$conexao);
        
        $cdproduto1=mysql_result($resultado2,0,0);
        $cdproduto2=mysql_result($resultado2,1,0);
        $cdproduto3=mysql_result($resultado2,2,0);
        $cdproduto4=mysql_result($resultado2,3,0);
        $cdproduto5=mysql_result($resultado2,4,0);
        $cdproduto6=mysql_result($resultado2,5,0);
        $cdproduto7=mysql_result($resultado2,6,0);
        $cdproduto8=mysql_result($resultado2,7,0);
        $cdproduto9=mysql_result($resultado2,8,0);
        $cdproduto10=mysql_result($resultado2,9,0);
        $cdproduto11=mysql_result($resultado2,10,0);
        $cdproduto12=mysql_result($resultado2,11,0);
        $cdproduto13=mysql_result($resultado2,12,0);
        $cdproduto14=mysql_result($resultado2,13,0);
        $cdproduto15=mysql_result($resultado2,14,0);
        $cdproduto16=mysql_result($resultado2,15,0);
        
        $nomeproduto1=mysql_result($resultado2,0,1);
        $nomeproduto2=mysql_result($resultado2,1,1);
        $nomeproduto3=mysql_result($resultado2,2,1);
        $nomeproduto4=mysql_result($resultado2,3,1);
        $nomeproduto5=mysql_result($resultado2,4,1);
        $nomeproduto6=mysql_result($resultado2,5,1);
        $nomeproduto7=mysql_result($resultado2,6,1);
        $nomeproduto8=mysql_result($resultado2,7,1);
        $nomeproduto9=mysql_result($resultado2,8,1);
        $nomeproduto10=mysql_result($resultado2,9,1);
        $nomeproduto11=mysql_result($resultado2,10,1);
        $nomeproduto12=mysql_result($resultado2,11,1);
        $nomeproduto13=mysql_result($resultado2,12,1);
        $nomeproduto14=mysql_result($resultado2,13,1);
        $nomeproduto15=mysql_result($resultado2,14,1);
        $nomeproduto16=mysql_result($resultado2,15,1);
        
        $vlvenda1=mysql_result($resultado2,0,2);
        $vlvenda2=mysql_result($resultado2,1,2);
        $vlvenda3=mysql_result($resultado2,2,2);
        $vlvenda4=mysql_result($resultado2,3,2);
        $vlvenda5=mysql_result($resultado2,4,2);
        $vlvenda6=mysql_result($resultado2,5,2);
        $vlvenda7=mysql_result($resultado2,6,2);
        $vlvenda8=mysql_result($resultado2,7,2);
        $vlvenda9=mysql_result($resultado2,8,2);
        $vlvenda10=mysql_result($resultado2,9,2);
        $vlvenda11=mysql_result($resultado2,10,2);
        $vlvenda12=mysql_result($resultado2,11,2);
        $vlvenda13=mysql_result($resultado2,12,2);
        $vlvenda14=mysql_result($resultado2,13,2);
        $vlvenda15=mysql_result($resultado2,14,2);
        $vlvenda16=mysql_result($resultado2,15,2);
        
        echo "<table width='960' border='0' align='center'>";
        echo "<tr>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto1.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto1."','".$nomeproduto1."','".$vlvenda1."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto2.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto2."','".$nomeproduto2."','".$vlvenda2."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto3.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto3."','".$nomeproduto3."','".$vlvenda3."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto4.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto4."','".$nomeproduto4."','".$vlvenda4."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto5.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto5."','".$nomeproduto5."','".$vlvenda5."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto6.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto6."','".$nomeproduto6."','".$vlvenda6."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto7.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto7."','".$nomeproduto7."','".$vlvenda7."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto8.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto8."','".$nomeproduto8."','".$vlvenda8."')\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto1."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto2."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto3."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto4."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto5."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto6."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto7."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto8."</font></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto9.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto9."','".$nomeproduto9."','".$vlvenda9."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto10.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto10."','".$nomeproduto10."','".$vlvenda10."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto11.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto11."','".$nomeproduto11."','".$vlvenda11."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto12.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto12."','".$nomeproduto12."','".$vlvenda12."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto13.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto13."','".$nomeproduto13."','".$vlvenda13."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto14.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto14."','".$nomeproduto14."','".$vlvenda14."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto15.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto15."','".$nomeproduto15."','".$vlvenda15."')\"></td>";
        echo "<td width='100' align='center' valign='middle'><img src='http://www.cabos.etc.br/imagens/produtos/".$cdproduto16.".jpg' width='75' height='75' onclick=\"putData('".$cdproduto16."','".$nomeproduto16."','".$vlvenda16."')\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto9."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto10."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto11."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto12."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto13."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto14."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto15."</font></td>";
        echo "<td height='21' align='center'><font size='0.5'>".$nomeproduto16."</font></td>";
        echo "</tr>";
        echo "</table>";
    ?>
      

    <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>
  </body>
</html>
