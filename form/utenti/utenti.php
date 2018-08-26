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
});

$('.table-striped tbody').on('click', '.edit', function () {
     $("#contenitore").empty().load("form/utenti/utente_modifica.php?id_utente="+$(this).attr('data-id'));
} );


$(".new").bind("click", function(){
	$("#contenitore").empty().load("form/utenti/utente_nuovo.php");
});


</script>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nome</th>
			<th>Login</th>
            <th>Ruolo</th>
            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php $sql="SELECT * FROM utenti LEFT JOIN tipo_utenti ON utenti.id_ruolo=tipo_utenti.id_tipo_contatto WHERE attivo";
		$res=mysql_query($sql);
		while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			<tr>
				<td><?php echo $rows["id_utente"];?></td>
				<td><?php echo utf8_encode($rows["nome"]);?></td>
                <td><?php echo utf8_encode($rows["login"]);?></td>
				<td><?php echo $rows["tipo_contatto"];?></td>
				<td><button type="button" class="btn btn-warning edit" data-id='<?php echo $rows[id_utente];?>'><i class="fa fa-edit" aria-hidden="true"></i></button></td>
			</tr>
		<?php }?>
	</tbody>	
</table>


<button type="button" class="btn btn-primary new">Nuovo agente</button>