<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


abstract class EstructuraGenerica extends Conector
{
    function __construct()
    {
    parent::__construct();
    }


    abstract protected function guardar();
    abstract protected function evaluar();
    abstract protected function cargar($datoXml);

    protected $idRepartidor;
    protected $idVendedor;
    protected $fecha;

    public function getIdRepartidor(){return $this->idRepartidor;}
    public function setIdRepartidor($idRepartidor){$this->idRepartidor = $idRepartidor;}

    public function getIdVendedor(){return $this->idVendedor;}
    public function setIdVendedor($idVendedor){$this->idVendedor = $idVendedor;}

    public function getFecha(){return $this->fecha;}
    public function setFecha($fecha){$this->fecha = $fecha;}




}




?>
