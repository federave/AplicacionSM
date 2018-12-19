


<script type="text/javascript">
  function mostrarDatosVisitas()
  {
  if(document.getElementById("divDatosVisitas").style.display == "block")
    document.getElementById("divDatosVisitas").style.display = "none";
  else
    document.getElementById("divDatosVisitas").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarDatosVisitas()" style="font-size:20px">Datos Visitas</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divDatosVisitas">


  <div class="text-center" style="width:500px;margin-bottom:45px">
    <h3 class="subtitulo">Datos Clientes Visitados</h3>
  </div>

  <div class="row" style="margin-top:35px;">

    <div class="">
      <br>
      <p style="font-size:20px">Clientes Visitados: <?php echo $diaRepartidor->getVisitas()->getVisitados();?></p>
      <p style="font-size:20px">Clientes No Visitados: <?php echo $diaRepartidor->getVisitas()->getNoVisitados();?></p>
      <p style="font-size:20px">Clientes No Encontrados: <?php echo $diaRepartidor->getVisitas()->getNoEncontrados();?></p>
    </div>

  </div>

</div>
