<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/tipoCliente.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/trabajadores/trabajador.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/datosAlquiler.php');




class Datos extends Generico
{

  function __construct($idCliente=null,$idDireccion=null,$fecha=null)
  {
    parent::__construct();



    if($idCliente!=null && $fecha!=null && $idDireccion!=null)
        {
        $this->id = $idCliente;
        $this->datosAlquiler = new DatosAlquiler();



        if(parent::abrirConexion())
            {



            $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();

                $this->nombre = $row["Nombre"];
                $this->apellido = $row["Apellido"];
                $this->dni = $row["DNI"];
                $this->email = $row["Email"];
                $this->telefono1 = $row["Telefono1"];
                $this->telefono2 = $row["Telefono2"];
                $this->activo = $row["Activo"];

                $idEmpleado = $row["IdEmpleado"];

                $this->tipoCliente = new TipoCliente($row["IdTipoCliente"]);
                $this->repartidor = new Trabajador($idEmpleado);

                if($row["Estado_AcuerdoDispenser"] == 1)
                  {
                  $this->datosAlquiler = new DatosAlquiler($idCliente,$fecha);
                  }

                $sql = "SELECT * FROM Repartos WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion'";
                $tabla = $this->conexion->query($sql);
                if($tabla->num_rows>0)
                    {
                    $k=0;
                    while($row = $tabla->fetch_assoc())
                        {
                        $repartidor = new Trabajador($row["IdEmpleado"]);
                        $this->diasReparto[$k] = $row["Dia"] . " " . $repartidor->toString();
                        $k++;
                        }
                    $this->numeroDiasReparto=$k;
                    }
                }

            }


          }



  }


  private $datosAlquiler;

  protected $tipoCliente;
  protected $repartidor;
  protected $diasReparto = array();
  protected $numeroDiasReparto = 0;
  protected $nombre;
  protected $apellido;
  protected $telefono1;
  protected $telefono2;
  protected $dni;
  protected $email;
  protected $activo;

  private $prueba="";
  public function getPrueba(){return $this->prueba;}

  public function getActivo(){return $this->activo;}

  public function getDatosAlquiler(){return $this->datosAlquiler;}

  public function getNumeroDiasReparto(){return $this->numeroDiasReparto;}
  public function getDiaReparto($k)
  {
  if($k < $this->numeroDiasReparto)
    {
    return $this->diasReparto[$k];
    }
  else
    {
    return null;
    }

  }




  public function getTipoCliente(){return $this->tipoCliente;}
  public function getRepartidor(){return $this->repartidor;}
  public function getNombre(){return $this->nombre;}
  public function getApellido(){return $this->apellido;}
  public function getTelefono1(){return $this->telefono1;}
  public function getTelefono2(){return $this->telefono2;}
  public function getDNI(){return $this->dni;}
  public function getEmail(){return $this->email;}
















  ///Metodos Generico
  public function actualizar(){return true;}

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return true;}
  public function getItem(){return new Item();}






}
?>
