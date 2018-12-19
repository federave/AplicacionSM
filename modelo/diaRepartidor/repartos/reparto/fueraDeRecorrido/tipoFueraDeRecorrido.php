<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


class TipoFueraDeRecorrido extends Conector
{

    function __construct($id=null)
    {
    parent::__construct();
    if(parent::abrirConexion())
        {
        if($id!=null)
          {
          $this->id = $id;

          $sql = "SELECT * FROM TipoFueraDeRecorrido WHERE Id = '$id'";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->tipo = $row["Tipo"];
              }
          }
        }
    }

    private $tipo;

    public function getTipo()
    {
    return $this->tipo;
    }

    private $id;

    public function getId()
    {
    return $this->id;
    }



}


?>
