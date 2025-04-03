<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="manutencao.css">
    <title>BDCategorias</title>
  </head>
  
  <body>
    <?

      //Prepara conexao ao db
      include("../conectadb.php");

      // Inicializa a sessão
      include("msession.php");
      IF(!$logado){	
        echo "<meta http-equiv='refresh' content='0; url=index.php' target='_SELF'>";
      } 
      //echo $nivelusuario;

      //Recebe variaveis
      $loja=$_REQUEST["loja"];

      //Inclui o menu
      include("mmenu.php");   

      $query="SELECT nomeloja 
              FROM lojas 
              WHERE cdloja='".$cdloja."'";
      $resultado = mysql_query($query,$conexao);
      $nomeloja=mysql_result($resultado,0,0);

      $dthoje_eua=date("Y-m-d",strtotime("now"));
      $dtpesquisa=date("Ymd",strtotime("now"));

      echo "<br>";
      echo "<table><tr><td><h3>Pesquisa rapida por Categorias</h3></td></tr></table>";





      $query="SELECT `bd_linkcategoria`.`id`,`bd_linkcategoria`.`link`,`bd_linkcategoria`.`descricao`   
              FROM  `bd_linkcategoria` 
              WHERE cdloja=$cdLoja 
              ORDER BY `bd_linkcategoria`.`id`";
      //echo "$query<br>";
      $resultado = mysql_query($query,$conexao);

      echo "<table>";
      echo "<tr>
              <td>Id</td>
              <td>BD</td>
              <td>Descricao</td>
            </tr>";


      while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
        $id=$row[0]; 
        $link=$row[1];
        $descricao=$row[2];
        
            echo "  <tr>
                      <td>$id</td>
                      <td><a href='$link' target='_blank'><img src='../imagens/coruja.png' /></a></td>
                      <td>$descricao</td>
                    </tr>";
      } // Fim da linha de exibicao do produto
        echo "</table>";
    ?>



  </body>
</html>


