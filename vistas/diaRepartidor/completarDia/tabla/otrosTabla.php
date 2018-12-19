
<?php

function getNV($idVendedor){return "v" . $idVendedor;}
function getNVNF($idVendedor,$fila){return getNV($idVendedor) . "f" . $fila;}
function getNC($col){return "c" . $col;}
function getNVNFNC($idVendedor,$fila,$col){return getNVNF($idVendedor,$fila) . getNC($col);}
function getId($idVendedor,$fila,$col){return "id=" . getNVNFNC($idVendedor,$fila,$col);}
function getName($idVendedor,$fila,$col){return "name=" . getNVNFNC($idVendedor,$fila,$col);}
function getIdName($idVendedor,$fila,$col){return getId($idVendedor,$fila,$col) . " " . getName($idVendedor,$fila,$col);}


function getValueColumna($valor)
{
if($valor > 0)
  return " value=".$valor;
else
  return "";
}


?>
