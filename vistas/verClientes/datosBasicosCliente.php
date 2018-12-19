<h3 class="subtitulo" style="margin-bottom:30px;">Datos Generales</h3>

<p style="margin-top:5px;font-size:20px;">IdCliente: <?php echo $cliente->getDatos()->getId();?></p>
<p style="margin-top:5px;font-size:20px;">Nombre: <?php echo $cliente->getDatos()->getNombre();?></p>
<p style="margin-top:5px;font-size:20px;">Apellido: <?php echo $cliente->getDatos()->getApellido();?></p>
<p style="margin-top:5px;font-size:20px;">DNI: <?php echo $cliente->getDatos()->getDNI();?></p>
<p style="margin-top:5px;font-size:20px;">Telefono 1: <?php echo $cliente->getDatos()->getTelefono1();?></p>
<p style="margin-top:5px;font-size:20px;">Telefono 2: <?php echo $cliente->getDatos()->getTelefono2();?></p>
<p style="margin-top:5px;font-size:20px;">Email: <?php echo $cliente->getDatos()->getEmail();?></p>
<p style="margin-top:5px;font-size:20px;">TipoCliente: <?php echo $cliente->getDatos()->getTipoCliente()->getTipoCliente();?></p>
