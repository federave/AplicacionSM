<?php
include_once('tipoInactivo.php');


class TipoInactivos extends Conector
{


    function __construct()
    {
    parent::__construct();


    if(parent::abrirConexion())
        {
        $sql = "SELECT Id FROM TipoInactivo";
        $tabla = $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $k=0;
            while($row = $tabla->fetch_assoc())
                {
                $tipoInactivo = new TipoInactivo($row["Id"]);
                $this->tipoInactivos[$k] = $tipoInactivo;
                $k++;
                }
            $this->numeroTipoInactivos=$k;
            }
        }
    }

    private $tipoInactivos = array();
    private $numeroTipoInactivos;


    public function getTipoInactivos()
    {
    return $this->tipoInactivos;
    }

    public function getNumeroTipoInactivos()
    {
    return $this->numeroTipoInactivos;
    }

    public function getTipoInactivo($k)
    {
    return $this->tipoInactivos[$k];
    }


}


?>
