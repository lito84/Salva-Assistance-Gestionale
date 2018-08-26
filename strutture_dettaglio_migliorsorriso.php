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

         $("#contenitore").empty().load("form/strutture/struttura_migliorsorriso.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
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
</div>

