

<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/precios/precios.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/trabajadores/trabajador.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/productos/productos.php');



class DeudaProductos extends GenericoProductos
{

  function __construct($id=null)
  {

  $this->retornablesPagados = new Retornables();
  $this->descartablesPagados = new Descartables();
  $this->precioRetornables = new PrecioRetornables();
  $this->precioDescartables = new PrecioDescartables();

  $this->repartidor = new Trabajador();





  parent::__construct();
  if($id!=null)
    {
    $this->id = $id;
    if(parent::abrirConexion())
        {
        $sql = "SELECT * FROM Deudas_Productos WHERE IdDeuda = '$id'";
        $tabla = $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $row = $tabla->fetch_assoc();

            $this->idCliente = $row["IdCliente"];
            $this->repartidor = new Trabajador($row["IdEmpleado"]);
            $this->fecha = $row["Fecha"];



            $this->retornables->setBidon20L($row["NBidon20L"]);
            $this->retornables->setBidon12L($row["NBidon12L"]);
            $this->descartables->setBidon10L($row["NBidon10L"]);
            $this->descartables->setBidon8L($row["NBidon8L"]);
            $this->descartables->setBidon5L($row["NBidon5L"]);
            $this->descartables->setPackBotellas2L($row["NPackBotellas2L"]);
            $this->descartables->setPackBotellas500mL($row["NPackBotellas500mL"]);

            $this->retornablesPagados->setBidon20L($row["NBidon20L_P"]);
            $this->retornablesPagados->setBidon12L($row["NBidon12L_P"]);
            $this->descartablesPagados->setBidon10L($row["NBidon10L_P"]);
            $this->descartablesPagados->setBidon8L($row["NBidon8L_P"]);
            $this->descartablesPagados->setBidon5L($row["NBidon5L_P"]);
            $this->descartablesPagados->setPackBotellas2L($row["NPackBotellas2L_P"]);
            $this->descartablesPagados->setPackBotellas500mL($row["NPackBotellas500mL_P"]);

            $this->precioRetornables->setBidon20L($row["PBidon20L"]);
            $this->precioRetornables->setBidon12L($row["PBidon12L"]);
            $this->precioDescartables->setBidon10L($row["PBidon10L"]);
            $this->precioDescartables->setBidon8L($row["PBidon8L"]);
            $this->precioDescartables->setBidon5L($row["PBidon5L"]);
            $this->precioDescartables->setPackBotellas2L($row["PPackBotellas2L"]);
            $this->precioDescartables->setPackBotellas500mL($row["PPackBotellas500mL"]);


            $this->dinero = $row["DineroTotal"];
            $this->estado = $row["Estado_Deuda"];

            $sql = "SELECT Nombre,Apellido FROM Clientes WHERE IdCliente = '$this->idCliente'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->nombreCliente=$row["Nombre"]." ".$row["Apellido"];
                }


            }
        }
    }
  }


     public function getFecha(){return $this->fecha;}
     public function getRepartidor(){return $this->repartidor;}
     public function getIdCliente(){return $this->idCliente;}
     public function getNombreCliente(){return $this->nombreCliente;}
     public function getEstado(){return $this->estado;}
     public function getRetornablesPagados(){return $this->retornablesPagados;}
     public function getDescartablesPagados(){return $this->descartablesPagados;}
     public function getPrecioRetornables(){return $this->precioRetornables;}
     public function getPrecioDescartables(){return $this->precioDescartables;}



     protected $fecha;
     protected $repartidor;
     protected $idCliente;
     protected $nombreCliente="";

     protected $estado;

     protected $retornablesPagados;
     protected $descartablesPagados;

     protected $precioRetornables;
     protected $precioDescartables;


     ///Metodos Generico

     public function cargar(){return true;}
     public function guardar(){return true;}
     public function modificar(){return true;}
     public function eliminar(){return true;}
     public function actualizar(){return true;}


      ///Metodos GenericoEvaluar

      public function evaluar(){return true;}
      public function getEvaluar(){return $this->evaluar;}



     public function getItem()
     {
     $item = new Item();

     $descripcion = $this->idCliente . " " . $this->nombreCliente."<br>Fecha: ".$this->fecha."<br>";

     if($this->retornables->getBidon20L() >0)
     $descripcion .= "<br>Bidones 20L Deudados: " . $this->retornables->getBidon20L();
     if($this->retornables->getBidon12L() >0)
     $descripcion .= "<br>Bidones 12L Deudados: " . $this->retornables->getBidon12L();
     if($this->descartables->getBidon10L() >0)
     $descripcion .= "<br>Bidones 10L Deudados: " . $this->descartables->getBidon10L();
     if($this->descartables->getBidon8L() >0)
     $descripcion .= "<br>Bidones 8L Deudados: " . $this->descartables->getBidon8L();
     if($this->descartables->getBidon5L() >0)
     $descripcion .= "<br>Bidones 5L Deudados: " . $this->descartables->getBidon5L();
     if($this->descartables->getPackBotellas2L() >0)
     $descripcion .= "<br>Pack Botellas 2L Deudados: " . $this->descartables->getPackBotellas2L();
     if($this->descartables->getPackBotellas500mL() >0)
     $descripcion .= "<br>Pack Botellas 500mL Deudados: " . $this->descartables->getPackBotellas500mL();

     $item->setDescripcion($descripcion);


     $descripcionOculta ="";
     if($this->retornables->getBidon20L() >0)
     $descripcionOculta .= "<br>Bidones 20L Pagados: " . $this->retornablesPagados->getBidon20L();
     if($this->retornables->getBidon12L() >0)
     $descripcionOculta .= "<br>Bidones 12L Pagados: " . $this->retornablesPagados->getBidon12L();
     if($this->descartables->getBidon10L() >0)
     $descripcionOculta .= "<br>Bidones 10L Pagados: " . $this->descartablesPagados->getBidon10L();
     if($this->descartables->getBidon8L() >0)
     $descripcionOculta .= "<br>Bidones 8L Pagados: " . $this->descartablesPagados->getBidon8L();
     if($this->descartables->getBidon5L() >0)
     $descripcionOculta .= "<br>Bidones 5L Pagados: " . $this->descartablesPagados->getBidon5L();
     if($this->descartables->getPackBotellas2L() >0)
     $descripcionOculta .= "<br>Pack Botellas 2L Pagados: " . $this->descartablesPagados->getPackBotellas2L();
     if($this->descartables->getPackBotellas500mL() >0)
     $descripcionOculta .= "<br>Pack Botellas 500mL Pagados: " . $this->descartablesPagados->getPackBotellas500mL();

     $descripcionOculta .= "<br>";

     if($this->retornables->getBidon20L() >0)
     $descripcionOculta .= "Precio Bidon 20L: " . $this->precioRetornables->getBidon20L();
     if($this->retornables->getBidon12L() >0)
     $descripcionOculta .= "<br>Precio Bidon 12L: " . $this->precioRetornables->getBidon12L();
     if($this->descartables->getBidon10L() >0)
     $descripcionOculta .= "<br>Precio Bidon 10L: " . $this->precioDescartables->getBidon10L();
     if($this->descartables->getBidon8L() >0)
     $descripcionOculta .= "<br>Precio Bidon 8L: " . $this->precioDescartables->getBidon8L();
     if($this->descartables->getBidon5L() >0)
     $descripcionOculta .= "<br>Precio Bidon 5L: " . $this->precioDescartables->getBidon5L();
     if($this->descartables->getPackBotellas2L() >0)
     $descripcionOculta .= "<br>Precio Pack Botellas 2L: " . $this->precioDescartables->getPackBotellas2L();
     if($this->descartables->getPackBotellas500mL() >0)
     $descripcionOculta .= "<br>Precio Pack Botellas 500mL: " . $this->precioDescartables->getPackBotellas500mL();

     $descripcionOculta .= "<br><br>";
     $descripcionOculta .= "Dinero Total: " . $this->dinero;


     $item->setDescripcionOculta($descripcionOculta);
     $item->setId($this->id);
     return $item;
     }

}

?>
