

<?php
  if($venta->getVentaAlquiler()->getAlquiler())
      {
      $alquiler = "background-color: rgb(152,232,255)";
      }
  else
      {
        $alquiler = "white";
      }
?>


<div class="row fila" id=<?php echo getNVNF($idVendedor,$fila); ?> name = <?php echo getNVNF($idVendedor,$fila); ?> >



  <input type="hidden" <?php echo getIdName($idVendedor,$fila,"-2"); ?> value=<?php echo $venta->getFecha();?> >
  <input type="hidden" <?php echo getIdName($idVendedor,$fila,"-1"); ?> value=<?php echo $venta->getIdVendedor();?> >
  <input type="hidden" <?php echo getIdName($idVendedor,$fila,"0"); ?>  value=<?php echo $venta->getIdRepartidor();?>>
  <input type="hidden" <?php echo getIdName($idVendedor,$fila,"1"); ?>  value=<?php echo $venta->getIdCliente();?>>
  <input type="hidden" <?php echo getIdName($idVendedor,$fila,"2"); ?>  value=<?php echo $venta->getIdDireccion();?>>



  <div class="fuente borde columna columnaCabezera columnaId " style="<?php echo $alquiler; ?>" ><?php echo $venta->getIdCliente(); ?></div>
  <div class="fuente borde columna columnaCabezera columnaNombre " style="<?php echo $alquiler; ?>" ><?php echo $venta->getDatosCliente();?></div>
  <div class="fuente borde columna columnaCabezera columnaDireccion " style="<?php echo $alquiler; ?>" ><?php echo $venta->getDireccionCliente(); ?></div>


    <!-- Columna Visitado -->

    <div class="fuente borde columna columnaCabezera columnaVisitado">
      <input <?php echo getIdName($idVendedor,$fila,"3"); ?>  <?php echo getValueColumna($venta->getVisitado()); ?> class="fuente input color" style="width:100%" type="number" min="0" max="1" readonly/>
    </div>

    <!-- Columna 20l -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"4"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getRetornables()->getBidones20L()); ?> class="fuente input color" type="number" readonly/>
    </div>

    <!-- Columna 20l_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"5"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getRetornables()->getBidones20L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 12l -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"6"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getRetornables()->getBidones12L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 12l_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"7"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getRetornables()->getBidones12L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 10L -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"8"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getDescartables()->getBidones10L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 10L_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"9"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getDescartables()->getBidones10L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 8L -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"10"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getDescartables()->getBidones8L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 8L_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"11"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getDescartables()->getBidones8L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 5L -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"12"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getDescartables()->getBidones5L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 5L_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"13"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getDescartables()->getBidones5L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 2L -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"14"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getDescartables()->getPackBotellas2L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 2L_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"15"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getDescartables()->getPackBotellas2L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 500mL -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"16"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductos()->getDescartables()->getPackBotellas500mL()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 500mL_B -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaBonificados">
      <input <?php echo getIdName($idVendedor,$fila,"17"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getProductosBonificados()->getDescartables()->getPackBotellas500mL()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna Dinero -->

    <div class="fuente borde columna columnaCabezera columnaDinero">
      <input <?php echo getIdName($idVendedor,$fila,"18"); ?>  <?php echo getValueColumna($venta->getVentaProductos()->getDinero()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 20L_D -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"19"); ?>  <?php echo getValueColumna($venta->getRetornablesDevueltos()->getBidones20L()); ?> class="fuente input color" type="number" readonly/>
    </div>

    <!-- Columna 12L_D -->

    <div class="fuente borde columna columnaCabezera columnaProducto">
      <input <?php echo getIdName($idVendedor,$fila,"20"); ?>  <?php echo getValueColumna($venta->getRetornablesDevueltos()->getBidones12L()); ?> class="fuente input color" type="number" readonly/>
    </div>

    <!-- Columna 20L_A -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaAlquiler">
      <input <?php echo getIdName($idVendedor,$fila,"21"); ?>  <?php echo getValueColumna($venta->getVentaAlquiler()->getRetornables()->getBidones20L()); ?> class="fuente input color" type="number" readonly/>
    </div>


    <!-- Columna 12L_A -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaAlquiler">
      <input <?php echo getIdName($idVendedor,$fila,"22"); ?>  <?php echo getValueColumna($venta->getVentaAlquiler()->getRetornables()->getBidones12L()); ?> class="fuente input color" type="number" readonly/>
    </div>

    <!-- Columna 20l_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"23"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getRetornables()->getBidones20L()); ?> class="fuente input color" type="number" readonly/>
    </div>



    <!-- Columna 12l_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"24"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getRetornables()->getBidones12L()); ?> class="fuente input color" type="number" readonly/>
    </div>




    <!-- Columna 10L_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"25"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getDescartables()->getBidones10L()); ?> class="fuente input color" type="number" readonly />
    </div>



    <!-- Columna 8L_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"26"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getDescartables()->getBidones8L()); ?> class="fuente input color" type="number" readonly/>
    </div>



    <!-- Columna 5L_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"27"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getDescartables()->getBidones5L()); ?> class="fuente input color" type="number" readonly/>
    </div>



    <!-- Columna 2L_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"28"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getDescartables()->getPackBotellas2L()); ?> class="fuente input color" type="number" readonly/>
    </div>



    <!-- Columna 500mL_O -->

    <div class="fuente borde columna columnaCabezera columnaProducto columnaOC">
      <input <?php echo getIdName($idVendedor,$fila,"29"); ?>  <?php echo getValueColumna($venta->getVentaOC()->getProductos()->getDescartables()->getPackBotellas500mL()); ?> class="fuente input color" type="number" readonly/>
    </div>





</div>
