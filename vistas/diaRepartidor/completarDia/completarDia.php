


<script type="text/javascript">
  function mostrarPlanillas()
  {
  if(document.getElementById("divPlanillas").style.display == "block")
    document.getElementById("divPlanillas").style.display = "none";
  else
    document.getElementById("divPlanillas").style.display = "block";
  }
</script>

<div class="" style="margin:50px;">
  <button class="btn-link buttonLink" onclick="mostrarPlanillas()" style="font-size:20px">Planillas del Día</button>
</div>


<div id="divPlanillas" class="row borde" style="margin:50px;display:block">

  <div class="text-center" style="width:100%;margin-bottom:25px;margin-top:50px">
    <h3 class="subtitulo">Planillas del Dia</h3>
  </div>


  <div id="divCompletarPlanilla"  class="" style="">


    <?php

      $planillas = $_SESSION["Planillas"];

      foreach ($planillas->getPlanillas() as $planilla)
        {
        require 'tabla/tabla.php';
        //require 'opciones/opciones.php';
        }

    ?>


  </div>

  </div>
