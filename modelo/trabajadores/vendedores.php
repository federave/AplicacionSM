<?php
include_once('trabajador.php');


class Vendedores extends Conector
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
            $vendedor = new Trabajador($row["IdEmpleado"]);
            if($vendedor->getIdCategoria() == 2)
              {
              $this->vendedores[$k] = $vendedor;
              $k++;
              }
            }
        $this->numeroVendedores=$k;
        }
      }
    }

    private $vendedores = array();
    private $numeroVendedores;


    public function getVendedores()
    {
    return $this->vendedores;
    }

    public function getNumeroVendedores()
    {
    return $this->numeroVendedores;
    }

    public function getVendedor($k)
    {
    return $this->vendedores[$k];
    }




}

?>
