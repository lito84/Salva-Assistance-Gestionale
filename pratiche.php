<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>

<script>
    $(document).ready(function(){
        $("#contenitore").load("form/pratiche/pratiche.php");  
    	
        $(".btn-pagato").on("click", function(){
        	 $("#contenitore").empty().load("form/pratiche/pratiche.php?pagato");  
        });

        $(".btn-secondo-codice").on("click", function(){
        	 $("#contenitore").empty().load("form/pratiche/pratiche.php?secondo");  
        });

        $(".ricerca").on("click", function(){
             $("#contenitore").empty().load("form/pratiche/pratiche.php?dal="+jQuery("#dal").val()+"&al="+jQuery("#al").val());  
        });

        $(".oggi").on("click", function(){
             $("#contenitore").empty().load("form/pratiche/pratiche.php?oggi");  
        });

        $(".tutte").on("click", function(){
        	 $("#contenitore").empty().load("form/pratiche/pratiche.php");  
        });
       
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
                        <h4>Contratti</h4>
                      </div>
                      <div class="col-xs-12"><p>&nbsp;</p></div>
                    </div>

                    <div class="row">
                        
                         <div class="col-xs-2">
                           <label>Dal</label><input type="text" id="dal" name="dal" class="form-control" placeholder="gg/mm/aaaa" />
                         </div>
                         <div class="col-xs-2">
                          <label>Al</label><input type="text" id="al" name="al" class="form-control" placeholder="gg/mm/aaaa" />
                         </div>
                         <div class="col-xs-1">
                            <label></label>
                            <button class="btn btn-primary ricerca">Ricerca</button>
                         </div>

                         <div class="col-xs-2">
                            <label></label>
                            <button class="btn btn-primary oggi">Pratiche odierne</button>
                         </div>
                         <div class="col-xs-2">
                            <label></label>
                            <button class="btn btn-primary tutte">Tutte le Pratiche</button>
                         </div>
                         <div class="col-xs-12">
                             <hr />
                         </div>
                                <div id="contenitore" class="col-xs-12">
                                                     
                                </div>
                    </div>
                    
                </div>

                </div>
        </div>
</div>
</div>
<?php include("includes/footer.php");?>
