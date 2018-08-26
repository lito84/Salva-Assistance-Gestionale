<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){


$(".edit").bind("click", function(){
  
    $("#contenitore").empty().load("form/modelli/modello_modifica.php?id_modello="+$(this).attr('data-id'));
});

});

</script>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			     <th>#</th>
            <th>Modello</th>
            

            <th>&nbsp;</th>
		</tr>	
    </thead>
    <tbody>
    <?php $sql="SELECT * FROM templates_email WHERE 1";
          $res=mysql_query($sql);
          while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <tr>
              <td><?php echo utf8_encode($rows["id_template"]);?></td>
              
              <td><?php echo utf8_encode($rows["nome"]);?></td>
              <td>
              <button title="Modifica" data-id="<?php echo $rows['id_template'];?>" class="btn_grid btn-warning edit"><i class="fa fa-pencil" aria-hidden="true" title="Modifica"></i></button>
              
        </td>
          </tr>
    <?php } ?>
	
	
	</tbody>	
</table>

<button type="button" class="btn btn-primary new">Nuovo Modello</button>