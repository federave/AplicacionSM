



class ListaVertical {
  constructor() {

  this.divLista = document.createElement("div");
  this.divLista.setAttribute("class","column borde");
  this.divLista.setAttribute("style","padding:20px;overflow-y:auto");

  }


  addElemento(elemento)
  {
  var divColumna = document.createElement("div");
  divColumna.setAttribute("class","row borde");
  divColumna.setAttribute("style","margin-top:10px;");
  divColumna.appendChild(elemento);
  this.divLista.appendChild(divColumna);
  }

  getLista()
  {
  return this.divLista;
  }

  setAncho(ancho)
  {
  this.divLista.style.width=ancho;
  }

  setAlto(alto)
  {
  this.divLista.style.height = alto;
  }

}


class ListaHorizontal {
  constructor() {
  this.divLista = document.createElement("div");
  this.divLista.setAttribute("class","borde");
  this.divLista.setAttribute("style","height:350px;width:100%;overflow-x:scroll;overflow-y:auto;");

  this.divListaInterno = document.createElement("div");
  this.divListaInterno.setAttribute("class","");
  this.divListaInterno.setAttribute("style","padding:20px");

  this.divLista.appendChild(this.divListaInterno);

  this.numeroElementos=0;


  }


  addElemento(elemento)
  {
  this.numeroElementos++;
  var divColumna = document.createElement("div");
  divColumna.setAttribute("class","borde");
  divColumna.setAttribute("style","margin-left:13px;margin-top:40px;float:left;");
  divColumna.appendChild(elemento);
  this.divListaInterno.appendChild(divColumna);
  var ancho = (this.numeroElementos * (this.anchoElemento + 20));
  this.divListaInterno.style.width = ancho + "px";
  }

  getLista()
  {
  return this.divLista;
  }

  setAncho(ancho)
  {
  this.divLista.style.width = ancho;
  }

  setAlto(alto)
  {
  this.divLista.style.height = alto + "px";
  }

  setAnchoElemento(ancho)
  {
  this.anchoElemento = ancho;
  }

}


function verDetalle(nombre)
{
document.getElementById(nombre + "Detalle").style.display="block";
}

class ElementoLista
{

  constructor(nombre,id,id2) {



  this.ancho = "400px";
  this.divElementoStyle="width:"+this.ancho;
  this.divElemento = document.createElement("div");
  this.divElemento.setAttribute("class","borde");
  this.divElemento.setAttribute("style",this.divElementoStyle);


  //Titulo
  this.divTitulo = document.createElement("div");
  this.divTitulo.setAttribute("style","margin-top:20px");
  this.divTitulo.setAttribute("class","text-center");
  this.hTitulo = document.createElement("h4");
  this.divTitulo.appendChild(this.hTitulo);
  this.divElemento.appendChild(this.divTitulo);

  //Descripcion
  this.divDescripcion = document.createElement("div");
  this.divDescripcion.setAttribute("style","margin-top:20px");
  this.divDescripcion.setAttribute("class","text-center");
  this.pDescripcion = document.createElement("p");
  this.divDescripcion.appendChild(this.pDescripcion);
  this.divElemento.appendChild(this.divDescripcion);

  //Detalle


  this.divDetalle = document.createElement("div");
  this.divDetalle.setAttribute("style","margin-top:20px;");
  this.divDetalle.setAttribute("class","text-center");

  this.buttonVerDetalle = document.createElement("button");
  this.buttonVerDetalle.innerHTML = "Ver Detalle";
  this.buttonVerDetalle.setAttribute("class","btn-link buttonLink");
  this.buttonVerDetalle.setAttribute("style","font-size:17px;");
  this.buttonVerDetalle.setAttribute("onclick","verDetalle("+"'"+nombre+"'"+")");

  this.pDetalle = document.createElement("p");
  this.pDetalle.setAttribute("style","margin-top:20px;display:none");
  this.pDetalle.innerHTML="<br>" + "<br>" + "<br>" + "<br>" + "<br>" + "<br>" + "<br>" + "<br>" +"aaaaaaaaaaaaaa";



  this.divDetalle.appendChild(this.buttonVerDetalle);
  this.divDetalle.appendChild(this.pDetalle);

  this.divElemento.appendChild(this.divDetalle);

  //Seleccionar

  this.buttonSeleccionar = document.createElement("button");
  this.buttonSeleccionar.innerHTML = "Seleccionar";
  this.buttonSeleccionar.setAttribute("class","btn-link buttonLink");
  this.buttonSeleccionar.setAttribute("style","margin-top:20px;display:none");
  this.divElemento.appendChild(this.buttonSeleccionar);

  // Link Seleccionar

  this.divLinkSeleccionar = document.createElement("div");
  this.divLinkSeleccionar.setAttribute("style","margin-top:20px;display:none;margin-bottom:10px;");
  this.divLinkSeleccionar.setAttribute("class","text-center");

  this.aSeleccionar = document.createElement("a");
  this.aSeleccionar.innerHTML = "Seleccionar";
  this.aSeleccionar.setAttribute("target","_blank");
  this.aSeleccionar.setAttribute("style","margin-top:20px;font-size:18px;color:white");
  this.divLinkSeleccionar.appendChild(this.aSeleccionar);
  this.divElemento.appendChild(this.divLinkSeleccionar);



  //Eliminar

  this.buttonEliminar = document.createElement("button");
  this.buttonEliminar.innerHTML = "Eliminar";
  this.buttonEliminar.setAttribute("class","btn-link buttonLink");
  this.buttonEliminar.setAttribute("style","margin-top:20px;display:none");
  this.divElemento.appendChild(this.buttonEliminar);

  //id

  this.inputId = document.createElement("input");
  this.inputId.setAttribute("type","hidden");
  this.inputId.setAttribute("id",nombre + "Id");
  this.inputId.value = id;


  this.inputId2 = document.createElement("input");
  this.inputId2.setAttribute("type","hidden");
  this.inputId2.setAttribute("id",nombre + "Id2");
  this.inputId2.value = id2;


  this.nombre = nombre;
  this.pDetalle.setAttribute("id",nombre + "Detalle");






  }

  setLinkSeleccionar(link)
  {
    this.aSeleccionar.setAttribute("href",link);

  }


  setEstadoVerDetalle(estado)
  {
    if(estado)
    this.divDetalle.style.display = "block";
    else
    this.divDetalle.style.display = "none";

  }

  setEstadoLinkSeleccionar(estado)
  {  if(estado)
    this.divLinkSeleccionar.style.display = "block";
    else
    this.divLinkSeleccionar.style.display = "none";

  }

  setEstadoSeleccionar(estado)
  {if(estado)
  this.buttonSeleccionar.style.display = "block";
  else
  this.buttonSeleccionar.style.display = "none";

  }

  setEstadoEliminar(estado)
  {

    if(estado)
      this.buttonEliminar.style.display = "block";
      else
      this.buttonEliminar.style.display = "none";

  }

  setAlto(alto)
  {
  this.alto = alto;
  this.divElemento.style.height = alto + "px";
  }

  setAncho(ancho)
  {
  this.ancho = ancho;
  this.divElementoStyle="width:"+this.ancho+"px";
  this.divElemento.setAttribute("style",this.divElementoStyle);
  }

  setEventoVerDetalle(eventoVerDetalle)
  {
  this.buttonVerDetalle.setAttribute("onclick",eventoVerDetalle);
  }
  setVerDetalle(display)
  {
  this.buttonVerDetalle.style.display = display;
  }



  setEventoSeleccionar(eventoSeleccionar)
  {
  this.buttonSeleccionar.setAttribute("onclick",eventoSeleccionar);
  }
  setVerSeleccionar(display)
  {
  this.buttonSeleccionar.style.display = display;
  }


  setEventoEliminar(eventoEliminar)
  {
  this.buttonEliminar.setAttribute("onclick",eventoEliminar);
  }

  setVerEliminar(display)
  {
  this.buttonEliminar.style.display = display;
  }

  setTitulo(titulo)
  {
  this.hTitulo.innerHTML = titulo;
  }
  setColorTitulo(color)
  {
  this.hTitulo.style.color = color;
  }

  setDescripcion(descripcion)
  {
  this.pDescripcion.innerHTML = descripcion;
  }

  setDetalle(detalle)
  {
  this.pDetalle.innerHTML = detalle;
  }

  getElemento()
  {
  return this.divElemento;
  }


}
