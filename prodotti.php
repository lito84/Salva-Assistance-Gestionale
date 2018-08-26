<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
        $("#contenitore").load("form/prodotti/prodotti.php");
    });
</script>
<div class="container">
		<div class="row">
			<div class="col-xs-3">
			 <?php include("includes/menu_side.php");?>
		
			</div>
			<div class="col-xs-9">
				<!-- Page Content -->
				<div id="page-content-wrapper">
					<div class="page-header">
					  <h1>Prodotti</h1>
					</div>
					<div class="row">
							
								<div id="contenitore" class="col-xs-12"></div>
						
					</div>
				</div>
        </div>
</div>
</div>