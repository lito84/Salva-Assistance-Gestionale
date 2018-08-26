<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
    	<?php if(isset($_GET["tutte"])){?>

        $("#contenitore").load("form/convenzioni/convenzioni.php?tutte");
        <?php } else { ?>
        $("#contenitore").load("form/convenzioni/convenzioni.php");	
    	<?php }?>
    });
</script>
<div class="container">
        <div class="row">
            <div class="col-xs-12">
                <!-- Page Content -->
                <div id="page-content-wrapper">


                    <div class="row">
                      <div class="col-xs-12 col-sm-3 grey">
                        <h4><a href="<?php echo $p_sito;?>main.php"><i class="fa fa-home"></i> Torna alla home</a></h4>
                      </div>

                      <div class="col-xs-12 col-sm-9 blue">
                        <h4>Convenzioni</h4>
                      </div>
                      <div class="col-xs-12"><p>&nbsp;</p></div>
                    </div>


					<div class="row">
							
								<div id="contenitore" class="col-xs-12"></div>
						
					</div>
				</div>
        </div>
</div>

