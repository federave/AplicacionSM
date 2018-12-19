



<?php



  $idVendedor = $planilla->getIdVendedor();


  $fila = 0;
  foreach ($planilla->getVentas() as $venta)
    {
    require 'ventaPlanilla.php';
    $fila = $fila + 1;
    }



?>


<input type="hidden" id="numeroVentas" name="numeroVentas" value=<?php echo $fila;?> >
