

<script type="text/javascript">

  function buscarCliente()
  {

  var idCliente = document.getElementById("AC_idCliente").value;

  xml = new Xml();
  xml.startTag("Dato");
  xml.addTag("IdCliente",idCliente);
  xml.closeTag("Dato");

  var url="vistas/diaRepartidor/completarDia/opciones/ajax/buscarCliente.php?dato=" + xml.toString();
  var solicitud = new XMLHttpRequest();
  solicitud.addEventListener('load',respuestaBuscarCliente,false);
  solicitud.open("GET", url, true);
  solicitud.send();

  }

  function respuestaBuscarCliente(respuesta)
  {



    if(respuesta.target.responseText != "")
        {

        alert(respuesta.target.responseText);

        var xml = crearXml(respuesta.target.responseText)


        if(xml.getElementsByTagName("ClienteEncontrado")[0].childNodes[0].nodeValue)
          {

            var divAgregarCliente = document.getElementById("divAgregarCliente").value;


            n = xml.getElementsByTagName("NumeroDirecciones")[0].childNodes[0].nodeValue;


            cadena="";
            cadena += "<select class= \"form-control\" id=\"direcciones\" name=\"direcciones\" style=\"width:200px;margin-top:10px;\">";


            for (var i = 0; i < n ; i++)
              {

              cadena += "<option value="+ xml.getElementsByTagName("IdDireccion")[i].childNodes[0].nodeValue +">"

              cadena += xml.getElementsByTagName("Direccion")[i].childNodes[0].nodeValue;
              cadena +="</option>";
              }
              cadena+=  "</select>";

            document.getElementById("divAgregarCliente").innerHTML +=  cadena;

            document.getElementById("divAgregarCliente").innerHTML +=  "<button class= \"form-control\" id=\"agregarCliente\" style=\"width:200px;margin-top:10px;\" onclick=\"agregarCliente()\" >"+"Agregar Cliente"+"</button>";



          }
        else
          {
            document.getElementById("divAgregarCliente").innerHTML += "<p> no se encontro el cliente </p>";

          }

        }
      else
          {
            alert("aaaaaaa");

          }



  }

  function agregarCliente()
  {

    alert(document.getElementById("direcciones").value);
  }


</script>




<div class="column" id="divAgregarCliente" style="300px">

  <input type="number" name="AC_idCliente" id="AC_idCliente" value="" class="form-control" min="1">
  <button type="button" name="button" onclick="buscarCliente()" class="form-control">Buscar</button>




</div>
