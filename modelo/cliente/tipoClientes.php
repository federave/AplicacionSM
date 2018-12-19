<?php
include_once('tipoCliente.php');


class TipoClientes extends Conector
{


    function __construct()
    {
    parent::__construct();


    if(parent::abrirConexion())
        {
        $sql = "SELECT IdTipoCliente FROM TipoClientes";
        $tabla = $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $k=0;
            while($row = $tabla->fetch_assoc())
                {
                $tipoCliente = new TipoCliente($row["IdTipoCliente"]);
                $this->tipoClientes[$k] = $tipoCliente;
                $k++;
                }
            $this->numeroTipoClientes=$k;
            }
        }
    }

    private $tipoClientes = array();
    private $numeroTipoClientes;


    public function getTipoClientes()
    {
    return $this->tipoClientes;
    }

    public function getNumeroTipoClientes()
    {
    return $this->numeroTipoClientes;
    }

    public function getTipoCliente($k)
    {
    return $this->tipoClientes[$k];
    }


}


?>
