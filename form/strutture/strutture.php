<?php include("../../includes/mysql.inc.php");?>
<style>
    th.pr{
        width:150px!important;
    }
</style>
<script>
$(document).ready(function(){
		var table= $('.table-striped').DataTable({
        "sAjaxSource": "form/strutture/strutture_dati.php",
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
            },
            dom: 'Bfrtip',
             buttons: [
                {
                    extend: 'copyHtml5',
                    text:"Copia tabella",
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text:"Mostra/Nascondi colonne",
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
    });

    $('.table-striped tfoot th').each( function () {
        
        var title = $(this).text();
        if(title!=""){
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
        
    } ); 



    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});


$('.table-striped tbody').on('click', '.delete', function () {
     
     $.post("actions/strutture.php",{id_struttura:$(this).attr('data-id'), action:"cancella_da_contattare"}, function(data){
         $("#contenitore").load("form/strutture/strutture.php");
     });
} );

$('.table-striped tbody').on('click', '.edit', function () {
     
     $.post("actions/strutture.php",{id_struttura:$(this).attr('data-id'), action:"cancella_da_contattare"}, function(data){
         $("#contenitore").load("form/strutture/strutture.php");
     });
} );


$(".new").bind("click", function(){
    $("#contenitore").empty().load("form/strutture/struttura_nuova_migliorsalute.php");
});


</script>


<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Ragione Sociale</th>
            <th>Citta</th>
            <th class="pr">Pr / Regione</th>
            <th>Contatti</th>
            <th>Circuiti</th>
            <th>Nominativo Convenzione</th>
            <th>Provenienza</th>
            <th>Stato / Data stato</th>
             <th>Note</th>
            <th class="actions"></th>
            
        </tr>   
    </thead>
    <tbody>
   
    </tbody>    
    <tfoot>
        <tr>
            <th>Ragione Sociale</th>
            <th>Citta</th>
            <th class="pr">Pr / Regione</th>
            <th>Contatti</th>
            <th>Circuiti</th>
            <th>Nominativo Convenzione</th>
            <th>Provenienza</th>
            <th>Stato / Data stato</th>
             <th>Note</th>
            <th class="actions"></th>
            
        </tr>   
    </tfoot>
        
</table>


<button type="button" class="btn btn-primary new">Nuova Struttura</button>