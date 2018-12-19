


<?php

// Variables y Manejadores del Buscador

// $estadoSeleccionar
// $estadoLinkSeleccionar
// $estadoVerDetalle
// $estadoEliminar

// $anchoElemento;
// $altoLista;

// $linkSeleccionar;

// $tipoBusqueda;
// $tituloBusqueda;


if(!isset($linkSeleccionar)){$linkSeleccionar="";}

if(!isset($estadoSeleccionar)){$estadoSeleccionar=0;}
if(!isset($estadoLinkSeleccionar)){$estadoLinkSeleccionar=1;}
if(!isset($estadoVerDetalle)){$estadoVerDetalle=0;}
if(!isset($estadoEliminar)){$estadoEliminar=0;}

if(!isset($anchoElemento)){$anchoElemento="400";}
if(!isset($altoLista)){$altoLista="400";}


?>



  <script type="text/javascript">

      function buscarClientes()
      {
      if(document.getElementById("inputBusqueda").value.length >= 2)
        {
        var parametros = "?datoBusqueda="+document.getElementById("inputBusqueda").value;
        var url="../../controladores/buscarClientes/buscarClientes.php"  + parametros;
        var solicitud = new XMLHttpRequest();
        solicitud.addEventListener('load',respuestaBuscarClientes,false);
        solicitud.open("GET", url, true);
        solicitud.send();
        }
      else
        {
        var lista = new ListaHorizontal;
        lista.setAlto(<?php echo $altoLista;?>);
        lista.setAnchoElemento(<?php echo $anchoElemento;?>);
        document.getElementById("divClientesEncontrados").innerHTML="";
        document.getElementById("divClientesEncontrados").appendChild(lista.getLista());
        }
      }

      function respuestaBuscarClientes(respuesta)
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

      var numClientes = xmlDoc.getElementsByTagName("NumeroClientes")[0].childNodes[0].nodeValue;
      var lista = new ListaHorizontal;
      lista.setAlto(<?php echo $altoLista;?>);
      lista.setAnchoElemento(<?php echo $anchoElemento; ?>);
      if(numClientes>0)
        {
        for (var i = 0; i < numClientes; i++)
          {
          var id = xmlDoc.getElementsByTagName("IdCliente")[i].childNodes[0].nodeValue;
          var id2 = xmlDoc.getElementsByTagName("IdDireccion")[i].childNodes[0].nodeValue;

          var elemento = new ElementoLista("Cliente" + i,id,id2);

          elemento.setLinkSeleccionar("<?php echo $linkSeleccionar; ?>"+"?id=" + id + "&id2="+id2);
          elemento.setEstadoSeleccionar(<?php echo $estadoSeleccionar;?>);
          elemento.setEstadoLinkSeleccionar(<?php echo $estadoLinkSeleccionar;?>);
          elemento.setEstadoVerDetalle(<?php echo $estadoVerDetalle;?>);
          elemento.setEstadoEliminar(<?php echo $estadoEliminar;?>);
          elemento.setAncho(<?php echo $anchoElemento; ?>);
          elemento.setTitulo("Cliente " + id);
          elemento.setDescripcion(xmlDoc.getElementsByTagName("Datos")[i].childNodes[0].nodeValue + "<br>" + xmlDoc.getElementsByTagName("Direccion")[i].childNodes[0].nodeValue);
          lista.addElemento(elemento.getElemento());
          }
        document.getElementById("divClientesEncontrados").innerHTML="";
        document.getElementById("divClientesEncontrados").appendChild(lista.getLista());


        }
      }
  </script>



    <div class="text-center" style="margin-bottom:20px;">
      <h3 class="subtitulo"><?php echo $tituloBusqueda;?></h3>
    </div>

    <div class="text-center" >
      <label class="fuente" for="inputBusqueda" style="font-size:18px;text-align:center;margin-bottom:12px">Ingrese datos de busqueda</label>
    </div>

    <div class=""style="align-items:center;width:100%;display:flex;justify-content:center;">
      <div class="" style="">
        <input type="text" name="" class="form-control" value="" onkeyup="buscarClientes()" style="width:300px;font-size:19px;text-align:center" type="text" id="inputBusqueda" value="">
      </div>
    </div>

    <div class="" style="align-items:center;width:100%;display:flex;justify-content:center;align-items:center;">
      <div id="divClientesEncontrados" class="" style="width:100%;margin-top:20px;">
      </div>
    </div>
