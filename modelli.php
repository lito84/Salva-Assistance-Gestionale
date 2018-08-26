<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
        $("#contenitore").load("form/modelli/modelli.php");
        $(".loading").hide();
    });
</script>
 <div id="wrapper">
 <?php include("includes/menu_side.php");?>
       
        <!-- Page Content -->
        <div id="page-content-wrapper">
        	<div class="container-fluid">
				<div class="page-header">
				  <h1>Modelli</h1>
				</div>
					<div class="row">
						<div id="contenitore" class="col-xs-12"></div>
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw loading"></i>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
        </div>
</div>

