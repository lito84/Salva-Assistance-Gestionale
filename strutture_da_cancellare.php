<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
        $("#contenitore").load("form/strutture/strutture_da_cancellare.php");
    });
</script>
 <div id="wrapper">
 <?php include("includes/menu_side.php");?>
       
        <!-- Page Content -->
        <div id="page-content-wrapper">
        	<div class="container-fluid">
				<div class="page-header">
				  <h1>Strutture da cancellare</h1>
				</div>
					<div class="row">
							
								<div id="contenitore" class="col-xs-12"></div>
						
					</div> 	
				</div>
        </div>
</div>

