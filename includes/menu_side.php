<?php include("includes/mysql.inc.php");?>
<?php include("includes/auth.inc.php");?>
 <!-- Sidebar -->
        <div class="sidebar">
            <ul class="sidebar-nav">

              <li class="logged"><span>Bentornato <strong><?php echo $_SESSION["user_name"];?></strong></span>
              <span>Ultimo accesso:</span>
              <span> <?php echo $_SESSION["user_logindate"];?></span></li>
              <li><a href="main.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>

            <?php $sql="SELECT * FROM menu_nav WHERE livello <= '$_SESSION[livello]' AND attivo";
          
                  $res=mysql_query($sql);
                  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
                

                  <?php if($rows["etichetta"]=="Vendite"){
                        $sql1="SELECT * FROM utenti WHERE id_utente = '$_SESSION[id_utente]'";

                        $res1=mysql_query($sql1);
                        $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
                          if($rows1["vendita"]=="1"){?>
                            <li><a href="<?php echo $rows["link"];?>"><i class="fa <?php echo $rows["icona"];?>" aria-hidden="true"></i> <?php echo $rows["etichetta"];?></a></li>
                          <?php }
                        }else{?>
                           <li><a href="<?php echo $rows["link"];?>"><i class="fa <?php echo $rows["icona"];?>" aria-hidden="true"></i> <?php echo $rows["etichetta"];?></a></li>
                      <?php }
                      }?>
             
              <li><a href="logout.php"><i class="fa fa-user-slash" aria-hidden="true"></i> Esci</a></li>
            </ul>
          </div>


        

        <!-- /#sidebar-wrapper -->


