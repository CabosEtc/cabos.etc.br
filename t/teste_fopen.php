<?php
// Cód. retirada do proprio manual do PHP
$handle = fopen ("https://www.boadica.com.br/produtos/p72290", "rb");
$xhtml  = "";
do {
 $data = fread($handle, 8192);
 if (strlen($data) == 0) { echo "falhou"; break;}
 $xhtml .= $data;
} while(true);
fclose($handle);

echo $xhtml;
?>