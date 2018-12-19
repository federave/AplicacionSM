<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');



class Trabajador extends Generico
{


    function __construct($id=null)
    {
    parent::__construct();


    if(parent::abrirConexion())
        {

      if($id!=null)
        {
        $sql = "SELECT * FROM Empleados WHERE IdEmpleado = '$id'";

        $tabla = $this->conexion->query($sql);

        if($tabla->num_rows>0)
            {
            $row = $tabla->fetch_assoc();
            $this->nombre = $row["Nombre"];
            $this->apellido = $row["Apellido"];
            $this->id = $row["IdEmpleado"];
            $this->dni = $row["DNI"];
            $this->idCategoria = $row["IdCategoria"];

            }
        }

      }




    }


    private $nombre;

    public function getNombre()
    {
    return $this->nombre;
    }

    private $apellido;

    public function getApellido()
    {
    return $this->apellido;
    }

    private $idCategoria;

    public function getIdCategoria()
    {
    return $this->idCategoria;
    }

    private $dni;

    public function getDni()
    {
    return $this->dni;
    }


    ///Metodos Generico

    public function cargar(){return true;}
    public function guardar(){return true;}
    public function modificar(){return true;}
    public function eliminar(){return true;}
    public function getEstado(){return true;}
    public function actualizar(){return true;}
    public function getItem(){return new Item();}

    public function toString()
    {
    return $this->nombre . " " . $this->apellido . " DNI: " . $this->dni;
    }





}


?>
