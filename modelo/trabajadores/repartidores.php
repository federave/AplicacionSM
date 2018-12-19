<?php
include_once('trabajador.php');


class Repartidores extends Conector
{


    function __construct()
    {
    parent::__construct();


    if(parent::abrirConexion())
        {


    $sql = "SELECT IdEmpleado FROM Empleados";

    $tabla = $this->conexion->query($sql);

    if($tabla->num_rows>0)
        {
        $k=0;
        while($row = $tabla->fetch_assoc())
            {
            $repartidor = new Trabajador($row["IdEmpleado"]);
            if($repartidor->getIdCategoria() == 3 || $repartidor->getIdCategoria() == 4)
              {
              $this->repartidores[$k] = $repartidor;
              $k++;
              }
            }
        $this->numeroRepartidores=$k;
        }
    }
    }

    private $repartidores = array();
    private $numeroRepartidores;


    public function getRepartidores()
    {
    return $this->repartidores;
    }

    public function getNumeroRepartidores()
    {
    return $this->numeroRepartidores;
    }

    public function getRepartidor($k)
    {
    return $this->repartidores[$k];
    }




}

?>
