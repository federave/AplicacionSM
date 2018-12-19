

<?php
//$ancho
//$alto
// function itemClick($indice){}
//$items
//$nombre
//$nombreClick

?>
<link rel="stylesheet" href="../css/general.css">


<div id="<?php echo 'lista'.$nombre;?>" class="borde" style="overflow-y:auto;padding:50px;padding-top:20px;padding-bottom: 20px;width:<?php echo $ancho .'px';?>;height:<?php echo $alto .'px';?>;" >

    <?php

      $k=0;
      while($k<$items->getSize())
        {
        $indice=$k;
        $item = $items->getItem($k);
        $id = $item->getId();
        $divOculto = $nombre . $k;
        require 'elementoLista.php';
        $k++;
        }

    ?>

    <input type="hidden" id="<?php echo 'lista'. $nombre . 'tamaño'; ?>" value=<?php echo $k; ?> >


</div>
