<?php include("../../includes/mysql.inc.php");
      include("../../includes/parameters.php");
?>
<script>
$(document).ready(function(){

  $("#prodotto").select2({
    width:200
  });
    $('.table-striped').DataTable({
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

              $(".btn-trash").bind("click", function(){
                var id=$(this).attr("data-id");
                $.post("actions/convenzioni.php",{id:id, action:"elimina_prodotto"}, function(data){
                  $(".tabella_prodotti_container").empty().load("form/convenzioni/convenzioni_prodotti.php?id_convenzione=<?php echo $_GET["id_convenzione"];?>");  
                });

                  $(".btn-tariffario").bind("click", function(){
                    var id=$(this).attr("data-id");
                    $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/tariffario.php?id_convenzione_prodotto="+$(this).attr("data-id"));
                  }); 
    
            });

              




      } );

  $(".btn-tariffario").bind("click", function(){
    var id=$(this).attr("data-id");
    $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/tariffario.php?id_convenzione_prodotto="+$(this).attr("data-id"));
  }); 

 

  $(".btn-trash").bind("click", function(){
    var id=$(this).attr("data-id");
    $.post("actions/convenzioni.php",{id:id, action:"elimina_prodotto"}, function(data){
      $(".tabella_prodotti_container").empty().load("form/convenzioni/convenzioni_prodotti.php?id_convenzione=<?php echo $_GET["id_convenzione"];?>");  
    });
    
  })

  

});
</script>
<?php $sql="SELECT * FROM convenzioni_prodotti LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto= convenzioni_prodotti.id_prodotto WHERE convenzioni_prodotti.id_convenzione='$_GET[id_convenzione]' AND eliminato='0'";

$res=mysql_query($sql);

$fatturazione=$rows["fatturazione"];
?>

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID Prodotto</th>
      <th>Prodotto</th>
      <th>&nbsp;</th>
    </tr> 
  </thead>
  <tbody>
  <?php  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
      <tr>
        <td><?php echo $rows["id_convenzione_prodotto"];?></td>
        <td><?php echo $rows["prodotto"];?></td>
        
        <?php /*
        <td><input type="text" data-id="<?php echo $rows["id_convenzione_prodotto"];?>" class="percentuale_sconto" value="<?php echo $rows["percentuale_sconto"];?>" /></td> */?>
        <td class="actions">

          <button title="Tariffario" data-id="<?php echo $rows["id_convenzione_prodotto"];?>" class="btn_grid btn-success btn-tariffario"><i class="fa fa-euro-sign" aria-hidden="true"></i></button>
         <button title="Elimina" data-id="<?php echo $rows["id_convenzione_prodotto"];?>" class="btn_grid btn-danger btn-trash"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
      </tr>
    <?php }?>
  </tbody>  
</table>

<hr />
<div class="prodotti_convenzione_dettaglio"></div>

<hr />

