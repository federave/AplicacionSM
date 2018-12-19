<?php
class Conector
{


    function __construct()
    {

    if(isset($_SESSION["conexion"]))
      {
      if($_SESSION["conexion"])
          {
          $this->servidor  = $_SESSION["servidor"];
          $this->usuario = $_SESSION["usuario"];
          $this->contraseña  = $_SESSION["contraseña"];
          $this->nombreBD = "BaseDeDatos_Administracion";
          $this->puerto = 3306;
          }
      else
          {
          $this->servidor  = "127.0.0.1";
          $this->usuario = "root";
          $this->contraseña  = "mpkfa26";
          $this->nombreBD = "BaseDeDatos_Administracion";
          $this->puerto = 3306;
          }
        }
    else
      {
        $this->servidor  = "127.0.0.1";
        $this->usuario = "root";
        $this->contraseña  = "mpkfa26";
        $this->nombreBD = "BaseDeDatos_Administracion";
        $this->puerto = 3306;
      }


    }


    protected $servidor;
    protected $usuario;
    protected $contraseña;
    protected $nombreBD;
    protected $puerto;
    protected $conexion;



    public function setServidor($servidor){$this->servidor = $servidor;}
    public function setUsuario($usuario){$this->usuario = $usuario;}
    public function setContraseña($contraseña){$this->contraseña = $contraseña;}
    public function setNombreBD($nombreBD){$this->nombreBD = $nombreBD;}
    public function setPuerto($puerto){$this->puerto = $puerto;}

    public function getServidor(){return $this->servidor;}
    public function getUsuario(){return $this->usuario;}
    public function getContraseña(){return $this->contraseña;}
    public function getNombreBD(){return $this->nombreBD;}
    public function getPuerto(){return $this->puerto;}





    public function abrirConexion()
    {

    $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contraseña,$this->nombreBD,$this->puerto);

    if($this->conexion->connect_error == false )
      {return true;}
    else
      {return false;}
    }


    public function cerrarConexion()
    {$this->conexion->close();}



    public function getConexion()
    {
    return $this->conexion;
    }




}


function debug($debug)
{
$conector = new Conector();
$aux = true;
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "INSERT INTO Debug(debug)VALUES('$debug')";
  $aux &= $conexion->query($sql);
  $conector->cerrarConexion();
  return $aux;
  }
else
  {
  return false;
  }
}






?>
