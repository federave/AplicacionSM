<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');


abstract class BaseProduct
{
  abstract protected function getEstado();
  abstract protected function have();
  abstract protected function add($x);

}


class Alquileres extends BaseProduct
{


      function __construct()
      {
      }


      public function getEstado()
      {
      if($this->alquiler6Bidones >= 0 && $this->alquiler8Bidones >= 0 && $this->alquiler10Bidones >= 0 && $this->alquiler12Bidones >= 0 )
        return true;
      else
        return false;
      }

      public function have()
      {
      if($this->alquiler6Bidones > 0 || $this->alquiler8Bidones > 0 || $this->alquiler10Bidones > 0 || $this->alquiler12Bidones >= 0 )
        return true;
      else
        return false;
      }

      public function add($x)
      {
      try
        {
        $this->alquiler6Bidones+=$x->getAlquiler6Bidones();
        $this->alquiler8Bidones+=$x->getAlquiler8Bidones();
        $this->alquiler10Bidones+=$x->getAlquiler10Bidones();
        $this->alquiler12Bidones+=$x->getAlquiler12Bidones();
        }
     catch (Exception $e)
        {
        }
      }


      private $alquiler6Bidones=0;
      private $alquiler8Bidones=0;
      private $alquiler10Bidones=0;
      private $alquiler12Bidones=0;

      public function getAlquiler6Bidones()
      {
      return $this->alquiler6Bidones;
      }
      public function getAlquiler8Bidones()
      {
      return $this->alquiler8Bidones;
      }
      public function getAlquiler10Bidones()
      {
      return $this->alquiler10Bidones;
      }
      public function getAlquiler12Bidones()
      {
      return $this->alquiler12Bidones;
      }

      public function setAlquiler6Bidones($precio)
      {
      $this->alquiler6Bidones = $precio;
      }
      public function setAlquiler8Bidones($precio)
      {
      $this->alquiler8Bidones = $precio;
      }
      public function setAlquiler10Bidones($precio)
      {
      $this->alquiler10Bidones = $precio;
      }
      public function setAlquiler12Bidones($precio)
      {
      $this->alquiler12Bidones = $precio;
      }



}

class Retornables extends BaseProduct
{


      function __construct()
      {
      }





      public function getEstado()
      {
      if($this->bidon20L >= 0 && $this->bidon12L >= 0)
        return true;
      else
        return false;
      }

      public function have()
      {
      if($this->bidon20L > 0 || $this->bidon12L > 0 )
        return true;
      else
        return false;
      }

      public function add($x)
      {
      try
        {
        $this->bidon20L+=$x->getBidon20L();
        $this->bidon12L+=$x->getBidon12L();
        }
     catch (Exception $e)
        {
        }
      }










      private $bidon20L=0;
      private $bidon12L=0;


      public function getBidon20L()
      {
      return $this->bidon20L;
      }
      public function getBidon12L()
      {
      return $this->bidon12L;
      }


      public function setBidon20L($precio)
      {
      $this->bidon20L = $precio;
      }
      public function setBidon12L($precio)
      {
      $this->bidon12L = $precio;
      }




}





class Descartables extends BaseProduct
{

      function __construct()
      {
      }




      public function getEstado()
      {
      if($this->bidon10L >= 0 && $this->bidon8L >= 0 && $this->bidon5L >= 0 && $this->packBotellas2L >= 0 && $this->packBotellas500mL >= 0)
        return true;
      else
        return false;
      }

      public function have()
      {
      if($this->bidon10L > 0 || $this->bidon8L > 0 || $this->bidon5L > 0 || $this->packBotellas2L > 0 || $this->packBotellas500mL > 0)
        return true;
      else
        return false;
      }


      public function add($x)
      {
      try
        {
        $this->bidon10L+=$x->getBidon10L();
        $this->bidon8L+=$x->getBidon8L();
        $this->bidon5L+=$x->getBidon5L();
        $this->packBotellas2L+=$x->getPackBotellas2L();
        $this->packBotellas500mL+=$x->getPackBotellas500mL();
        }
     catch (Exception $e)
        {
        }
      }







      private $bidon10L=0;
      private $bidon8L=0;
      private $bidon5L=0;
      private $packBotellas2L=0;
      private $packBotellas500mL=0;

      public function getBidon10L()
      {
      return $this->bidon10L;
      }
      public function getBidon8L()
      {
      return $this->bidon8L;
      }
      public function getBidon5L()
      {
      return $this->bidon5L;
      }
      public function getPackBotellas2L()
      {
      return $this->packBotellas2L;
      }
      public function getPackBotellas500mL()
      {
      return $this->packBotellas500mL;
      }

      public function setBidon10L($precio)
      {
      $this->bidon10L = $precio;
      }
      public function setBidon8L($precio)
      {
      $this->bidon8L = $precio;
      }
      public function setBidon5L($precio)
      {
      $this->bidon5L = $precio;
      }
      public function setPackBotellas2L($precio)
      {
      $this->packBotellas2L = $precio;
      }
      public function setPackBotellas500mL($precio)
      {
      $this->packBotellas500mL = $precio;
      }



}













?>
