<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php 
  $url="form/estratto-conto/server_processing.php";
  if(isset($_GET["dal"])) $url.="?dal=".$_GET["dal"];
  if(isset($_GET["al"])) $url.="&al=".$_GET["al"];
?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>


$(document).ready(function(){
  
   var dataTable=$('.table-striped').DataTable({
   
    "bInfo" : false,
    "processing": true,
        "serverSide": true,
        "ajax": "<?php echo $url;?>",

            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
             "bSort": true,
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


        $(".visualizza").bind("click", function(){
           $("#contenitore").empty().load("form/estratto-conto/estratto-conto-dettaglio.php?codice_decade="+$(this).attr("data-decade"));
        });

        $(".stampa").bind("click", function(){
           window.open("pdf/tcpdf/doc/estratto-conto-agente.php?codice_decade="+$(this).attr("data-decade")+"&id_agente="+$(this).attr("data-agente"),"_blank");
          
        });
    });
});
</script>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
     <th class="agente">Codice Decade</th>
     <th class="decade">Periodo</th>
     <th class="agente">Incasso</th>
      <th class="agente">Imponibile</th>
     <th class="provvigioni">Provvigioni</th>
     <th class="iva_provvigioni">IVA Provvigioni</th>
     <th class="ritenuta">Ritenuta</th>
     <th class="ritenuta">Da Versare</th>
     <th class="actions">&nbsp;</th>
    </tr> 
    <thead>  
</table>

<hr />