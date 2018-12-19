<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');



class Planillas extends Conector
{

    function __construct($idRepartidor=null,$fecha=null)
    {
    parent::__construct();

    if($idRepartidor!=null && $fecha != null)
      {
      $n=0;

      $planilla = new Planilla($idRepartidor,-1,$fecha);
      if($planilla->getNumeroVentas() > 0)
        {
        $this->planillas[0] = $planilla;
        $n++;
        }

      if(parent::abrirConexion())
          {
          $sql = " SELECT IdEmpleado FROM Empleados WHERE IdCategoria = '2' or IdCategoria = '3' or IdCategoria = '4' ";

          $tabla = $this->conexion->query($sql);

          if($tabla->num_rows>0)
              {
              $k=0;
              while($row = $tabla->fetch_assoc())
                  {
                  $idVendedor = $row["IdEmpleado"];
                  $planilla = new Planilla($idRepartidor,$idVendedor,$fecha);
                  if($planilla->getNumeroVentas() > 0)
                    {
                    $this->planillas[$n] = $planilla;
                    $n++;
                    }
                  $k++;
                  }
              $this->numeroPlanillas=$n;
              }
          }
      }

    }

    protected $planillas = array();
    protected $numeroPlanillas = 0;


    public function getPlanillas(){return $this->planillas;}
    public function setPlanillas($planillas){$this->planillas = $planillas;}

    public function getNumeroPlanillas(){return $this->numeroPlanillas;}
    public function setNumeroPlanillas($numeroPlanillas){$this->numeroPlanillas = $numeroPlanillas;}


}


?>
