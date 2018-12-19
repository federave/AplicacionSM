

<?php
//$indice
//$item
//$divOculto
//$nombreClick
//$eliminar
//$id
?>



<div class="borde cointainer" style="margin-top:20px" id=<?php echo "div".$nombreClick.$indice;?>>
  <div class="text-center" style="margin-top:10px">
    <button class="btn-link buttonLink" onclick="itemClick<?php echo $nombreClick;?>(<?php echo $indice;?>)">
      <h4><?php echo $item->getTitulo();?></h4>
    </button>
  </div>
  <div class="text-center" style="margin-top:10px;margin-bottom:15px">
    <?php echo $item->getDescripcion();?>
  </div>
  <div class="text-center" id="<?php echo $divOculto; ?>" name="<?php echo $divOculto; ?>" style="display:none;margin-top:10px;margin-bottom:10px">
    <?php echo $item->getDescripcionOculta();?>
  </div>

    <?php if($eliminar){ ?>

      <div class="text-center" style="margin-top:10px">
        <button class="btn-link buttonLink" onclick="eliminar<?php echo $nombreClick;?>(<?php echo $indice;?>)">
          <h4 style="color:rgb(157, 1, 1)">Eliminar</h4>
        </button>
      </div>

    <?php } ?>

    <input type="hidden" id=<?php echo "id". $nombreClick . $indice;?> value=<?php echo $id ?>>


</div>
