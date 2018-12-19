<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/estructuraGenerica.php');


abstract class EstructuraVenta extends EstructuraGenerica
{
    function __construct()
    {
    parent::__construct();
    }

    protected $idCliente;
    protected $idDireccion;

    public function getIdCliente(){return $this->idCliente;}
    public function setIdCliente($idCliente){$this->idCliente = $idCliente;}

    public function getIdDireccion(){return $this->idDireccion;}
    public function setIdDireccion($idDireccion){$this->idDireccion = $idDireccion;}






}
















?>
