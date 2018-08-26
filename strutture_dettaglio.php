<?php include("includes/setup.php");?>
<?php include("includes/menu.php");
$sql="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura='$_GET[id_struttura]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>

<style>
	div.row{margin-top: 10px; margin-bottom: 10px;}
</style>

<script>
    $(document).ready(function(){

    	document.title = '<?php echo addslashes($rows["RagioneSocialeStruttura"]);?> - Dettaglio scheda';

         $("#contenitore").empty().load("form/strutture/struttura_migliorsalute.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
    });
</script>
 <div id="wrapper">
 <?php include("includes/menu_side.php");?>
       
        <!-- Page Content -->
        <div id="page-content-wrapper">
        	<div class="container-fluid">
				<div class="page-header">
				  <h1><?php 
				  $sql="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura ='$_GET[id_struttura]'";
					$res=mysql_query($sql);
					$rows=mysql_fetch_array($res, MYSQL_ASSOC);
					echo utf8_encode($rows["RagioneSocialeStruttura"]);?></h1>
				</div>
					<div class="row">
							
								<div id="contenitore" class="col-xs-12"></div>
						
					</div>
				</div>
        </div>


    <!-- Modal -->
 <div id="myModalElimina" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Conferma eliminazione struttura <?php echo $rows["RagioneSocialeStruttura"];?></h4>
        </div>
        <div class="modal-body">
          <p>Rimuovere la struttura corrente e tutti i servizi ad essa collegata?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
           <button type="button" class="btn btn-warning elimina_struttura_confirm" data-dismiss="modal" data-id="<?php echo $IdAnagraficaStruttura;?>">Cancella struttura</button>
        </div>
      </div>

    </div>
  </div>

     <!-- Modal -->
 <div id="myModalDisattiva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">

    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Conferma eliminazione struttura <?php echo $rows["RagioneSocialeStruttura"];?></h4>
        </div>
        <div class="modal-body">
          <p>Disattivare la struttura corrente ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
           <button type="button" class="btn btn-warning disattiva_struttura_confirm" data-dismiss="modal" data-id="<?php echo $IdAnagraficaStruttura;?>">Cancella struttura</button>
        </div>
      </div>

    </div>
  </div>
</div>