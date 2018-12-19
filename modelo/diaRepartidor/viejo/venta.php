<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/estructuraVenta.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/ventaAlquiler.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/ventaProductos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/ventaOC.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/productos.php');


class Venta extends EstructuraVenta
{
    function __construct($fila=null)
    {
    parent::__construct();

    if($fila!=null)
      {

      $this->idRepartidor = $fila["IdEmpleado"];
      $this->idVendedor = $fila["IdEmpleado_Vendedor"];
      $this->idCliente = $fila["IdCliente"];
      $this->idDireccion = $fila["IdDireccion"];
      $this->fecha = $fila["Fecha"];

      $this->visitado = $fila["Estado_ClienteAtendido"];

      $this->ventaAlquiler = new VentaAlquiler($fila);
      $this->ventaOC = new VentaOC($fila);
      $this->ventaProductos = new VentaProductosViejo($fila);

      $this->retornablesDevueltos = new RetornablesViejo();

      $this->retornablesDevueltos->setBidones20L($fila["NBidon20L_V"]);
      $this->retornablesDevueltos->setBidones12L($fila["NBidon12L_V"]);


      }

    }

    public function guardar(){}
    public function evaluar(){}
    public function cargar($datoXml){}

    protected $ventaAlquiler;
    protected $ventaOC;
    protected $ventaProductos;

    protected $visitado;

    protected $retornablesDevueltos;

    public function getRetornablesDevueltos(){return $this->retornablesDevueltos;}
    public function setRetornablesDevueltos($retornablesDevueltos){$this->retornablesDevueltos = $retornablesDevueltos;}


    public function getVisitado(){return $this->visitado;}
    public function setVisitado($visitado){$this->visitado = $visitado;}

    public function getVentaAlquiler(){return $this->ventaAlquiler;}
    public function setVentaAlquiler($ventaAlquiler){$this->ventaAlquiler = $ventaAlquiler;}

    public function getVentaOC(){return $this->ventaOC;}
    public function setVentaOC($ventaOC){$this->ventaOC = $ventaOC;}

    public function getVentaProductos(){return $this->ventaProductos;}
    public function setVentaProductos($ventaProductos){$this->ventaProductos = $ventaProductos;}


    public function getDatosCliente()
    {
    if(parent::abrirConexion())
        {
        $sql = "SELECT Nombre,Apellido FROM Clientes WHERE IdCliente = '$this->idCliente'";
        $tabla = $this->conexion->query($sql);

        if($tabla->num_rows>0)
            {
            $row = $tabla->fetch_assoc();
            return $row["Nombre"] . " " . $row["Apellido"];
            }
        else
            {
            return "";
            }
        }
      else
        {
        return "";
        }
    }

    public function getDireccionCliente()
    {
    $direccion = new Direccion($this->idDireccion);
    return $direccion->toString();
    }




}



?>
