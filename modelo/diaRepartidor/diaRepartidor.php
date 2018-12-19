<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/trabajadores/trabajador.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/cargamento/cargamento.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/gastos/gastos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/repartos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/pagos/pagos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/deudaProductos/deudasProductos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/observaciones/observaciones.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/pagosAlquileres/pagosAlquileres.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/visitas/visitas.php');

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/adelantoSueldo/adelantoSueldo.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');



class DiaRepartidor extends GenericoDiaRepartidor
{

    function __construct()
    {
    parent::__construct();

    $this->cargamento = new Cargamento();
    $this->repartos = new Repartos();
    $this->gastos = new Gastos();
    $this->pagos = new Pagos();
    $this->adelantoSueldo = new AdelantoSueldo();
    $this->deudasProductos = new DeudasProductosDiaRepartidor();
    $this->observaciones = new ObservacionesClienteDiaRepartidor();

    $this->diaCreado = false;
    $this->diaCompletado = false;


    $this->retornablesRepartidos = new Retornables();
    $this->descartablesRepartidos = new Descartables();
    $this->retornablesVendidos = new Retornables();
    $this->descartablesVendidos = new Descartables();
    $this->retornablesBonificados = new Retornables();
    $this->descartablesBonificados = new Descartables();
    $this->retornablesAlquiler = new Retornables();
    $this->retornablesVacios = new Retornables();
    $this->retornablesDeudados = new Retornables();
    $this->descartablesDeudados = new Descartables();

    $this->clientesFueraDeRecorrido = new Items();

    $this->visitas = new Visitas();
    $this->pagosAlquileres = new PagosAlquileresDiaRepartidor();

    }



    private $diaCreado;
    private $diaCompletado;

    private $cargamento;
    private $repartos;
    private $gastos;
    private $pagos;
    private $adelantoSueldo;
    private $deudasProductos;
    private $observaciones;
    private $pagosAlquileres;
    private $visitas;


    public function getVisitas()
    {
    return $this->visitas;
    }

    public function getPagosAlquileres()
    {
    return $this->pagosAlquileres;
    }


    public function getObservaciones()
    {
    return $this->observaciones;
    }
    //Dinero
    private $dineroVentas=0;
    private $dineroPagos=0;
    private $dineroPagosAlquiler=0;
    private $dineroPagosDeudaProductos=0;

    public function getDineroTotalRecaudado()
    {
    return $this->dineroVentas + $this->dineroPagos;
    }

    public function getDineroAPresentar()
    {
    return $this->getDineroTotalRecaudado() - $this->getDineroGastos();
    }

    public function getDineroGastos(){return $this->gastos->getDinero();}
    public function getDineroPagos(){return $this->dineroPagos;}

    public function getDineroVentas(){return $this->dineroVentas;}
    public function getDineroPagosAlquiler(){return $this->dineroPagosAlquiler;}
    public function getDineroPagosDeudaProductos(){return $this->dineroPagosDeudaProductos;}

    public function getDeudasProductos(){return $this->deudasProductos;}

    //Productos Repartidos

    private $retornablesRepartidos;
    private $descartablesRepartidos;


    private $retornablesVendidos;
    private $descartablesVendidos;

    private $retornablesBonificados;
    private $descartablesBonificados;

    private $retornablesAlquiler;
    private $retornablesVacios;

    private $retornablesDeudados;
    private $descartablesDeudados;


    public function getRetornablesRepartidos(){return $this->retornablesRepartidos;}
    public function getDescartablesRepartidos(){return $this->descartablesRepartidos;}

    public function getRetornablesVendidos(){return $this->retornablesVendidos;}
    public function getDescartablesVendidos(){return $this->descartablesVendidos;}

    public function getRetornablesBonificados(){return $this->retornablesBonificados;}
    public function getDescartablesBonificados(){return $this->descartablesBonificados;}

    public function getRetornablesAlquiler(){return $this->retornablesAlquiler;}
    public function getRetornablesVacios(){return $this->retornablesVacios;}

    public function getRetornablesDeudados(){return $this->retornablesDeudados;}
    public function getDescartablesDeudados(){return $this->descartablesDeudados;}


    //Clientes Fuera de Recorrido

    private $clientesFueraDeRecorrido;

    public function getClientesFueraDeRecorrido(){return $this->clientesFueraDeRecorrido;}
    public function getNumeroClientesFueraDeRecorrido(){return $this->numeroClientesFueraDeRecorrido;}



    public function getCargamento(){return $this->cargamento;}
    public function getRepartos(){return $this->repartos;}
    public function getGastos(){return $this->gastos;}
    public function getPagos(){return $this->pagos;}
    public function getAdelantoSueldo(){return $this->adelantoSueldo;}




    public function getDiaCreado(){return $this->diaCreado;}
    public function getDiaCompletado(){return $this->diaCompletado;}

    public function setDiaCreado($diaCreado){$this->diaCreado = $diaCreado;}
    public function setDiaCompletado($diaCompletado){$this->diaCompletado = $diaCompletado;}

    public function probar(){return parent::a();}

    public function cargar()
    {
    $aux = true;

    try
      {
      if(parent::abrirConexion())
          {
          $idRepartidor = $this->repartidor->getId();
          $sql = "SELECT * FROM DiaRepartidor WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
          $tablaDR= $this->conexion->query($sql);
          if($tablaDR->num_rows>0)
              {
              $rowDR = $tablaDR->fetch_assoc();
              $this->diaCreado = $rowDR["Estado_Planilla_Creada"];
              $this->diaCompletado = $rowDR["Estado_Planilla_Completada"];


              //// continuar la carga

              /////Deudas Productos

              $this->deudasProductos = new DeudasProductosDiaRepartidor($idRepartidor,$this->fecha);

              /////Observaciones

              $this->observaciones = new ObservacionesClienteDiaRepartidor($idRepartidor,$this->fecha);

              /////Visitas

              $this->visitas = new Visitas($idRepartidor,$this->fecha);

              /////Pagos Alquileres


              $this->pagosAlquileres = new PagosAlquileresDiaRepartidor($idRepartidor,$this->fecha);
              $this->dineroPagosAlquiler = $this->pagosAlquileres->getDineroTotal();
              $this->dineroPagos += $this->dineroPagosAlquiler;


              /////GASTOS

              $this->gastos->setRepartidor($this->repartidor);
              $this->gastos->setFecha($this->fecha);
              $aux &= $this->gastos->cargar();

              /////CARGAMENTO

              $this->cargamento->setRepartidor($this->repartidor);
              $this->cargamento->setFecha($this->fecha);
              $aux &= $this->cargamento->cargar();

              /////REPARTOS

              $sql = "SELECT SUM(NBidon20L),SUM(NBidon12L),SUM(NBidon10L),SUM(NBidon8L),SUM(NBidon5L),SUM(NPackBotellas2L),SUM(NPackBotellas500mL),SUM(NBidon20L_B),SUM(NBidon12L_B),SUM(NBidon10L_B),SUM(NBidon8L_B),SUM(NBidon5L_B),SUM(NPackBotellas2L_B),SUM(NPackBotellas500mL_B),SUM(NBidon20L_V),SUM(NBidon12L_V),SUM(NBidon20L_A),SUM(NBidon12L_A),SUM(DineroProductos) FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
              $tablaPD = $this->conexion->query($sql);
              if($tablaPD->num_rows>0)
                  {
                  $rowPD = $tablaPD->fetch_assoc();

                  $this->retornablesVendidos->setBidon20L($rowPD["SUM(NBidon20L)"]);
                  $this->retornablesVendidos->setBidon12L($rowPD["SUM(NBidon12L)"]);
                  $this->descartablesVendidos->setBidon10L($rowPD["SUM(NBidon10L)"]);
                  $this->descartablesVendidos->setBidon8L($rowPD["SUM(NBidon8L)"]);
                  $this->descartablesVendidos->setBidon5L($rowPD["SUM(NBidon5L)"]);
                  $this->descartablesVendidos->setPackBotellas2L($rowPD["SUM(NPackBotellas2L)"]);
                  $this->descartablesVendidos->setPackBotellas500mL($rowPD["SUM(NPackBotellas500mL)"]);

                  $this->retornablesBonificados->setBidon20L($rowPD["SUM(NBidon20L_B)"]);
                  $this->retornablesBonificados->setBidon12L($rowPD["SUM(NBidon12L_B)"]);
                  $this->descartablesBonificados->setBidon10L($rowPD["SUM(NBidon10L_B)"]);
                  $this->descartablesBonificados->setBidon8L($rowPD["SUM(NBidon8L_B)"]);
                  $this->descartablesBonificados->setBidon5L($rowPD["SUM(NBidon5L_B)"]);
                  $this->descartablesBonificados->setPackBotellas2L($rowPD["SUM(NPackBotellas2L_B)"]);
                  $this->descartablesBonificados->setPackBotellas500mL($rowPD["SUM(NPackBotellas500mL_B)"]);

                  $this->retornablesVacios->setBidon20L($rowPD["SUM(NBidon20L_V)"]);
                  $this->retornablesVacios->setBidon12L($rowPD["SUM(NBidon12L_V)"]);

                  $this->retornablesAlquiler->setBidon20L($rowPD["SUM(NBidon20L_A)"]);
                  $this->retornablesAlquiler->setBidon12L($rowPD["SUM(NBidon12L_A)"]);

                  $this->retornablesRepartidos->setBidon20L($this->retornablesVendidos->getBidon20L() + $this->retornablesBonificados->getBidon20L() + $this->retornablesAlquiler->getBidon20L());
                  $this->retornablesRepartidos->setBidon12L($this->retornablesVendidos->getBidon12L() + $this->retornablesBonificados->getBidon12L() + $this->retornablesAlquiler->getBidon12L());
                  $this->descartablesRepartidos->setBidon10L($this->descartablesVendidos->getBidon10L() + $this->descartablesBonificados->getBidon10L());
                  $this->descartablesRepartidos->setBidon8L($this->descartablesVendidos->getBidon8L() + $this->descartablesBonificados->getBidon8L());
                  $this->descartablesRepartidos->setBidon5L($this->descartablesVendidos->getBidon5L() + $this->descartablesBonificados->getBidon5L());
                  $this->descartablesRepartidos->setPackBotellas2L($this->descartablesVendidos->getPackBotellas2L() + $this->descartablesBonificados->getPackBotellas2L());
                  $this->descartablesRepartidos->setPackBotellas500mL($this->descartablesVendidos->getPackBotellas500mL() + $this->descartablesBonificados->getPackBotellas500mL());

                  $this->dineroVentas = $rowPD["SUM(DineroProductos)"];

                  }

              /////Clientes Fuera de Recorrido

              $sql = "SELECT * FROM ClientesFueraDeRecorrido WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
              $tablaFR = $this->conexion->query($sql);
              if($tablaFR->num_rows>0)
                  {$k=1;
                  while($rowFR = $tablaFR->fetch_assoc())
                    {
                    $direccion = new Direccion($rowFR["IdDireccion"]);
                    $idCliente = $rowFR["IdCliente"];
                    $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente'";
                    $tablaC = $this->conexion->query($sql);
                    $rowC = $tablaC->fetch_assoc();
                    $item = new Item();

                    $descripcion = $idCliente . " " . $rowC["Nombre"] . " " . $rowC["Apellido"];
                    $descripcion .="<br>".$direccion->toString();
                    $item->setTitulo("Cliente ". ($k));
                    $item->setDescripcion($descripcion);
                    $item->setDescripcionOculta($rowFR["Mensaje"]);
                    $item->setId($idCliente);
                    $this->clientesFueraDeRecorrido->addItem($item);
                    $k++;
                    }
                  }


              }
          else
              {
              $this->diaCreado = false;
              $this->diaCompletado = false;
              }

          }
        else
          {
          $aux = false;
          }
      }
    catch(Exception $e)
      {
      $aux = false;
      }

    return $aux;
    }





    ///Metodos Generico



    public function guardar(){return true;}
    public function modificar(){return true;}
    public function eliminar(){return true;}
    public function getEstado(){return true;}
    public function actualizar(){return true;}
    public function getItem(){return new Item();}

    ///Metodos GenericoEvaluar

    public function evaluar(){return true;}
    public function getEvaluar(){return $this->evaluar;}

    //Balance


    public function getBalanceBidones20LVacios()
    {
    return $this->retornablesVacios->getBidon20L() - $this->cargamento->getDescargas()->getRetornablesVacios()->getBidon20L();
    }

    public function getBalanceBidones12LVacios()
    {
    return $this->retornablesVacios->getBidon12L() - $this->cargamento->getDescargas()->getRetornablesVacios()->getBidon12L();
    }









    public function getBalanceBidones20L()
    {
    return $this->cargamento->getCargas()->getRetornables()->getBidon20L() - $this->retornablesRepartidos->getBidon20L() - $this->cargamento->getDescargas()->getRetornables()->getBidon20L();
    }
    public function getBalanceBidones12L()
    {
    return $this->cargamento->getCargas()->getRetornables()->getBidon12L() - $this->retornablesRepartidos->getBidon12L() - $this->cargamento->getDescargas()->getRetornables()->getBidon12L();
    }

    public function getBalanceBidones10L()
    {
    return $this->cargamento->getCargas()->getDescartables()->getBidon10L() - $this->descartablesRepartidos->getBidon10L() - $this->cargamento->getDescargas()->getDescartables()->getBidon10L();
    }

    public function getBalanceBidones8L()
    {
    return $this->cargamento->getCargas()->getDescartables()->getBidon8L() - $this->descartablesRepartidos->getBidon8L() - $this->cargamento->getDescargas()->getDescartables()->getBidon8L();
    }

    public function getBalanceBidones5L()
    {
    return $this->cargamento->getCargas()->getDescartables()->getBidon5L() - $this->descartablesRepartidos->getBidon5L() - $this->cargamento->getDescargas()->getDescartables()->getBidon5L();
    }

    public function getBalancePackBotellas2L()
    {
    return $this->cargamento->getCargas()->getDescartables()->getPackBotellas2L() - $this->descartablesRepartidos->getPackBotellas2L() - $this->cargamento->getDescargas()->getDescartables()->getPackBotellas2L();
    }
    public function getBalancePackBotellas500mL()
    {
    return $this->cargamento->getCargas()->getDescartables()->getPackBotellas500mL() - $this->descartablesRepartidos->getPackBotellas500mL() - $this->cargamento->getDescargas()->getDescartables()->getPackBotellas500mL();
    }








}


?>
