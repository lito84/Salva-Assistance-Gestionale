<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){


   $('.table-codici').DataTable({
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

$('.table-codici').on( 'draw.dt', function () {
    
    

} );

});
     



</script>

<?php $sql="SELECT * FROM convenzioni_prodotti_codici_lotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = convenzioni_prodotti_codici_lotti.id_prodotto_convenzione LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE convenzioni_prodotti_codici_lotti.id_lotto='$_GET[id_lotto]'";
      $res=mysql_query($sql);
      $rows=mysql_fetch_array($res, MYSQL_ASSOC);?>

      <div class="bs-callout bs-callout-info">
  <h4><?php echo $rows["lotto"];?></h4>
  <?php echo utf8_encode($rows["nome"]);?>

</div>

<table class="table table-striped table-bordered table-codici">
    <thead>
        <tr>
            
            <th>Codice attivazione</th>
            <th>Data inserimento</th>
            <th>Data attivazione</th>
            <th>Prodotto</th>
            
           
        </tr>   
    </thead>
    <tbody>
    <?php 


        $sql1="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = pratiche.id_prodotto_convenzione WHERE id_lotto = '$_GET[id_lotto]'";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
            
            <?php 
                $data_inserimento = ($rows1['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows1["data_inserimento"])) : $data_inserimento="";
                $data_attivazione = ($rows1['data_attivazione'] != '') ? $data_attivazione=date("d/m/Y", strtotime($rows1["data_attivazione"])) : $data_attivazione="";
            
                $sql2="SELECT * FROM prodotti WHERE prodotti.id_prodotto=$rows1[id_prodotto]";
                $res2=mysql_query($sql2);
                $rows2=mysql_fetch_array($res2, MYSQL_ASSOC);    
            ?>

            <tr>
               
                <td><?php echo utf8_encode($rows1["codice_attivazione"]);?></td>
               <td><?php echo $data_inserimento;?></td>
                <td><?php echo $data_attivazione;?></td>
            
                <td><?php echo utf8_encode($rows2["prodotto"]);?></td>
               
            </tr>
        <?php }?>
    </tbody>    
</table>