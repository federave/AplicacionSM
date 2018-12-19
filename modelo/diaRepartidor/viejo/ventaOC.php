<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/estructuraVenta.php');


class VentaOC extends EstructuraVenta
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

      $this->productos->getRetornables()->setBidones20L($fila["NBidon20L_O"]);
      $this->productos->getRetornables()->setBidones12L($fila["NBidon12L_O"]);

      $this->productos->getDescartables()->setBidones10L($fila["NBidon10L_O"]);
      $this->productos->getDescartables()->setBidones8L($fila["NBidon8L_O"]);
      $this->productos->getDescartables()->setBidones5L($fila["NBidon5L_O"]);
      $this->productos->getDescartables()->setPackBotellas2L($fila["NPackBotellas2L_O"]);
      $this->productos->getDescartables()->setPackBotellas500mL($fila["NPackBotellas500mL_O"]);

      }




    }

    public function guardar(){}
    public function evaluar(){}
    public function cargar($datoXml){}

    protected $productos;

    public function getProductos(){return $this->productos;}
    public function setProductos($productos){$this->productos = $productos;}

}












?>
