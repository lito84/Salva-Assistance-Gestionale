<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
		$('.table-striped').DataTable({
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
            $(".new").bind("click", function(){
                $("#contenitore").empty().load("form/convenzioni/convenzione_nuova.php");
            });
            $(".edit").bind("click", function(){
                $("#contenitore").empty().load("form/convenzioni/convenzione_modifica.php?id_convenzione="+$(this).attr('data-id'));
            });       
        } );


$(".new").bind("click", function(){
	$("#contenitore").empty().load("form/convenzioni/convenzione_nuova.php");
});
$(".edit").bind("click", function(){
    $("#contenitore").empty().load("form/convenzioni/convenzione_modifica.php?id_convenzione="+$(this).attr('data-id'));
});

});
</script>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Codice</th>
			<th>Descrizione</th>
			
            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php 

        $sql="SELECT * FROM convenzioni WHERE attiva ";
        $res=mysql_query($sql);
		while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			<tr>
				<td><?php echo $rows["codice_convenzione"];?></td>
				<td><?php echo utf8_encode($rows["descrizione"]);?></td>
				
				<td><button data-id="<?php echo $rows['id_convenzione'];?>" class="btn btn-warning edit"><i class="fa fa-edit" aria-hidden="true"></i></button></td>
			</tr>
		<?php }?>
	</tbody>	
</table>


<button type="button" class="btn btn-primary new">Nuova convenzione</button>