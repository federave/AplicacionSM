






<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/cargamento/cargas/carga.php');

class Cargas extends GenericoListaProductos
{

    function __construct()
    {
    parent::__construct();
    $this->nombreItem = "Carga"; 
    }




    ///Metodos Generico

    public function cargar()
    {
    $aux = false;
    if(parent::abrirConexion())
        {
        $aux=true;
        $idRepartidor = $this->repartidor->getId();
        $sql = "SELECT * FROM Cargas WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
        $tabla= $this->conexion->query($sql);
        if($tabla->num_rows>0)
            {
            $k=0;
            while($row = $tabla->fetch_assoc())
              {
              $carga = new Carga($row["IdCarga"]);
              $this->lista[$k] = $carga;
              $k++;
              $this->retornables->add($carga->getRetornables());
              $this->descartables->add($carga->getDescartables());
              }
            $this->size=$k;
            }
        parent::cerrarConexion();
        }
    return $aux;
    }






    public function guardar(){return true;}
    public function modificar(){return true;}
    public function eliminar(){return true;}
    public function getEstado(){return true;}
    public function actualizar(){return true;}
    public function getItem(){return new Item();}

    ///Metodos GenericoEvaluar

    public function evaluar(){return true;}
    public function getEvaluar(){return $this->evaluar;}

}

?>
