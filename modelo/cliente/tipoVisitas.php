<?php
include_once('tipoVisita.php');


class TipoVisitas extends Conector
{


    function __construct()
    {
    parent::__construct();


    if(parent::abrirConexion())
        {
        $sql = "SELECT Id FROM TipoVisita";
        $tabla = $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $k=0;
            while($row = $tabla->fetch_assoc())
                {
                $tipoVisita = new TipoVisita($row["Id"]);
                $this->tipoVisitas[$k] = $tipoVisita;
                $k++;
                }
            $this->numeroTipoVisitas=$k;
            }
        }
    }

    private $tipoVisitas = array();
    private $numeroTipoVisitas;


    public function getTipoVisitas()
    {
    return $this->tipoVisitas;
    }

    public function getNumeroTipoVisitas()
    {
    return $this->numeroTipoVisitas;
    }

    public function getTipoVisita($k)
    {
    return $this->tipoVisitas[$k];
    }


}


?>
