<?php

class RetornablesViejo
{

  function __construct()
  {
  $this->bidones20L = 0;
  $this->bidones12L = 0;
  }
  protected $bidones20L;
  protected $bidones12L;
  public function getBidones20L(){return $this->bidones20L;}
  public function setBidones20L($bidones20L){$this->bidones20L = $bidones20L;}
  public function getBidones12L(){return $this->bidones12L;}
  public function setBidones12L($bidones12L){$this->bidones12L = $bidones12L;}
}

class DescartablesViejo
{

  function __construct()
  {
  $this->bidones10L = 0;
  $this->bidones8L = 0;
  $this->bidones5L = 0;
  $this->packBotellas2L = 0;
  $this->packBotellas500mL = 0;
  }

  protected $bidones10L;
  protected $bidones8L;
  protected $bidones5L;
  protected $packBotellas2L;
  protected $packBotellas500mL;


  public function getBidones10L(){return $this->bidones10L;}
  public function setBidones10L($bidones10L){$this->bidones10L = $bidones10L;}

  public function getBidones8L(){return $this->bidones8L;}
  public function setBidones8L($bidones8L){$this->bidones8L = $bidones8L;}

  public function getBidones5L(){return $this->bidones5L;}
  public function setBidones5L($bidones5L){$this->bidones5L = $bidones5L;}

  public function getPackBotellas2L(){return $this->packBotellas2L;}
  public function setPackBotellas2L($packBotellas2L){$this->packBotellas2L = $packBotellas2L;}

  public function getPackBotellas500mL(){return $this->packBotellas500mL;}
  public function setPackBotellas500mL($packBotellas500mL){$this->packBotellas500mL = $packBotellas500mL;}


}




class ProductosViejo
{

  function __construct()
  {
  $this->retornables = new RetornablesViejo();
  $this->descartables = new DescartablesViejo();
  }

  protected $retornables;
  protected $descartables;

  public function getRetornables(){return $this->retornables;}
  public function setRetornables($retornables){$this->retornables = $retornables;}

  public function getDescartables(){return $this->descartables;}
  public function setDescartables($descartables){$this->descartables = $descartables;}



}



?>
