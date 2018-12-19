<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');

class Direccion extends Generico
{


    function __construct($id=null)
    {
    parent::__construct();

    if($id!=null)
        {
        $this->id = $id;

        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM TipoDirecciones WHERE IdDireccion = '$id' ";

            $tabla = $this->conexion->query($sql);

            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->idZona = $row["IdZona"];
                $this->calle = $row["Calle"];
                $this->entre1 = $row["Entre1"];
                $this->entre2 = $row["Entre2"];
                $this->numero = $row["Numero"];
                $this->departamento = $row["Departamento"];
                $this->piso = $row["Piso"];
                $this->localidad = $row["Localidad"];
                $this->codigoPostal = $row["CodigoPostal"];
                }
            }
        

          }

      }


    private $idZona;
    private $calle;
    private $entre1;
    private $entre2;
    private $numero;
    private $departamento;
    private $piso;
    private $localidad;
    private $codigoPostal;

    public function toString()
    {

    $var=" ";

    if($this->entre1 != "" && $this->entre1 != "")
      {
      $var .= "entre: " . $this->entre1 . " y " . $this->entre2;
      }
    else if ($this->entre1 != "")
      {
      $var .= "esquina: " . $this->entre1;
      }
    else if ($this->entre1 != "")
      {
      $var .= "esquina: " . $this->entre2;
      }
    else
      {

      }

      $var1="";
      if($this->departamento != "")
        {
        $var1 .= " departamento: " . $this->departamento;
        }

      $var2="";
      if($this->piso != -1)
        {
        $var2 .= " piso: " . $this->piso;
        }
    return $this->calle . $var . " N°: " . $this->numero . $var1 . $var2;
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
