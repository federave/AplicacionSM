<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/EstructuraGenerica.php');



class Planilla extends EstructuraGenerica
{

    function __construct($idRepartidor=null,$idVendedor=null,$fecha=null)
    {
    parent::__construct();

    if($idRepartidor!=null && $idVendedor!=null && $fecha != null)
      {

      $this->idRepartidor = $idRepartidor;

      if($idVendedor!=-1){$this->idVendedor = $idVendedor;}
      else{$this->idVendedor = $idRepartidor;}

      $this->fecha = $fecha;


      if(parent::abrirConexion())
          {
          $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND IdEmpleado_Vendedor = '$idVendedor' AND Fecha = '$fecha'";

          $tabla = $this->conexion->query($sql);

          if($tabla!=null)
            {
              if($tabla->num_rows>0)
                  {
                  $k=0;
                  while($row = $tabla->fetch_assoc())
                      {
                      $venta = new Venta($row);
                      $this->ventas[$k] = $venta;
                      $k++;
                      }
                  $this->numeroVentas=$k;

                  }
            }

          }
      }

    }

    protected $ventas = array();

    protected $numeroVentas = 0;

    public function getNumeroVentas(){return $this->numeroVentas;}
    public function setNumeroVentas($numeroVentas){$this->numeroVentas = $numeroVentas;}


    public function getVentas(){return $this->ventas;}
    public function setVentas($ventas){$this->ventas = $ventas;}

    public function guardar(){}
    public function evaluar(){}
    public function cargar($datoXml){}


    public function getNombre()
    {
    $var="";
    if(parent::abrirConexion())
        {
          $sql = "SELECT * FROM Empleados WHERE IdEmpleado = '$this->idVendedor'";

          $tabla = $this->conexion->query($sql);

          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $var = $row["Nombre"] . " " . $row["Apellido"];
              }

        }
    return $var;
    }




}


?>
