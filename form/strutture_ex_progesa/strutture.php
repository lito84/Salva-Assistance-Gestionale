<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
		var table= $('.table-striped').DataTable({
        
        "sAjaxSource": "form/strutture_ex_progesa/strutture_dati.php",
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

    $('.table-striped tfoot th').each( function () {
        
        var title = $(this).text();
        if(title!=""){
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
        
    } ); 

     $('.table-striped thead th').each( function () {
        
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

     // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});
    
</script>
<table class="table table-striped table-bordered">
<thead>
    <tr>
        <th>Ragione Sociale</th>
        <th>Citta</th>
        <th>Provincia</th>
        <th>Email</th>
        <th>Telefono</th>
        <th>Regione</th>
        
        <th>Provenienza</th>
        <th>Stato</th>
        <th class="actions"></th>
    </tr>   
</thead>
<tbody>

</tbody>  
<tfoot>
    <tr>
        <th>Ragione Sociale</th>
        <th>Citta</th>
        <th>Provincia</th>
        <th>Email</th>
        <th>Telefono</th>
        <th>Regione</th>
        
        <th>Provenienza</th>
        <th>Stato</th>
        <th class="actions"></th>
    </tr>  

</tfoot>  
</table>