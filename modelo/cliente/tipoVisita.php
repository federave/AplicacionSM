<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


class TipoVisita extends Conector
{

    function __construct($id=null)
    {
    parent::__construct();
    if(parent::abrirConexion())
        {
        if($id!=null)
          {
            $this->id = $id;

          $sql = "SELECT * FROM TipoVisita WHERE Id = '$id'";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->tipoVisita = $row["TipoVisita"];
              }
          }
        parent::cerrarConexion();
        }
    }

    private $tipoVisita;

    public function getTipoVisita()
    {
    return $this->tipoVisita;
    }

    private $id;

    public function getId()
    {
    return $this->id;
    }




}


?>
