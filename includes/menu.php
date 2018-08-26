<?php include("includes/mysql.inc.php");?>
<?php include("includes/auth.inc.php");?>
<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i>
</a> 
          <div class="navbar-header">
           
            <a class="navbar-brand" href="<?php echo $p_sito;?>/main.php"><img class="logo" src="<?php echo $p_logo;?>" title="<?php echo $p_ragione_sociale;?>"/></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            

           

             </div><!--/.nav-collapse -->
        </div>
      </nav>
       <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>