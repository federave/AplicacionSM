<script type="text/javascript">
  function mostrarFueraDeRecorrido()
  {
  if(document.getElementById("divFueraDeRecorrido").style.display == "block")
    document.getElementById("divFueraDeRecorrido").style.display = "none";
  else
    document.getElementById("divFueraDeRecorrido").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarFueraDeRecorrido()" style="font-size:20px">Clientes Fuera De Recorrido</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divFueraDeRecorrido">

  <div class="row">
    <div class="text-center" style="width:100%;margin-bottom:25px">
      <h3>Clientes Fuera de Recorrido</h3>
    </div>
  </div>

  <div class="row" style="margin-top:20px">

    <div class="column" style="width:30%;margin-top:50px">
      <?php $aux="Lista";if($diaRepartidor->getClientesFueraDeRecorrido()->getSize()==0){$aux = " No hay clientes fuera de recorrido";} ?>
      <div class="text-center" style="margin-bottom:25px">
        <h3><?php echo $aux ?></h3>
      </div>

      <script type="text/javascript">

      function itemClickFueraRecorrido(indice)
      {
      var nombre = "fueraRecorrido" + indice;
      if(document.getElementById(nombre).style.display == "block")
        document.getElementById(nombre).style.display = "none"
      else
        document.getElementById(nombre).style.display = "block";
      }


      </script>
      <?php
        $items = $diaRepartidor->getClientesFueraDeRecorrido();
        $ancho = 500;
        $alto = 300;
        $nombre = "fueraRecorrido";
        $nombreClick = "FueraRecorrido";
        $eliminar = false;
        require '../componentes/vistaLista.php';
      ?>
    </div>
    <?php if($diaRepartidor->getDiaCompletado()==0){ ?>
    <div class="column" style="margin-left:100px;width:30%;margin-top:30px;">

      <div class="text-center" style="margin-bottom:30px">
        <h3>Agregar Cliente Fuera de Recorrido</h3>
      </div>

      <div style="margin-left:20%">

        <form onsubmit="return consultar()" action="../../controladores/diaRepartidor/clientesFueraDeRecorrido/agregarClienteFueraDeRecorrido.php" method="post">
            <div class="form-group" style="width:50%">
              <label for="idClienteFueraDeRecorrido">IdCliente</label>
              <input onkeyup="validar()" type="number" class="form-control" id="idClienteFueraDeRecorrido" name="idClienteFueraDeRecorrido" required>
            </div>
            <div class="form-group" style="width:50%">
              <label for="idDireccionFueraDeRecorrido">IdDireccion</label>
              <input onkeyup="validar()" type="number" class="form-control" id="idDireccionFueraDeRecorrido" name="idDireccionFueraDeRecorrido" required>
            </div>
            <div class="form-group" style="width:50%">
              <label for="mensajeFueraDeRecorrido">Mensaje</label>
              <input type="text" class="form-control" id="mensajeFueraDeRecorrido" name="mensajeFueraDeRecorrido">
            </div>


            <label for="idFueraDeRecorrido" style="text-align: center;">Tipo Fuera de Recorrido</label>
            <select class="form-control" id="idFueraDeRecorrido" name="idFueraDeRecorrido" style="width:200px;font-size:19px">
              <?php
              include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/fueraDeRecorrido/tiposFueraDeRecorrido.php');

              $tiposFueraDeRecorrido = new TiposFueraDeRecorrido();
              $k=0;
              while($k<$tiposFueraDeRecorrido->getNumero())
                  {
                  ?>
                  <option value=<?php echo $tiposFueraDeRecorrido->getTipo($k)->getId() ?> >
                    <?php echo $tiposFueraDeRecorrido->getTipo($k)->getTipo();?>
                  </option>
                <?php
                  $k++;
                  }
              ?>
            </select>




            <div class="form-group">
              <label for="estadoFueraDeRecorrido">Estado</label>
              <p id="estadoFueraDeRecorrido"></p>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-success" style="width:50%;font-size:20px">Guardar</button>
            </div>

            <input type="hidden" id="idRepartidorFueraDeRecorrido" name="idRepartidorFueraDeRecorrido" value=<?php echo $diaRepartidor->getRepartidor()->getId();?>>
            <input type="hidden" id="fechaFueraDeRecorrido" name="fechaFueraDeRecorrido" value=<?php echo $diaRepartidor->getFecha();?>>

            <input type="hidden" id="validarFueraDeRecorrido" value="0">
            <input type="hidden" id="estadoAgregarFueraDeRecorrido" value="0">

        </form>
      </div>

      <script type="text/javascript">

        function validar()
        {
        document.getElementById("validarFueraDeRecorrido").value="0";
        document.getElementById("estadoFueraDeRecorrido").innerHTML="";

        var idCliente = document.getElementById("idClienteFueraDeRecorrido").value;
        var idDireccion = document.getElementById("idDireccionFueraDeRecorrido").value;

        if(idCliente>0 && idDireccion>0)
          {
          var idRepartidor = document.getElementById("idRepartidor").value;
          var fecha = document.getElementById("fecha").value;
          var parametros = "?idCliente="+idCliente+"&idDireccion="+idDireccion+"&idRepartidor="+idRepartidor+"&fecha="+fecha;
          var url="../../controladores/diaRepartidor/clientesFueraDeRecorrido/consultaAgregarClienteFueraDeRecorrido.php" + parametros;
          var solicitud = new XMLHttpRequest();
          solicitud.addEventListener('load',respuestaValidar,false);
          solicitud.open("GET", url, true);
          solicitud.send();
          }
        else
          {
          document.getElementById("estadoFueraDeRecorrido").innerHTML = "Faltan completar datos";
          }

        }

        function respuestaValidar(respuesta)
        {

        if (window.DOMParser)
          {
          parser = new DOMParser();
          xmlDoc = parser.parseFromString(respuesta.target.responseText, "text/xml");
          }
        else // Internet Explorer
          {
          xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
          xmlDoc.async = false;
          xmlDoc.loadXML(respuesta.target.responseText);
          }
        document.getElementById("estadoFueraDeRecorrido").innerHTML = xmlDoc.getElementsByTagName("Mensaje")[0].childNodes[0].nodeValue;
        document.getElementById("estadoAgregarFueraDeRecorrido").value = xmlDoc.getElementsByTagName("EstadoAgregar")[0].childNodes[0].nodeValue;
        document.getElementById("validarFueraDeRecorrido").value = "1";
        }

        function consultar()
        {
        if(document.getElementById("validarFueraDeRecorrido").value=="1" && document.getElementById("estadoAgregarFueraDeRecorrido").value=="1")
          {
          document.getElementById("validarFueraDeRecorrido").value="0";
          document.getElementById("estadoAgregarFueraDeRecorrido").value ="0";
          document.getElementById("estadoFueraDeRecorrido").value = "";
          return true;
          }
        else
          {
          alert("Los datos no son correctos");
          return false;
          }
        }






      </script>

    </div>

    <?php } ?>


  </div>




</div>
