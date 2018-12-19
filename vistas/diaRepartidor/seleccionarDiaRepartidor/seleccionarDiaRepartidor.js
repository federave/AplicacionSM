
    function limpiarDatosDiaRepartidor()
    {
    document.getElementById("idRepartidor_seleccionado").value = "";
    document.getElementById("DR_Nombre").innerText ="Nombre: ";
    document.getElementById("DR_Apellido").innerText ="Apellido: ";
    document.getElementById("DR_Fecha").innerText = "Fecha: ";
    document.getElementById("DR_DiaCreado").innerText = "Dia Creado: ";
    document.getElementById("DR_DiaCompletado").innerText = "Dia Completado: ";
    document.getElementById("fecha_seleccionado").value = "";
    document.getElementById("diaCreado_seleccionado").value = "";
    document.getElementById("diaCompletado_seleccionado").value = "";

    document.getElementById("divMenuOpciones").style.display="none";
    document.getElementById("divInfoOpciones").style.display="block";
    document.getElementById("infoOpciones").style.display="Debe seleccionar reparto";


    }

    function seleccionarReparto()
    {

    limpiarDatosDiaRepartidor();

    var idRepartidor = document.getElementById("repartidores").value;
    var fecha = document.getElementById("fecha").value;

    xml = new Xml();
    xml.startTag("Dato");
    xml.addTag("Repartidor",idRepartidor);
    xml.addTag("Fecha",fecha);
    xml.closeTag("Dato");

    var url="controladores/diaRepartidor/seleccionarDiaRepartidor/seleccionarDiaRepartidor.php?dato=" + xml.toString();
    var solicitud = new XMLHttpRequest();
    solicitud.addEventListener('load',respuestaSeleccionarReparto,false);
    solicitud.open("GET", url, true);
    solicitud.send();


    }


    function respuestaSeleccionarReparto(respuesta)
    {

    if(respuesta.target.responseText != "")
        {

        alert(respuesta.target.responseText);

        var xml = crearXml(respuesta.target.responseText)

        //alert(xml.getElementsByTagName("Nombre")[0].childNodes[0].nodeValue + xml.getElementsByTagName("Fecha")[0].childNodes[0].nodeValue);

        if(xml.getElementsByTagName("DatosCorrectos")[0].childNodes[0].nodeValue)
          {

          if(xml.getElementsByTagName("Id")[0].childNodes[0]!=null)
            document.getElementById("idRepartidor_seleccionado").value = xml.getElementsByTagName("Id")[0].childNodes[0].nodeValue;
          else
            document.getElementById("idRepartidor_seleccionado").value = "0";

          if(xml.getElementsByTagName("Nombre")[0].childNodes[0]!=null)
            document.getElementById("DR_Nombre").innerText += xml.getElementsByTagName("Nombre")[0].childNodes[0].nodeValue;
          if(xml.getElementsByTagName("Apellido")[0].childNodes[0]!=null)
            document.getElementById("DR_Apellido").innerText += xml.getElementsByTagName("Apellido")[0].childNodes[0].nodeValue;

          if(xml.getElementsByTagName("Fecha")[0].childNodes[0]!=null)
            {
            document.getElementById("DR_Fecha").innerText += xml.getElementsByTagName("Fecha")[0].childNodes[0].nodeValue;
            document.getElementById("fecha_seleccionado").value = xml.getElementsByTagName("Fecha")[0].childNodes[0].nodeValue;
            }

          if(xml.getElementsByTagName("DiaCreado")[0].childNodes[0]!=null)
            {
            document.getElementById("diaCreado_seleccionado").value = xml.getElementsByTagName("DiaCreado")[0].childNodes[0].nodeValue;
            document.getElementById("diaCompletado_seleccionado").value = xml.getElementsByTagName("DiaCompletado")[0].childNodes[0].nodeValue;
            if (xml.getElementsByTagName("DiaCreado")[0].childNodes[0].nodeValue)
                {
                document.getElementById("DR_DiaCreado").innerText += "si";
                document.getElementById("divMenuOpciones").style.display="block";
                document.getElementById("divInfoOpciones").style.display="none";

                if(xml.getElementsByTagName("DiaCompletado")[0].childNodes[0].nodeValue)
                  document.getElementById("DR_DiaCompletado").innerText += "si";
                else
                  document.getElementById("DR_DiaCompletado").innerText += "no";
                }
              else
                {
                document.getElementById("infoOpciones").innerText = "Debe crear el dia para tener opciones";
                document.getElementById("DR_DiaCreado").innerText += "no"
                document.getElementById("DR_DiaCompletado").innerText += "no"
                }
            }
          else
            {
            document.getElementById("infoOpciones").innerText = "Debe crear el dia para tener opciones";
            document.getElementById("DR_DiaCreado").innerText += "no"
            document.getElementById("DR_DiaCompletado").innerText += "no"
            }







          }
        else
          {


          }





        }


    }
