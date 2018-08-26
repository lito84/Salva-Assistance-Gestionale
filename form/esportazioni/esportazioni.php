<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){


   $('.table-striped').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
            "order": [[ 0, "desc" ]],
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
     $(".download_tracciato").on("click", function(){
            window.open("/gestionale/esportazione_pagamenti.php?id_pagamento="+$(this).attr("data-esportazione"));
        });
} );


     $(".download_tracciato").on("click", function(){
            window.open("/gestionale/esportazione_pagamenti.php?id_pagamento="+$(this).attr("data-esportazione"));
        });
});



</script>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            
            <th>#ID</th>
            <th>Data esportazione</th>
            <th>&nbsp;</th>
        </tr>   
    </thead>
    <tbody>
    <?php 


        $sql="SELECT * FROM esportazioni ORDER BY esportazione DESC ";

        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
           

            <tr>
               
                <td><?php echo utf8_encode($rows["id_esportazione"]);?></td>
               <td><?php echo date("d-m-Y H:i", strtotime($rows["esportazione"]));?></td>
                <td>
                <button title="Esportazione" data-esportazione="<?php echo $rows['id_esportazione'];?>" class="btn btn-info download_tracciato"><i class="fa fa-reply" aria-hidden="true"></i>
                </button>

                </td>
            </tr>
        <?php }?>
    </tbody>    
</table>