<?php include("includes/auth.inc.php");?>
<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
			 <?php include("includes/menu_side.php");?>
		
			</div>
			<div class="col-xs-9">
				<!-- Page Content -->
				<div id="page-content-wrapper">
						<div class="row">

						<?php if($_SESSION["livello"]<10):?>	
							<div class="col-xs-12 col-sm-6">
								<div class="widget widget_main">
									<div class="widget_number">
										1
									</div>
									<h3>Crea il contratto</h3>
									<p>Inizia inserendo i dati di invitante e invitato, il tipo di copertura e la durata del contratto</p>

									<a data-role="button" href="vendite.php" class="btn btn-white btn-lg">Nuovo contratto</a>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6">
								<div class="widget widget_main">
									<div class="widget_number">
										2
									</div>
									<h3>Carica il contratto</h3>
									<p>Una volta stampato e firmato, carica il contratto per archiviarlo correttamente</p>
									<a data-role="button" href="pratiche.php" class="btn btn-white btn-lg">Carica contratto</a>
								</div>
							</div>
						
						<?php endif;?>

						<div class="col-xs-12">

							<div class="ultime_pratiche"></div>
						
						</div>
						</div>	
					
				</div>
			</div>
		</div>

</div>
<?php include("includes/footer.php");?>

<script type="text/javascript">
	$(".ultime_pratiche").load("form/pratiche/ultime_pratiche.php");
</script>