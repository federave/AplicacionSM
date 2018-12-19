

<h3 class="subtitulo" style="margin-bottom:30px;">Deudas Productos</h3>

<br>
<p style="font-size:20px">Numero Total de Deudas sin Pagar: <?php echo $cliente->getDeudasProductos()->getSize();?></p>
<br>


<script type="text/javascript">
function itemClickDeudaProductos(indice)
{
var nombre = "deudaProductos" + indice;
if(document.getElementById(nombre).style.display == "block")
  document.getElementById(nombre).style.display = "none"
else
  document.getElementById(nombre).style.display = "block";
}
</script>

<?php
$items = $cliente->getDeudasProductos()->getItems();
$ancho = 600;
$alto = 500;
$nombre = "deudaProductos";
$nombreClick = "DeudaProductos";
$eliminar = false;
require '../componentes/vistaLista.php';
?>
