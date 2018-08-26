<?php include("includes/setup.php");?>
<?php include("includes/menu.php");
?>

<script>
    $(document).ready(function(){
         $("#contenitore").empty().load("form/strutture_confermare/struttura_modifica.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
    });
</script>
 <div id="wrapper">
 <?php include("includes/menu_side.php");?>
       
        <!-- Page Content -->
        <div id="page-content-wrapper">
        	<div class="container-fluid">
				<div class="page-header">
				  <h1><?php 
				  	$sql="SELECT * FROM anagrafica_salute_semplice WHERE id_struttura ='$_GET[id_struttura]'";
					$res=mysql_query($sql);
					$rows=mysql_fetch_array($res, MYSQL_ASSOC);

				  	echo utf8_encode($rows["struttura"]);?></h1>
				</div>
					<div class="row">
							
								<div id="contenitore" class="col-xs-12"></div>
						
					</div>
				</div>
        </div>
</div>

