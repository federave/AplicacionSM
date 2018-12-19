<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


class TipoCliente extends Conector
{

    function __construct($id=null)
    {
    parent::__construct();
    if(parent::abrirConexion())
        {
        if($id!=null)
          {
          $this->id = $id;
          $sql = "SELECT * FROM TipoClientes WHERE IdTipoCliente = '$id'";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->tipoCliente = $row["Tipo"];
              }
          }
        }
    }

    private $tipoCliente;

    public function getTipoCliente()
    {
    return $this->tipoCliente;
    }

    private $id;

    public function getId()
    {
    return $this->id;
    }




}


?>
