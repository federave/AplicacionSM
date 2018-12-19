<?php
include_once('tipoFueraDeRecorrido.php');


class TiposFueraDeRecorrido extends Conector
{


    function __construct()
    {
    parent::__construct();


    if(parent::abrirConexion())
        {
        $sql = "SELECT Id FROM TipoFueraDeRecorrido";
        $tabla = $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $k=0;
            while($row = $tabla->fetch_assoc())
                {
                $tipo = new TipoFueraDeRecorrido($row["Id"]);
                $this->tipos[$k] = $tipo;
                $k++;
                }
            $this->numero=$k;
            }
        }
    }

    private $tipos = array();
    private $numero;


    public function getTipos()
    {
    return $this->tipos;
    }

    public function getNumero()
    {
    return $this->numero;
    }

    public function getTipo($k)
    {
    return $this->tipos[$k];
    }


}


?>
