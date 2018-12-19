<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');

class Usuario extends Generico
{


    function __construct($servidor=null)
    {
    parent::__construct();

    if($servidor!=null)
        $this->servidor = $servidor;

    $this->nombreBD = "BD_Usuarios";

    }


    public function ingresar($nombre,$password)
    {

    if(parent::abrirConexion())
        {
        $sql = "SELECT * FROM Usuarios WHERE Nombre = '$nombre' AND Contraseña = '$password'";

        $tabla = $this->conexion->query($sql);

        if($tabla->num_rows>0)
            {
            $row = $tabla->fetch_assoc();
            $this->nombre = $row["Nombre"];
            $this->password = $row["Contraseña"];
            $this->id = $row["IdUsuario"];
            return true;
            }
        else
            {
            return false;
            }
        }
      else
        {
        return false;
        }

    }

    private $nombre;
    private $password;

    public function getPassword()
    {
    return $this->password;
    }

    public function getNombre()
    {
    return $this->nombre;
    }

    public function getId()
    {
    return $this->id;
    }






        ///Metodos Generico

        public function cargar(){return true;}
        public function guardar(){return true;}
        public function modificar(){return true;}
        public function eliminar(){return true;}
        public function getEstado(){return true;}
        public function actualizar(){return true;}
        public function getItem(){return new Item();}









}

?>
