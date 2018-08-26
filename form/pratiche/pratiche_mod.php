<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){


   var dataTable=$('.table-striped').DataTable({
    "processing": true,
        "serverSide": true,
        "ajax": "form/pratiche/server_processing.php",

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
        <?php if($_SESSION["livello"]=="10"){?>
            $(".pagato").bind("click", function(){
               $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"pagato"}, function(data){
                 $("#contenitore").empty().load("form/pratiche/pratiche.php");
               })
            });

            $(".invio").bind("click", function(){
               $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"invia_card"}, function(data){
                 $("#contenitore").empty().load("form/pratiche/pratiche.php");
               });
            });
                    
            $(".fattura").bind("click", function(){
            window.open("pdf/fattura_cliente.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
            });

            $(".visualizza").bind("click", function(){
            window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
            });

        <?php }?>
  } );


  $('.pratiche-input').on( 'keyup click change', function () {
     
      var i =$(this).attr('id');  // getting column index
      var v =$(this).val();  // getting search input value
      dataTable.columns(i).search(v).draw();
  } );


  $(".esportazione").bind("click", function(){
     $("#contenitore").empty().load("form/pratiche/pratiche.php");
  });


  $(".fattura").bind("click", function(){
    window.open("pdf/fattura_cliente.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
  });

  $(".visualizza").bind("click", function(){
    window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
  });

});
</script>

<table class="table table-striped table-bordered">
	<thead>

		<tr>
     <th class="pratica">Codice Pratica</th> 
    <?php if($_SESSION["id_utente"]=='058'){?>
       <th>Codice ID</th> 
    <?php } ?>
     <th>Cliente</th>
     <th class="agente">Agente</th>
     <th>Prodotto</th>
     <th class="data">Data inserimento</th>
     <th class="data">Data pagamento</th>
     <th class="data">Data attivazione</th>
     <th class="actions">&nbsp;</th>
		</tr>	
    <tr>
        <th><input type="text" id="0"  class="pratiche-input form-control pratica"></th>
        <?php if($_SESSION["id_utente"]=='058'){?>
             <th></th> 
        <?php } ?>
        <th><input type="text" id="1" class="pratiche-input form-control"></th>
        <th><input type="text" id="2" class="pratiche-input form-control agente" ></th>
        <th><input type="text" id="3" class="pratiche-input form-control" ></th>
        <th><input type="text" id="4" class="pratiche-input form-control data" ></th>
         <th><input type="text" id="5" class="pratiche-input form-control data" ></th>
        <th><input type="text" id="6" class="pratiche-input form-control data" ></th>
        <th></th>
    </tr>
	</thead>	
</table>