<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){

     $('.clienti').on( 'keyup click change', function () {
     
      var i =$(this).attr('id');  // getting column index
      var v =$(this).val();  // getting search input value
      dataTable.columns(i).search(v).draw();
   } );


    var dataTable=$('.table-striped').DataTable({
    "bInfo" : false,
    "processing": true,
        "serverSide": true,
        "ajax": "form/clienti/server_processing.php",

            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
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
                $("#contenitore").empty().load("form/clienti/cliente_modifica.php?id_cliente="+$(this).attr('data-id'));
            }); 
    } );
    $(".edit").bind("click", function(){
        $("#contenitore").empty().load("form/clienti/cliente_modifica.php?id_cliente="+$(this).attr('data-id'));
    }); 

    


});



</script>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
      <td>Invitato</td>
      <td>Agente</td>
      <td>Telefono</td>
      <td>Email</td>
      <td></td>
		</tr>
    <tr>
        <th><input type="text" id="0" class="clienti form-control"></th>
        <th><input type="text" id="1" class="clienti form-control"></th>
        <th><input type="text" id="2" class="clienti form-control" ></th>
        <th><input type="text" id="3" class="clienti form-control" ></th>
        <th></th>
    </tr>	     	
	</thead>
</table>