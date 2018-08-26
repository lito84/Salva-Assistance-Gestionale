<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
		$('.table-striped').DataTable({
            "lengthMenu": [[50,100, -1], [50, 100, "Tutte"]],
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



$('.table-striped tbody').on('click', '.delete', function () {
     
     $.post("actions/strutture.php",{id_struttura:$(this).attr('data-id'), action:"cancella_da_contattare"}, function(data){
         $("#contenitore").load("form/strutture_confermare/strutture_confermare.php");
     });

} );

$('.table-striped').on( 'draw.dt', function () {
     
} );



});


</script>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Ragione Sociale</th>
			<th>Citta</th>
            <th>Prov</th>
			<th>Indirizzo</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Referente</th>
            <th>Provenienza</th>
            <th>Strutture aggiuntive</th>
            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php 
    $sql="SELECT * FROM anagrafica_salute_semplice WHERE stato<>'Convenzione chiusa' AND stato<>'Non interessato'";
    $res=mysql_query($sql);
	while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

            $data_stato="";
            if($rows["data_stato"]!=""){
                $data_stato=date("d/m/Y H:i", strtotime($rows["data_stato"]));
            }
            ?>
			<tr>
				<td><?php echo utf8_encode($rows["struttura"]);?></td>
				<td><?php echo utf8_encode($rows["citta"]);?></td>
				<td><?php echo $rows["pr"];?></td>
                <td><?php echo utf8_encode($rows["indirizzo"]);?></td>
                <td><a href="tel:<?php echo $rows["telefono"];?>"><?php echo $rows["telefono"];?></a></td>
                 <td><a href="mailto:<?php echo $rows["email"];?>"><?php echo $rows["email"];?></a></td>
                 <td><?php echo utf8_encode($rows["referente"]);?></td>
                 <td><?php echo utf8_encode($rows["provenienza"]);?></td>
                 <td><?php echo utf8_encode($rows["strutture_aggiuntive"]);?></td>
                
                <td class="actions">
                <a href="strutture_da_confermare_dettaglio.php?id_struttura=<?php echo $rows["id_struttura"];?>"" target="_blank"><button data-id="<?php echo $rows['id_struttura'];?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                
                <button data-id="<?php echo $rows['id_struttura'];?>" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button>
                </td>
			</tr>
		<?php }?>
	</tbody>	
</table>