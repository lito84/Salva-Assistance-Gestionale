<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){


   $('.table-striped').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
            "order": [[ 5, "desc" ]],
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
       $(".dettaglio").bind("click", function(){
        $("#contenitore").empty().load("form/codici/dettaglio_codici.php?id_lotto="+$(this).attr("data-id"));
    });
} );


    $(".dettaglio").bind("click", function(){
        $("#contenitore").empty().load("form/codici/dettaglio_codici.php?id_lotto="+$(this).attr("data-id"));
    });

     $(".esportazione").bind("click", function(){
      window.open("esportazione_codici.php?id_lotto="+$(this).attr("data-id"),"_blank");
    });
});



</script>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            
            <th>Lotto</th>
            <th>Agente</th>
            <th>Data inserimento</th>
            <th>Prodotto</th>
            <th># Codici</th>

            <th>&nbsp;</th>
        </tr>   
    </thead>
    <tbody>
    <?php 


        $sql="SELECT * FROM convenzioni_prodotti_codici_lotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = convenzioni_prodotti_codici_lotti.id_prodotto_convenzione LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente ";
if($_SESSION["id_ruolo"]!="01"){
            $sql.="AND convenzioni.id_utente='$_SESSION[id_utente]'";
        }

        $sql.=" ORDER BY data_inserimento DESC";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
            
            <?php 
                $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows["data_inserimento"])) : $data_inserimento="";
            
                $sql1="SELECT * FROM prodotti WHERE prodotti.id_prodotto=$rows[id_prodotto]";
                $res1=mysql_query($sql1);
                $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);    
            ?>

            <tr>
               
                <td><?php echo utf8_encode($rows["lotto"]);?></td>
               <td><?php echo utf8_encode($rows["nome"]);?></td>
                <td><?php echo $data_inserimento;?></td>
            
                <td><?php echo utf8_encode($rows1["prodotto"]);?></td>
                <td><?php echo utf8_encode($rows["quantita"]);?></td>
                <td>
                <button title="Dettaglio lotto" data-id="<?php echo $rows['id_lotto'];?>" class="btn btn-info dettaglio"><i class="fa fa-binoculars" aria-hidden="true"></i>
</button>
<button title="Esportazione" data-id="<?php echo $rows['id_lotto'];?>" class="btn btn-success esportazione"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
</button>

                </td>
            </tr>
        <?php }?>
    </tbody>    
</table>