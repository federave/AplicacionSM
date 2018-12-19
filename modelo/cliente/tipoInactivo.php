<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


class TipoInactivo extends Conector
{

    function __construct($id=null)
    {
    parent::__construct();
    if(parent::abrirConexion())
        {
        if($id!=null)
          {
            $this->id = $id;

          $sql = "SELECT * FROM TipoInactivo WHERE Id = '$id'";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->tipoInactivo = $row["TipoInactivo"];
              }
          }
        }
    }

    private $tipoInactivo;

    public function getTipoInactivo()
    {
    return $this->tipoInactivo;
    }

    private $id;

    public function getId()
    {
    return $this->id;
    }




}


?>
