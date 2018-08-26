<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");
$sql="SELECT id_convenzione FROM  utenti  WHERE attivo AND utenti.id_utente = '$_SESSION[id_utente]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC)
?>
<script>
$(document).ready(function(){


    $("#contenitore").empty().load("form/vendite/convenzione_vendita.php?id_convenzione=<?php echo $rows["id_convenzione"];?>");
	/*$('.table-striped').DataTable({
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
        $("#contenitore").empty().load("form/vendite/convenzione_vendita.php?id_convenzione="+$(this).attr('data-id'));
    });       
} );


$(".edit").bind("click", function(){
    $("#contenitore").empty().load("form/vendite/convenzione_vendita.php?id_convenzione="+$(this).attr('data-id'));
});*/

});
</script>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Codice</th>
			<th>Descrizione</th>
			<th>Utente</th>
            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php $sql="SELECT * FROM convenzioni LEFT JOIN utenti ON convenzioni.id_utente=utenti.id_utente WHERE attivo AND convenzioni.id_utente = '$_SESSION[id_utente]'";
		$res=mysql_query($sql);
		while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			<tr>
				<td><?php echo $rows["codice_convenzione"];?></td>
				<td><?php echo utf8_encode($rows["descrizione"]);?></td>
				<td><?php echo utf8_encode($rows["nome"]);?></td>
				<td><button data-id="<?php echo $rows['id_convenzione'];?>" class="btn btn-warning edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
			</tr>
		<?php }?>
	</tbody>	
</table>