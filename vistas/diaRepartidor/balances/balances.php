




<script type="text/javascript">
  function mostrarBalances()
  {
  if(document.getElementById("divBalances").style.display == "block")
    document.getElementById("divBalances").style.display = "none";
  else
    document.getElementById("divBalances").style.display = "block";
  }
</script>

<div class="" style="margin:50px;">
  <button class="btn-link buttonLink" onclick="mostrarBalances()" style="font-size:20px;display:block">Balances</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divBalances">

  <div class="text-center" style="width:100%;margin-bottom:25px">
    <h3 class="subtitulo">Balances</h3>
  </div>

  <?php require 'balanceRepartos.php'; ?>
  <?php require 'balanceVacios.php'; ?>



</div>
