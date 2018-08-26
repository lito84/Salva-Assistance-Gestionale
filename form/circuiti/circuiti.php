<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){


   $('.table-striped').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
            columnDefs: [
             { type: 'date-eu', targets: 5 }
           ],
             "bSort": false,
            "language": 
          {
    "sEmptyTable":     "Nessun dato presente nella tabella",
    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
    "sInfoPostFix":    "",
    "sInfoThousands":  ",",
    "sLengthMenu":     "Visualizza _MENU_ elementi",
    "sLoadingRecords": "Caricamento...",
    "sProcessing":     "Elaborazione...",
    "sSearch":         "Cerca:",
     "sPrint":         "Stampa",
    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
    "oPaginate": {
        "sFirst":      "Inizio",
        "sPrevious":   "Precedente",
        "sNext":       "Successivo",
        "sLast":       "Fine"
    },
    "oAria": {
        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
    }
    }
        });

$('.table-striped').on( 'draw.dt', function () {
    $(".edit").bind("click", function(){
      $("#contenitore").empty().load("form/circuiti/circuito_modifica.php?id_circuito="+$(this).attr('data-id'));
    });  

    $(".fa-file-pdf-o").on("click", function(){
      window.open($(this).attr("data-link"));
    });

     $(".strutture").bind("click", function(){
      $("#contenitore").empty().load("form/circuiti/circuito_strutture.php?id_circuito="+$(this).attr('data-id'));
    });  

} );

$(".new").bind("click", function(){
    $("#contenitore").empty().load("form/circuiti/circuito_nuovo.php");
});

$(".edit").bind("click", function(){
  $("#contenitore").empty().load("form/circuiti/circuito_modifica.php?id_circuito="+$(this).attr('data-id'));
});

 $(".strutture").bind("click", function(){
  $(".loading").show();
  $("#contenitore").empty().load("form/circuiti/circuito_strutture.php?id_circuito="+$(this).attr('data-id'));
});


$(".fa-file-pdf-o").on("click", function(){
  window.open($(this).attr("data-link"));
});

});

</script>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			     <th>#</th>
            <th>Circuito</th>
            
			     <th>Nominativo Convenzione</th>
			     <th>Email</th>
            <th>Telefono</th>
            <th>Tariffario</th>
            <th>&nbsp;</th>
		</tr>	
    </thead>
    <tbody>
    <?php $sql="SELECT * FROM circuiti WHERE 1";
          $res=mysql_query($sql);
          while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <tr>
              <td><?php echo utf8_encode($rows["id_circuito"]);?></td>
              
              <td><?php echo utf8_encode($rows["circuito"]);?></td>
              <td><?php echo utf8_encode($rows["responsabile"]);?></td>
              <td><?php echo utf8_encode($rows["email"]);?></td>
              <td><?php echo utf8_encode($rows["telefono"]);?></td>
              <td><?php if($rows["tariffario_pdf"]!=""){?>
              <i class="fa fa-file-pdf-o" data-link="<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $rows["tariffario_pdf"];?>"></i>
              <?php }?></td>
              <td>
              <button title="Modifica" data-id="<?php echo $rows['id_circuito'];?>" class="btn btn-warning edit"><i class="fa fa-pencil" aria-hidden="true" title="Modifica"></i></button>
              <button title="Strutture circuito" data-id="<?php echo $rows['id_circuito'];?>" class="btn btn-info strutture"><i class="fa fa-cubes" aria-hidden="true" title="Strutture circuito"></i></button>
        </td>
          </tr>
    <?php } ?>
	
	
	</tbody>	
</table>

<button type="button" class="btn btn-primary new">Nuovo Circuito</button>