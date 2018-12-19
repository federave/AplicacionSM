<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/estructuraVenta.php');


class VentaProductosViejo extends EstructuraVenta
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


      $this->productos  = new ProductosViejo();
      $this->productosBonificados = new ProductosViejo();

      $this->productos->getRetornables()->setBidones20L($fila["NBidon20L"]);
      $this->productos->getRetornables()->setBidones12L($fila["NBidon12L"]);

      $this->productos->getDescartables()->setBidones10L($fila["NBidon10L"]);
      $this->productos->getDescartables()->setBidones8L($fila["NBidon8L"]);
      $this->productos->getDescartables()->setBidones5L($fila["NBidon5L"]);
      $this->productos->getDescartables()->setPackBotellas2L($fila["NPackBotellas2L"]);
      $this->productos->getDescartables()->setPackBotellas500mL($fila["NPackBotellas500mL"]);


      $this->productosBonificados->getRetornables()->setBidones20L($fila["NBidon20L_B"]);
      $this->productosBonificados->getRetornables()->setBidones12L($fila["NBidon12L_B"]);

      $this->productosBonificados->getDescartables()->setBidones10L($fila["NBidon10L_B"]);
      $this->productosBonificados->getDescartables()->setBidones8L($fila["NBidon8L_B"]);
      $this->productosBonificados->getDescartables()->setBidones5L($fila["NBidon5L_B"]);
      $this->productosBonificados->getDescartables()->setPackBotellas2L($fila["NPackBotellas2L_B"]);
      $this->productosBonificados->getDescartables()->setPackBotellas500mL($fila["NPackBotellas500mL_B"]);

      $this->dinero = $fila["DineroProductos"];



      }

    }

    public function guardar(){}
    public function evaluar(){}
    public function cargar($datoXml){}

    protected $productos;
    protected $productosBonificados;
    protected $dinero;

    public function getDinero(){return $this->dinero;}
    public function setDinero($dinero){$this->dinero = $dinero;}

    public function getProductos(){return $this->productos;}
    public function setProductos($productos){$this->productos = $productos;}

    public function getProductosBonificados(){return $this->productosBonificados;}
    public function setProductosBonificados($productosBonificados){$this->productosBonificados = $productosBonificados;}



}












?>
