<script type="text/javascript">
  function mostrarDescargas()
  {
  if(document.getElementById("divDescargas").style.display == "block")
    document.getElementById("divDescargas").style.display = "none";
  else
    document.getElementById("divDescargas").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarDescargas()" style="font-size:20px">Descargas</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divDescargas">


  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Descargas</h3>
  </div>



  <div class="row">

    <div class="column" style="width:30%;">
      <br>
      <p id="numeroDescargas" style="font-size:20px">Numero de Descargas: <?php echo $diaRepartidor->getCargamento()->getDescargas()->getSize(); ?></p>
      <br>
    </div>


    <?php if ($diaRepartidor->getCargamento()->getDescargas()->getSize()>0) { ?>    <?php } ?>

    <div class="column" style="margin-left:5%;width:20%;">
      <br>
      <p style="font-size:20px">Total Descargado</p>
      <br>
    </div>

    <script type="text/javascript">
      function mostrarIngresarDescarga()
      {
      if(document.getElementById("divIngresarDescarga").style.display == "block")
        document.getElementById("divIngresarDescarga").style.display = "none";
      else
        document.getElementById("divIngresarDescarga").style.display = "block";
      }
    </script>

    <div class="column" style="margin-left:5%;width:40%;">
      <br>
      <button class="btn-link buttonLink"  onclick="mostrarIngresarDescarga()" style="font-size:20px">Ingresar Descarga</button>
      <br>
    </div>






  </div>

  <?php if ($diaRepartidor->getCargamento()->getDescargas()->getSize()>0) { ?>
  <?php } ?>


  <div class="row">


    <div class="column" style="width:30%;">

      <input type="hidden" id="indiceDescargaEliminada" value="">

      <script type="text/javascript">
      function itemClickDescarga(indice)
      {
      var nombre = "descarga" + indice;
      if(document.getElementById(nombre).style.display == "block")
        document.getElementById(nombre).style.display = "none"
      else
        document.getElementById(nombre).style.display = "block";
      }

      function eliminarDescarga(indice)
      {
        var idDescarga = document.getElementById("idDescarga"+indice).value;

      var r = confirm("Está seguro que quiere eliminar la descarga " + indice + " ?" + idDescarga);
      if (r == true)
        {
        document.getElementById("indiceDescargaEliminada").value = indice;
        var idDescarga = document.getElementById("idDescarga"+indice).value;
        var parametros = "?idDescarga="+idDescarga;
        var url="../../controladores/diaRepartidor/cargamento/descargas/eliminarDescarga.php"+parametros;
        var solicitud = new XMLHttpRequest();
        solicitud.addEventListener('load',respuestaEliminarDescarga,false);
        solicitud.open("GET", url, true);
        solicitud.send();
        }

      }

      function respuestaEliminarDescarga(respuesta)
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

      if(xmlDoc.getElementsByTagName("Estado")[0].childNodes[0].nodeValue)
        {
        var indiceDescargaEliminada = document.getElementById("indiceDescargaEliminada").value;
        document.getElementById("divDescarga" + indiceDescargaEliminada).style.display = "none";

        var idRepartidor = document.getElementById("idRepartidor").value;
        var fecha = document.getElementById("fecha").value;
        var parametros = "?fecha="+fecha+"&idRepartidor="+idRepartidor;
        var url="../../controladores/diaRepartidor/cargamento/descargas/getTotalDescargado.php"+parametros;
        var solicitud = new XMLHttpRequest();
        solicitud.addEventListener('load',respuestaGetTotalDescargado,false);
        solicitud.open("GET", url, true);
        solicitud.send();


        }
      else
        {
        alert("No se pudo eliminar la descarga");
        }

      }

      function respuestaGetTotalDescargado(respuesta)
      {
      document.getElementById("divTotalDescargado").innerHTML = respuesta.target.responseText;


      var idRepartidor = document.getElementById("idRepartidor").value;
      var fecha = document.getElementById("fecha").value;
      var parametros = "?fecha="+fecha+"&idRepartidor="+idRepartidor;
      var url="../../controladores/diaRepartidor/balances/getBalances.php"+parametros;
      var solicitud = new XMLHttpRequest();
      solicitud.addEventListener('load',actualizarBalances,false);
      solicitud.open("GET", url, true);
      solicitud.send();


      }







      </script>

      <?php
        $items = $diaRepartidor->getCargamento()->getDescargas()->getItems();
        $ancho = 500;
        $alto = 300;
        $nombre = "descarga";
        $nombreClick = "Descarga";
        $eliminar = true;
        require '../componentes/vistaLista.php';
      ?>
    </div>

    <div class="column borde" style="margin-left:5%;padding:20px;width:20%;">

      <div id="divTotalDescargado" class="text-center" style="font-size:18px;">
        <?php echo $diaRepartidor->getCargamento()->getDescargas()->toString(); ?>
      </div>

    </div>




    <div id="divIngresarDescarga" class="column borde" style="display:none;margin-left:5%;padding:20px;width:40%;">


      <form>
        <div class="form-group">

          <div class="row" style="margin-bottom:20px;">

            <div class="column" style="margin-left:5%;width:28%">
              <label for="descargaBidones20L" style="margin-bottom:5px">Bidones 20L</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones20L" placeholder="Bidones 20L" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

                <label for="descargaBidones12L" style="margin-bottom:5px;">Bidones 12L</label>
                <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones12L" placeholder="Bidones 12L" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

                <label for="descargaBidones10L" style="margin-bottom:5px">Bidones 10L</label>
                <input  value="0" type="number" class="form-control" style="width:150px" id="descargaBidones10L" placeholder="Bidones 10L" min="0">

            </div>


          </div>


          <div class="row" style="margin-bottom:20px;">

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaBidones8L" style="margin-bottom:5px;margin-top:10px">Bidones 8L</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones8L" placeholder="Bidones 8L" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaBidones5L" style="margin-bottom:5px;margin-top:10px">Bidones 5L</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones5L" placeholder="Bidones 5L" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaPackBotellas2L" style="margin-bottom:5px;margin-top:10px">PackBotellas 2L</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaPackBotellas2L" placeholder="PackBotellas 2L" min="0">

            </div>


          </div>


          <div class="row" style="margin-bottom:20px;">

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaPackBotellas500mL" style="margin-bottom:5px;margin-top:10px">PackBotellas 500mL</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaPackBotellas500mL" placeholder="PackBotellas 500mL" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaBidones20LVacios" style="margin-bottom:5px;margin-top:10px;color:rgb(128, 170, 255)">Bidones 20L Vacios</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones20LVacios" placeholder="Bidones 20L Vacios" min="0">

            </div>

            <div class="column" style="margin-left:5%;width:28%">

              <label for="descargaBidones12LVacios" style="margin-bottom:5px;margin-top:10px;color:rgb(128, 170, 255)">Bidones 12L Vacios</label>
              <input value="0" type="number" class="form-control" style="width:150px" id="descargaBidones12LVacios" placeholder="Bidones 12L Vacios" min="0">

            </div>


          </div>


          <div class="row" style="margin-top:40px">

            <div class="column" style="margin-left:5%">

              <button onclick="ingresarDescarga()" type="button" class=" btn btn-default" style="font-size:17px" name="button">Ingresar Descarga</button>


            </div>

          </div>


        </div>
      </form>


      <script type="text/javascript">

        function cargarDatosIngresarDescarga()
        {
        if(document.getElementById("descargaBidones20L").value == ""){document.getElementById("descargaBidones20L").value=0;}
        if(document.getElementById("descargaBidones12L").value == ""){document.getElementById("descargaBidones12L").value=0;}
        if(document.getElementById("descargaBidones10L").value == ""){document.getElementById("descargaBidones10L").value=0;}
        if(document.getElementById("descargaBidones8L").value == ""){document.getElementById("descargaBidones8L").value=0;}
        if(document.getElementById("descargaBidones5L").value == ""){document.getElementById("descargaBidones5L").value=0;}
        if(document.getElementById("descargaPackBotellas2L").value == ""){document.getElementById("descargaPackBotellas2L").value=0;}
        if(document.getElementById("descargaPackBotellas500mL").value == ""){document.getElementById("descargaPackBotellas500mL").value=0;}
        if(document.getElementById("descargaBidones20LVacios").value == ""){document.getElementById("descargaBidones20LVacios").value=0;}
        if(document.getElementById("descargaBidones12LVacios").value == ""){document.getElementById("descargaBidones12LVacios").value=0;}
        }

        function chequearDatosIngresarDescarga()
        {
          if(document.getElementById("descargaBidones20L").value > 0 || document.getElementById("descargaBidones12L").value > 0 || document.getElementById("descargaBidones10L").value > 0 || document.getElementById("descargaBidones8L").value > 0 || document.getElementById("descargaBidones5L").value > 0 || document.getElementById("descargaPackBotellas2L").value > 0 || document.getElementById("descargaPackBotellas500mL").value > 0 || document.getElementById("descargaBidones20LVacios").value > 0 || document.getElementById("descargaBidones12LVacios").value > 0 )
            {
            return true;
            }
          else
            {
            return false;
            }

        }

        function ingresarDescarga()
        {
        cargarDatosIngresarDescarga();

        if(chequearDatosIngresarDescarga())
          {

          var bidones20L = document.getElementById("descargaBidones20L").value;
          var bidones12L = document.getElementById("descargaBidones12L").value;
          var bidones10L = document.getElementById("descargaBidones10L").value;
          var bidones8L = document.getElementById("descargaBidones8L").value;
          var bidones5L = document.getElementById("descargaBidones5L").value;
          var packBotellas2L = document.getElementById("descargaPackBotellas2L").value;
          var packBotellas500mL = document.getElementById("descargaPackBotellas500mL").value;
          var bidones20LVacios = document.getElementById("descargaBidones20LVacios").value;
          var bidones12LVacios = document.getElementById("descargaBidones12LVacios").value;

          var idRepartidor = document.getElementById("idRepartidor").value;
          var fecha = document.getElementById("fecha").value;
          var parametros = "?fecha="+fecha+"&idRepartidor="+idRepartidor+"&bidones20L="+bidones20L+"&bidones12L="+bidones12L+"&bidones10L="+bidones10L+"&bidones8L="+bidones8L+"&bidones5L="+bidones5L+"&packBotellas2L="+packBotellas2L+"&packBotellas500mL="+packBotellas500mL+"&bidones20LVacios="+bidones20LVacios+"&bidones12LVacios="+bidones12LVacios;
          var url="../../controladores/diaRepartidor/cargamento/descargas/ingresarDescarga.php"+parametros;
          var solicitud = new XMLHttpRequest();
          solicitud.addEventListener('load',respuestaIngresarDescarga,false);
          solicitud.open("GET", url, true);
          solicitud.send();
          }
        else
          {
          alert("Debe ingresar datos en la descarga");
          }


        }


        function getDescripcion()
        {
          var bidones20L = document.getElementById("descargaBidones20L").value;
          var bidones12L = document.getElementById("descargaBidones12L").value;
          var bidones10L = document.getElementById("descargaBidones10L").value;
          var bidones8L = document.getElementById("descargaBidones8L").value;
          var bidones5L = document.getElementById("descargaBidones5L").value;
          var packBotellas2L = document.getElementById("descargaPackBotellas2L").value;
          var packBotellas500mL = document.getElementById("descargaPackBotellas500mL").value;

          var peso = bidones20L*20+bidones12L*12+bidones10L*10+bidones8L*8+bidones5L*5+packBotellas2L*16+packBotellas500mL*9;

          return peso + " KG";

        }

        function getDescripcionOculta()
        {
        var bidones20L = document.getElementById("descargaBidones20L").value;
        var bidones12L = document.getElementById("descargaBidones12L").value;
        var bidones10L = document.getElementById("descargaBidones10L").value;
        var bidones8L = document.getElementById("descargaBidones8L").value;
        var bidones5L = document.getElementById("descargaBidones5L").value;
        var packBotellas2L = document.getElementById("descargaPackBotellas2L").value;
        var packBotellas500mL = document.getElementById("descargaPackBotellas500mL").value;
        var bidones20LVacios = document.getElementById("descargaBidones20LVacios").value;
        var bidones12LVacios = document.getElementById("descargaBidones12LVacios").value;

        var descripcionOculta = "Bidones 20L: " + bidones20L;
        descripcionOculta += "<br>Bidones 12L: " + bidones12L;
        descripcionOculta += "<br>Bidones 10L: " + bidones10L;
        descripcionOculta += "<br>Bidones 8L: " + bidones8L;
        descripcionOculta += "<br>Bidones 5L: " + bidones5L;
        descripcionOculta += "<br>Pack Botellas 2L: " + packBotellas2L;
        descripcionOculta += "<br>Pack Botellas 500mL: " + packBotellas500mL;
        descripcionOculta += "<br>Bidones 20L Vacios: " + bidones20LVacios;
        descripcionOculta += "<br>Bidones 12L Vacios: " + bidones12LVacios;
        return descripcionOculta;
        }


        function respuestaIngresarDescarga(respuesta)
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

        if(xmlDoc.getElementsByTagName("Estado")[0].childNodes[0].nodeValue)
          {

          var descripcion = getDescripcion();
          var descripcionOculta = getDescripcionOculta();

          var indice = document.getElementById("listadescargatamaño").value;
          indice++;
          var titulo = "Descarga " + (indice);

          document.getElementById("listadescargatamaño").value = (indice);
          document.getElementById("numeroDescargas").innerHTML = "Numero de Descargas: " + (indice);

          indice--;
          var divOculto = "descarga" + (indice);



          var divElemento = document.createElement("div");
          divElemento.setAttribute("class","borde cointainer");
          divElemento.setAttribute("style","margin-top:20px");

          var divTitulo = document.createElement("div");
          divTitulo.setAttribute("class","text-center");
          divTitulo.setAttribute("style","margin-top:10px");

          var buttonTitulo = document.createElement("button");
          buttonTitulo.setAttribute("class","btn-link buttonLink");
          buttonTitulo.setAttribute("onclick","itemClickDescarga" + "(" + indice + ")");

          var h4 = document.createElement("h4");
          h4.innerHTML = titulo;
          buttonTitulo.appendChild(h4);
          divTitulo.appendChild(buttonTitulo);
          divElemento.appendChild(divTitulo);

          var divDescripcion = document.createElement("div");
          divDescripcion.setAttribute("class","text-center");
          divDescripcion.setAttribute("style","margin-top:10px;margin-bottom:10px");
          divDescripcion.innerHTML = descripcion;
          divElemento.appendChild(divDescripcion);

          var divDescripcionOculta = document.createElement("div");
          divDescripcionOculta.setAttribute("class","text-center");
          divDescripcionOculta.setAttribute("style","display:none;margin-top:10px;margin-bottom:10px");
          divDescripcionOculta.setAttribute("id",divOculto);
          divDescripcionOculta.setAttribute("name",divOculto);

          divDescripcionOculta.innerHTML = descripcionOculta;
          divElemento.appendChild(divDescripcionOculta);



          var divEliminar = document.createElement("div");
          divEliminar.setAttribute("class","text-center");
          divEliminar.setAttribute("style","margin-top:10px");

          var buttonEliminar = document.createElement("button");
          buttonEliminar.setAttribute("class","btn-link buttonLink");
          buttonEliminar.setAttribute("onclick","eliminarDescarga" + "(" + (indice) + ")");

          var h4Eliminar = document.createElement("h4");
          h4Eliminar.setAttribute("style","color:rgb(157, 1, 1)");
          h4Eliminar.innerHTML = "Eliminar";
          buttonEliminar.appendChild(h4Eliminar);
          divEliminar.appendChild(buttonEliminar);
          divElemento.appendChild(divEliminar);


          document.getElementById("listadescarga").appendChild(divElemento);

          var idRepartidor = document.getElementById("idRepartidor").value;
          var fecha = document.getElementById("fecha").value;
          var parametros = "?fecha="+fecha+"&idRepartidor="+idRepartidor;
          var url="../../controladores/diaRepartidor/cargamento/descargas/getTotalDescargado.php"+parametros;
          var solicitud = new XMLHttpRequest();
          solicitud.addEventListener('load',respuestaGetTotalDescargado,false);
          solicitud.open("GET", url, true);
          solicitud.send();



          }
        else
          {
          alert("No se pudo guardar la descarga");
          }

        }

        function respuestaGetTotalDescargado(respuesta)
        {
        document.getElementById("divTotalDescargado").innerHTML = respuesta.target.responseText;



        var idRepartidor = document.getElementById("idRepartidor").value;
        var fecha = document.getElementById("fecha").value;
        var parametros = "?fecha="+fecha+"&idRepartidor="+idRepartidor;
        var url="../../controladores/diaRepartidor/balances/getBalances.php"+parametros;
        var solicitud = new XMLHttpRequest();
        solicitud.addEventListener('load',actualizarBalances,false);
        solicitud.open("GET", url, true);
        solicitud.send();



        }


      </script>







    </div>


  </div>






</div>
