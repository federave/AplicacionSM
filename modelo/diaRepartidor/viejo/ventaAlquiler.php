<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/estructuraVenta.php');


class VentaAlquiler extends EstructuraVenta
{
    function __construct($fila=null)
    {
    parent::__construct();

    if($fila!=null)
      {

      $this->idRepartidor = $fila["IdEmpleado"];
      $this->idVendedor = $fila["IdEmpleado_Vendedor"];
      $this->idCliente = $fila["IdCliente"];
      $this->idDireccion = $fila["IdDireccion"];
      $this->fecha = $fila["Fecha"];

      $this->retornables = new RetornablesViejo();

      $this->alquiler =  false;



      $this->retornables->setBidones20L($fila["NBidon20L_A"]);
      $this->retornables->setBidones12L($fila["NBidon12L_A"]);





      $date = strtotime($this->fecha);
      $this->mes = date("m", $date);
      $this->year = date("Y", $date);


            $year = date("Y", $date);
            $mes = date("m", $date);

      if(parent::abrirConexion())
          {
          $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$this->idCliente' AND Mes = '$mes' AND Año = '$year' ";
          $tabla = $this->conexion->query($sql);
          $this->mes = $sql;

          if($tabla->num_rows>0)
              {
              $this->alquiler =  true;
              }
            else
              {
              $this->alquiler =  false;
              }
          }
      }



    }


    public function getMes(){return $this->mes;}

    protected $mes;
    protected $year;


    public function guardar(){}
    public function evaluar(){}
    public function cargar($datoXml){}

    protected $retornables;

    public function getRetornables(){return $this->retornables;}
    public function setRetornables($retornables){$this->retornables = $retornables;}

    protected $alquiler;

    public function getAlquiler(){return $this->alquiler;}
    public function setAlquiler($alquiler){$this->alquiler = $alquiler;}


}



?>
