<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
		$('.table-striped').DataTable({
        
        "sAjaxSource": "form/strutture/strutture_dati_migliorsorriso.php",
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
});


$('.table-striped tbody').on('click', '.delete', function () {
     
     $.post("actions/strutture.php",{id_struttura:$(this).attr('data-id'), action:"cancella_da_contattare"}, function(data){
         $("#contenitore").load("form/strutture/strutture_migliorsorriso.php");
     });
} );

$('.table-striped tbody').on('click', '.edit', function () {
     
     $.post("actions/strutture.php",{id_struttura:$(this).attr('data-id'), action:"cancella_da_contattare"}, function(data){
         $("#contenitore").load("form/strutture/strutture_migliorsorriso.php");
     });
} );


$(".new").bind("click", function(){
    $("#contenitore").empty().load("form/strutture/struttura_nuova.php");
});


</script>


<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Ragione Sociale</th>
            <th>Citta</th>
            <th>Provincia</th>
            <th>Telefono</th>
            <th>Regione</th>
            <th class="actions"></th>
            
        </tr>   
    </thead>
    <tbody>
   
    </tbody>    
</table>


<button type="button" class="btn btn-primary new">Nuova Struttura</button>