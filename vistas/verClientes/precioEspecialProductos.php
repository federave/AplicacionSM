
          <?php
          $precioProductos = $cliente->getPrecioProductos();

          if($precioProductos->getPrecioEspecial()) {  ?>


            <div class="column" style="width:25%;margin-left:5%;">

              <h3 class="subtitulo" style="margin-bottom:30px;">Precio Especial Productos</h3>

              <p style="margin-top:5px;font-size:20px;">Bidon 20L: <?php echo $precioProductos->getPrecioRetornables()->getBidon20L();?></p>
              <p style="margin-top:5px;font-size:20px;">Bidon 12L: <?php echo $precioProductos->getPrecioRetornables()->getBidon12L();?></p>
              <p style="margin-top:5px;font-size:20px;">Bidon 10L: <?php echo $precioProductos->getPrecioDescartables()->getBidon10L();?></p>
              <p style="margin-top:5px;font-size:20px;">Bidon 8L: <?php echo $precioProductos->getPrecioDescartables()->getBidon8L();?></p>
              <p style="margin-top:5px;font-size:20px;">Bidon 5L: <?php echo $precioProductos->getPrecioDescartables()->getBidon5L();?></p>
              <p style="margin-top:5px;font-size:20px;">Pack Botellas 2L: <?php echo $precioProductos->getPrecioDescartables()->getPackBotellas2L();?></p>
              <p style="margin-top:5px;font-size:20px;">Pack Botellas 500mL: <?php echo $precioProductos->getPrecioDescartables()->getPackBotellas500mL();?></p>


            </div>



          <?php } ?>
