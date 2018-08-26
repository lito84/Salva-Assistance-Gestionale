<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
        $("#contenitore").load("form/strutture/strutture.php");
    });

    $(".filtro").bind("change", function(){
    	alert($(this).va());
    	 $("#contenitore").empty().load("form/strutture/strutture.php?attivo="+$(this).val());
    })
</script>
 <div id="wrapper">
 <?php include("includes/menu_side.php");?>
       
        <!-- Page Content -->
        <div id="page-content-wrapper">
        	<div class="container-fluid">
				<div class="page-header">
				  <h1>Strutture MigliorSalute</h1>
				</div>
				
					
				
					<div class="row">
								<div class="form-group col-xs-12">
									<select class="filtro">
									    <option value="tutte">Tutte</option>
									    <option value="1">Attive</option>
									    <option value="0">Non Attive</option>
									</select>
								</div>
								<div id="contenitore" class="col-xs-12"></div>
						
					</div>
				</div>
        </div>
</div>

